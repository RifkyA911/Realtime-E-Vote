<?php
/**
 * Simple E-Vote - Lightweight Standalone WebSocket Server (RFC 6455)
 *
 * Runs on PHP CLI to provide instant real-time live vote counts and broadcasts.
 * Compatible with any standard modern web browser WebSocket client.
 *
 * Usage:
 *   php websocket_server.php [port]
 * Default port: 8080
 */

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

$host = '0.0.0.0';
$port = isset($argv[1]) ? (int)$argv[1] : 8088;

// Database Configuration (defaults matching XAMPP / .env)
$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = '';
$db_name = 'e_vote';

// Load .env if present
$env_file = __DIR__ . '/.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $val) = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val);
            if ($key === 'DB_HOST') $db_host = $val;
            if ($key === 'DB_USER') $db_user = $val;
            if ($key === 'DB_PASS') $db_pass = $val;
            if ($key === 'DB_NAME') $db_name = $val;
        }
    }
}

function get_db_connection() {
    global $db_host, $db_user, $db_pass, $db_name;
    static $mysqli = null;
    if ($mysqli !== null && @$mysqli->ping()) {
        return $mysqli;
    }
    $mysqli = @new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
        return null;
    }
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}

function fetch_live_stats() {
    $db = get_db_connection();
    if (!$db) {
        return null;
    }

    // Voters stats
    $total_voters = 0;
    $total_voted = 0;
    $res = $db->query("SELECT COUNT(*) AS total, SUM(CASE WHEN has_voted = 1 THEN 1 ELSE 0 END) AS voted FROM voters");
    if ($res && $row = $res->fetch_assoc()) {
        $total_voters = (int)$row['total'];
        $total_voted = (int)$row['voted'];
    }
    $total_unvoted = $total_voters - $total_voted;
    $participation_rate = ($total_voters > 0) ? round(($total_voted / $total_voters) * 100, 1) : 0;

    // Total votes cast
    $total_votes_res = $db->query("SELECT COUNT(*) AS total FROM votes");
    $total_ballots = ($total_votes_res && $row = $total_votes_res->fetch_assoc()) ? (int)$row['total'] : $total_voted;

    // Candidates
    $candidates = array();
    $c_res = $db->query("SELECT c.*, COUNT(v.id) AS total_votes FROM candidates c LEFT JOIN votes v ON c.id = v.candidate_id GROUP BY c.id ORDER BY c.candidate_number ASC");
    if ($c_res) {
        while ($c = $c_res->fetch_assoc()) {
            $votes = (int)$c['total_votes'];
            $pct = ($total_ballots > 0) ? round(($votes / $total_ballots) * 100, 1) : 0;
            $c['total_votes'] = $votes;
            $c['percentage'] = $pct;
            $candidates[] = $c;
        }
    }

    // Recent 5 votes
    $recent = array();
    $r_res = $db->query("SELECT v.id, v.voted_at, vt.name AS voter_name, vt.voter_code, c.candidate_number, c.chairman_name, c.color 
                         FROM votes v 
                         JOIN voters vt ON v.voter_id = vt.id 
                         JOIN candidates c ON v.candidate_id = c.id 
                         ORDER BY v.id DESC LIMIT 5");
    if ($r_res) {
        while ($r = $r_res->fetch_assoc()) {
            $recent[] = $r;
        }
    }

    return array(
        'type'               => 'live_stats',
        'server_time'        => date('Y-m-d H:i:s'),
        'total_voters'       => $total_voters,
        'total_voted'        => $total_voted,
        'total_unvoted'      => $total_unvoted,
        'participation_rate' => $participation_rate,
        'candidates'         => $candidates,
        'recent_votes'       => $recent
    );
}

// WebSocket Frame Encoder (RFC 6455)
function encode_ws_frame($payload, $type = 'text') {
    $b1 = 0x80 | ($type === 'text' ? 0x1 : 0x2);
    $length = strlen($payload);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length <= 65535) {
        $header = pack('CCn', $b1, 126, $length);
    } else {
        $header = pack('CCNN', $b1, 127, ($length >> 32) & 0xFFFFFFFF, $length & 0xFFFFFFFF);
    }

    return $header . $payload;
}

// WebSocket Frame Decoder
function decode_ws_frame($data) {
    if (strlen($data) < 2) return null;
    $secondByte = ord($data[1]);
    $masked = ($secondByte & 0x80) !== 0;
    $payloadLength = $secondByte & 0x7F;
    $offset = 2;

    if ($payloadLength === 126) {
        if (strlen($data) < 4) return null;
        $payloadLength = unpack('n', substr($data, 2, 2))[1];
        $offset = 4;
    } elseif ($payloadLength === 127) {
        if (strlen($data) < 10) return null;
        $payloadLength = unpack('J', substr($data, 2, 8))[1];
        $offset = 10;
    }

    if ($masked) {
        if (strlen($data) < $offset + 4) return null;
        $mask = substr($data, $offset, 4);
        $offset += 4;
        $payload = substr($data, $offset, $payloadLength);
        $unmasked = '';
        for ($i = 0; $i < strlen($payload); $i++) {
            $unmasked .= $payload[$i] ^ $mask[$i % 4];
        }
        return $unmasked;
    } else {
        return substr($data, $offset, $payloadLength);
    }
}

// Start Stream Server
$server = stream_socket_server("tcp://{$host}:{$port}", $errno, $errstr);
if (!$server) {
    echo "[!] Error starting WebSocket server: {$errstr} ({$errno})\n";
    exit(1);
}

echo "========================================================\n";
echo "  Simple E-Vote - Real-Time WebSocket Server (RFC 6455)\n";
echo "  Listening on ws://{$host}:{$port}\n";
echo "  Connected to MySQL Database '{$db_name}'\n";
echo "  Started at: " . date('Y-m-d H:i:s') . "\n";
echo "========================================================\n";

$clients = array();
$handshakes = array();
$last_broadcast = 0;
$last_stats_hash = '';

while (true) {
    $read = array_merge(array($server), $clients);
    $write = null;
    $except = null;

    // Wait for activity with 1 sec timeout
    $changed = @stream_select($read, $write, $except, 1, 0);

    if ($changed === false) {
        continue;
    }

    // New connection
    if (in_array($server, $read)) {
        $new_socket = @stream_socket_accept($server);
        if ($new_socket) {
            $socket_id = (int)$new_socket;
            $clients[$socket_id] = $new_socket;
            $handshakes[$socket_id] = false;
            echo "[" . date('H:i:s') . "] [+] New incoming connection (ID: #{$socket_id})\n";
        }
        $key = array_search($server, $read);
        unset($read[$key]);
    }

    // Handle client data
    foreach ($read as $socket) {
        $socket_id = (int)$socket;
        $data = @fread($socket, 4096);

        if ($data === false || strlen($data) === 0) {
            // Client disconnected
            echo "[" . date('H:i:s') . "] [-] Client disconnected (ID: #{$socket_id})\n";
            @fclose($socket);
            unset($clients[$socket_id]);
            unset($handshakes[$socket_id]);
            continue;
        }

        // Perform RFC 6455 handshake
        if (!$handshakes[$socket_id]) {
            if (preg_match('/TRIGGER/', $data) || preg_match('/GET \/trigger/', $data)) {
                // HTTP trigger or TCP ping trigger
                @fwrite($socket, "HTTP/1.1 200 OK\r\nContent-Type: text/plain\r\n\r\nTRIGGERED");
                @fclose($socket);
                unset($clients[$socket_id]);
                unset($handshakes[$socket_id]);
                $last_broadcast = 0; // force immediate broadcast
                echo "[" . date('H:i:s') . "] [!] Instant Vote Trigger Received -> Broadcasting!\n";
                continue;
            }

            if (preg_match('/Sec-WebSocket-Key:\s*(.*)\r\n/i', $data, $matches)) {
                $key = trim($matches[1]);
                $accept_key = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));

                $upgrade = "HTTP/1.1 101 Switching Protocols\r\n" .
                           "Upgrade: websocket\r\n" .
                           "Connection: Upgrade\r\n" .
                           "Sec-WebSocket-Accept: {$accept_key}\r\n\r\n";

                @fwrite($socket, $upgrade);
                $handshakes[$socket_id] = true;
                echo "[" . date('H:i:s') . "] [✓] Handshake completed for client #{$socket_id}\n";

                // Immediately send current live stats to new client
                $current_stats = fetch_live_stats();
                if ($current_stats) {
                    $json_msg = json_encode($current_stats);
                    @fwrite($socket, encode_ws_frame($json_msg));
                }
            } else {
                // Not a websocket handshake
                @fwrite($socket, "HTTP/1.1 200 OK\r\nContent-Type: text/plain\r\n\r\nSimple E-Vote WebSocket Server Active.");
                @fclose($socket);
                unset($clients[$socket_id]);
                unset($handshakes[$socket_id]);
            }
            continue;
        }

        // Handle WebSocket message from client
        $decoded = decode_ws_frame($data);
        if ($decoded !== null) {
            // If client asks for ping or request_stats
            $req = @json_decode($decoded, true);
            if ($req && isset($req['action']) && $req['action'] === 'request_stats') {
                $stats = fetch_live_stats();
                if ($stats) {
                    @fwrite($socket, encode_ws_frame(json_encode($stats)));
                }
            }
        }
    }

    // Periodic broadcast: check every 2 seconds
    $now = time();
    if ($now - $last_broadcast >= 2) {
        $last_broadcast = $now;

        if (!empty($clients)) {
            $stats = fetch_live_stats();
            if ($stats) {
                $payload = json_encode($stats);
                $hash = md5($payload);

                // Broadcast if stats changed or periodic keep-alive
                $frame = encode_ws_frame($payload);
                $active_count = 0;

                foreach ($clients as $sid => $client_sock) {
                    if ($handshakes[$sid]) {
                        $res = @fwrite($client_sock, $frame);
                        if ($res === false) {
                            @fclose($client_sock);
                            unset($clients[$sid]);
                            unset($handshakes[$sid]);
                        } else {
                            $active_count++;
                        }
                    }
                }

                if ($hash !== $last_stats_hash) {
                    $last_stats_hash = $hash;
                    echo "[" . date('H:i:s') . "] [>>] Broadcasted live stats update to {$active_count} clients (Voted: {$stats['total_voted']}/{$stats['total_voters']})\n";
                }
            }
        }
    }
}
