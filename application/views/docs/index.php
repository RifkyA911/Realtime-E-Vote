<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="<?php echo (current_lang() === 'en') ? 'en' : 'id'; ?>">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $title; ?> &mdash; Simple E-Vote</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">

  <style>
    .doc-nav {
      position: sticky;
      top: 80px;
    }
    .doc-section {
      scroll-margin-top: 90px;
      margin-bottom: 45px;
    }
    .mermaid {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 16px;
      margin: 18px 0;
      text-align: center;
      overflow-x: auto;
    }
    pre code {
      color: #e83e8c;
    }
    .badge-rfid {
      background-color: #6777ef;
      color: white;
      font-size: 11px;
    }
    .bg-code {
      background-color: #1e1e2f;
      color: #e2e8f0;
      border-radius: 6px;
      padding: 14px 18px;
      font-size: 13px;
    }
  </style>
</head>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg" style="height: 70px;"></div>
      
      <!-- Top Navigation Bar -->
      <nav class="navbar navbar-expand-lg main-navbar">
        <a href="<?php echo base_url(); ?>" class="navbar-brand sidebar-gone-hide font-weight-bold">
          <i class="fas fa-vote-yea mr-1"></i> Simple E-Vote
        </a>
        <div class="navbar-nav mr-auto">
          <span class="badge badge-light text-primary font-weight-bold ml-2 d-none d-md-inline">
            <i class="fas fa-id-card mr-1"></i> Tap ID Card Ready
          </span>
        </div>
        
        <ul class="navbar-nav navbar-right align-items-center">
          <!-- Language Switcher -->
          <li class="dropdown mr-2">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle font-weight-bold">
              <i class="fas fa-globe mr-1"></i> <?php echo (current_lang() === 'en') ? 'English (EN)' : 'Bahasa (ID)'; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="<?php echo base_url('lang/switch/id'); ?>" class="dropdown-item <?php echo (current_lang() !== 'en') ? 'font-weight-bold text-primary' : ''; ?>">
                🇮🇩 Bahasa Indonesia <?php echo (current_lang() !== 'en') ? '✓' : ''; ?>
              </a>
              <a href="<?php echo base_url('lang/switch/en'); ?>" class="dropdown-item <?php echo (current_lang() === 'en') ? 'font-weight-bold text-primary' : ''; ?>">
                🇬🇧 English <?php echo (current_lang() === 'en') ? '✓' : ''; ?>
              </a>
            </div>
          </li>

          <?php if ($is_logged_in): ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>dashboard" class="btn btn-sm btn-outline-white">
                <i class="fas fa-columns mr-1"></i> Dashboard
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>auth/login" class="btn btn-sm btn-outline-white">
                <i class="fas fa-sign-in-alt mr-1"></i> Login
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>

      <!-- Main Content -->
      <div class="main-content" style="padding-top: 100px;">
        <section class="section">
          
          <!-- Header Banner -->
          <div class="hero bg-primary text-white mb-4 rounded shadow-sm" style="padding: 30px;">
            <div class="hero-inner">
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                  <h2 class="text-white mb-1"><i class="fas fa-book-open mr-2"></i> Dokumentasi Teknis &amp; Arsitektur</h2>
                  <p class="lead mb-0 text-white-50">
                    Sistem <strong>Simple E-Vote</strong> dengan Fitur Tap ID Card (RFID/NFC), RBAC, Real-time Live Count, dan Rekapitulasi Suara.
                  </p>
                </div>
                <div class="mt-3 mt-md-0">
                  <a href="<?php echo base_url(); ?>dashboard" class="btn btn-warning font-weight-bold shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Buka Aplikasi
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Sidebar Navigation Links -->
            <div class="col-lg-3 d-none d-lg-block">
              <div class="card shadow-sm doc-nav">
                <div class="card-header">
                  <h4><i class="fas fa-list-ul mr-2 text-primary"></i> Daftar Isi</h4>
                </div>
                <div class="card-body p-0">
                  <div class="list-group list-group-flush">
                    <a href="#overview" class="list-group-item list-group-item-action font-weight-600">1. Ringkasan &amp; Arsitektur</a>
                    <a href="#tap-card-flow" class="list-group-item list-group-item-action font-weight-600">2. Alur Tap ID Card (RFID)</a>
                    <a href="#voting-flow" class="list-group-item list-group-item-action font-weight-600">3. Alur Bilik Suara (Voting)</a>
                    <a href="#database-schema" class="list-group-item list-group-item-action font-weight-600">4. Skema Database &amp; ERD</a>
                    <a href="#dml-queries" class="list-group-item list-group-item-action font-weight-600">5. Contoh DML &amp; Query Kunci</a>
                    <a href="#features-matrix" class="list-group-item list-group-item-action font-weight-600">6. Fitur &amp; RBAC Matrix</a>
                    <a href="#api-reference" class="list-group-item list-group-item-action font-weight-600">7. Referensi Endpoint API</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Documentation Content -->
            <div class="col-lg-9 col-12">

              <!-- SECTION 1: OVERVIEW & ARCHITECTURE -->
              <div id="overview" class="card shadow-sm doc-section">
                <div class="card-header border-bottom">
                  <h4><i class="fas fa-sitemap text-primary mr-2"></i> 1. Ringkasan &amp; Arsitektur Sistem</h4>
                </div>
                <div class="card-body">
                  <p>
                    <strong>Simple E-Vote</strong> adalah aplikasi pemilihan umum elektronik (E-Voting) berbasis web yang dirancang menggunakan framework <strong>CodeIgniter 3 (MVC)</strong> dan template <strong>Bootstrap Stisla</strong>.
                    Keunggulan utama sistem ini adalah fitur <strong>Bypass Login menggunakan Tap ID Card (RFID/NFC)</strong> terinspirasi dari arsitektur absensi hardware, memungkinkan pemilih atau admin masuk ke sistem dalam hitungan milidetik tanpa perlu mengetik kata sandi.
                  </p>

                  <h6 class="font-weight-bold text-dark mt-4 mb-2"><i class="fas fa-project-diagram mr-1 text-info"></i> Diagram Arsitektur Multi-Layer (Mermaid):</h6>
                  <div class="mermaid-card card border shadow-sm my-3">
                    <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                      <span class="small font-weight-bold text-muted"><i class="fas fa-search-plus mr-1 text-primary"></i> Zoom &amp; Pan Diagram</span>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary btn-zoom-in" title="Zoom In (+)"><i class="fas fa-search-plus mr-1"></i> In</button>
                        <button type="button" class="btn btn-outline-primary btn-zoom-out" title="Zoom Out (-)"><i class="fas fa-search-minus mr-1"></i> Out</button>
                        <button type="button" class="btn btn-outline-secondary btn-zoom-reset" title="Reset Zoom (100%)"><i class="fas fa-undo mr-1"></i> <span class="zoom-level">100%</span></button>
                        <button type="button" class="btn btn-outline-secondary btn-fullscreen" title="Fullscreen"><i class="fas fa-expand"></i></button>
                      </div>
                    </div>
                    <div class="mermaid-viewport" style="overflow: auto; max-height: 550px; background: #fafbfc; padding: 25px 15px; text-align: center; cursor: grab;">
                      <div class="mermaid-zoom-target" style="transform-origin: center top; transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1); display: inline-block; min-width: 100%;">
                        <div class="mermaid">
flowchart TD
    subgraph ClientLayer["1. Client & Hardware Layer"]
        A1[USB RFID Reader / Keyboard Wedge]
        A2[Web NFC API Android / Tablet]
        A3[Browser Keyboard & Form Input]
    end

    subgraph PresentationLayer["2. Presentation Layer (CI3 Views)"]
        B1["Auth View (Tap Scanner Box & Sound FX)"]
        B2["Bilik Suara (E-Voting Booth & Paslon)"]
        B3["Dashboard (Live Count & Chart.js)"]
        B4["Manajemen DPT & Paslon (Admin CRUD)"]
        B5["Berita Acara & Rekapitulasi (Print/PDF)"]
    end

    subgraph ControllerLayer["3. Controller & Security (RBAC)"]
        C0["MY_Controller (Base Auth & Role Guard)"]
        C1["Auth Controller (/auth/tap_card)"]
        C2["Vote Controller (/vote/cast)"]
        C3["Dashboard Controller (/dashboard/live_stats)"]
        C4["Candidate & Voter Controllers"]
        C5["Docs & Lang Controllers"]
    end

    subgraph DataLayer["4. Model & Database Layer"]
        D1["User_model (hextodes & Card UID Search)"]
        D2["Vote_model (Trans_Start & Anti-Double)"]
        D3["Candidate_model & Voter_model"]
        D4[("MySQL Database 'e_vote'")]
    end

    A1 -->|Keystroke < 80ms| B1
    A2 -->|NDEF Reader| B1
    A3 --> B1
    B1 --> C1
    B2 --> C2
    B3 --> C3
    B4 --> C4
    C1 --> D1
    C2 --> D2
    C3 --> D2
    C4 --> D3
    D1 --> D4
    D2 --> D4
    D3 --> D4
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="alert alert-light border mt-3">
                    <h6 class="font-weight-bold text-primary mb-1"><i class="fas fa-layer-group mr-1"></i> Komponen Utama:</h6>
                    <ul class="mb-0 pl-3">
                      <li><strong>Frontend:</strong> HTML5, CSS3, Bootstrap 4, FontAwesome 5, Chart.js, SweetAlert, Web Audio API.</li>
                      <li><strong>Backend:</strong> PHP 7.4+ (CodeIgniter 3 MVC), Dotenv environment parser (`.env`).</li>
                      <li><strong>Database:</strong> MySQL 5.7+ / MariaDB dengan Engine InnoDB &amp; Foreign Key Constraints.</li>
                      <li><strong>Hardware Support:</strong> USB RFID Reader (125kHz / 13.56MHz Mifare 1K), Web NFC API pada Android Chrome.</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- SECTION 2: TAP ID CARD FLOW -->
              <div id="tap-card-flow" class="card shadow-sm doc-section">
                <div class="card-header border-bottom">
                  <h4><i class="fas fa-id-card text-primary mr-2"></i> 2. Alur Bypass Login Tap ID Card (RFID / NFC)</h4>
                </div>
                <div class="card-body">
                  <p>
                    Saat kartu ditempelkan ke perangkat reader USB atau sensor NFC, sistem membaca UID kartu dan menerapkan konversi little-endian byte order (fungsi <code>hextodes</code>) sebelum mencocokkannya ke database.
                  </p>

                  <h6 class="font-weight-bold text-dark mt-3 mb-2"><i class="fas fa-stream mr-1 text-info"></i> Sequence Diagram Autentikasi Tap Card (Mermaid):</h6>
                  <div class="mermaid-card card border shadow-sm my-3">
                    <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                      <span class="small font-weight-bold text-muted"><i class="fas fa-search-plus mr-1 text-primary"></i> Zoom &amp; Pan Diagram</span>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary btn-zoom-in" title="Zoom In (+)"><i class="fas fa-search-plus mr-1"></i> In</button>
                        <button type="button" class="btn btn-outline-primary btn-zoom-out" title="Zoom Out (-)"><i class="fas fa-search-minus mr-1"></i> Out</button>
                        <button type="button" class="btn btn-outline-secondary btn-zoom-reset" title="Reset Zoom (100%)"><i class="fas fa-undo mr-1"></i> <span class="zoom-level">100%</span></button>
                        <button type="button" class="btn btn-outline-secondary btn-fullscreen" title="Fullscreen"><i class="fas fa-expand"></i></button>
                      </div>
                    </div>
                    <div class="mermaid-viewport" style="overflow: auto; max-height: 550px; background: #fafbfc; padding: 25px 15px; text-align: center; cursor: grab;">
                      <div class="mermaid-zoom-target" style="transform-origin: center top; transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1); display: inline-block; min-width: 100%;">
                        <div class="mermaid">
sequenceDiagram
    autonumber
    actor Voter as Pemilih / Admin
    participant Hardware as RFID / NFC Hardware
    participant Client as Web Browser (JS Listener)
    participant Auth as Auth::tap_card()
    participant Model as User_model::get_by_card_uid()
    participant DB as MySQL ('e_vote')

    Voter->>Hardware: Tempelkan Kartu ID
    Hardware->>Client: Emulasi Keystrokes UID Cepat (< 80ms)
    Note over Client: Global Keyboard Wedge menangkap input<br/>Otomatis konversi Hex ke Dec (hextodes)
    Client->>Client: Play Sound Beep (Web Audio API)
    Client->>Auth: POST /auth/tap_card { card_uid }
    Auth->>Model: get_by_card_uid(card_uid)
    Model->>DB: SELECT users WHERE card_uid / username / voter_code
    DB-->>Model: Return Data Pengguna & Role
    alt Data Kartu Ditemukan
        Model-->>Auth: User Record
        Auth->>Auth: Set Session (user_id, name, role, voter_id)
        alt Role == 'admin'
            Auth-->>Client: JSON { status: 'success', redirect: '/dashboard' }
            Client->>Voter: Redirect ke Dashboard Real Count
        else Role == 'voter'
            Auth-->>Client: JSON { status: 'success', redirect: '/vote' }
            Client->>Voter: Redirect ke Bilik Suara (Voting Booth)
        end
    else Kartu Tidak Terdaftar
        Model-->>Auth: NULL
        Auth-->>Client: JSON { status: 'error', message: 'Kartu tidak terdaftar' }
        Client->>Client: Play Sound Buzz & SweetAlert Error
    end
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card bg-light border mt-3">
                    <div class="card-body">
                      <h6 class="font-weight-bold text-dark mb-2"><i class="fas fa-code mr-1 text-primary"></i> Algoritma Pembalik Byte (Hextodes Algorithm):</h6>
                      <p class="small text-muted mb-2">
                        Mengubah UID hexadecimal 4-byte kartu NFC (contoh: <code>19:4a:0f:00</code>) menjadi 10 digit desimal RFID (<code>0001002009</code>):
                      </p>
                      <pre class="bg-code mb-0"><code>function hextodes($hex) {
    $hex = str_replace(array(':', ' ', '-'), '', $hex);
    if (strlen($hex) === 8) {
        // Reverse byte pairs (Little-Endian)
        $reversed = substr($hex,6,2) . substr($hex,4,2) . substr($hex,2,2) . substr($hex,0,2);
        return str_pad(hexdec($reversed), 10, '0', STR_PAD_LEFT);
    }
    return $hex;
}</code></pre>
                    </div>
                  </div>
                </div>
              </div>

              <!-- SECTION 3: VOTING FLOW -->
              <div id="voting-flow" class="card shadow-sm doc-section">
                <div class="card-header border-bottom">
                  <h4><i class="fas fa-person-booth text-primary mr-2"></i> 3. Alur Bilik Suara &amp; Pencegahan Suara Ganda</h4>
                </div>
                <div class="card-body">
                  <p>
                    Setiap pemilih hanya memiliki 1 (satu) kali kesempatan mencoblos. Sistem menggunakan <strong>Database Transaction</strong> untuk menjamin integritas data secara atomic (semua operasi sukses atau di-rollback seluruhnya).
                  </p>

                  <h6 class="font-weight-bold text-dark mt-3 mb-2"><i class="fas fa-route mr-1 text-info"></i> Flowchart Logika Bilik Suara (Mermaid):</h6>
                  <div class="mermaid-card card border shadow-sm my-3">
                    <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                      <span class="small font-weight-bold text-muted"><i class="fas fa-search-plus mr-1 text-primary"></i> Zoom &amp; Pan Diagram</span>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary btn-zoom-in" title="Zoom In (+)"><i class="fas fa-search-plus mr-1"></i> In</button>
                        <button type="button" class="btn btn-outline-primary btn-zoom-out" title="Zoom Out (-)"><i class="fas fa-search-minus mr-1"></i> Out</button>
                        <button type="button" class="btn btn-outline-secondary btn-zoom-reset" title="Reset Zoom (100%)"><i class="fas fa-undo mr-1"></i> <span class="zoom-level">100%</span></button>
                        <button type="button" class="btn btn-outline-secondary btn-fullscreen" title="Fullscreen"><i class="fas fa-expand"></i></button>
                      </div>
                    </div>
                    <div class="mermaid-viewport" style="overflow: auto; max-height: 550px; background: #fafbfc; padding: 25px 15px; text-align: center; cursor: grab;">
                      <div class="mermaid-zoom-target" style="transform-origin: center top; transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1); display: inline-block; min-width: 100%;">
                        <div class="mermaid">
flowchart TD
    Start([Pemilih Masuk ke Bilik Suara]) --> CheckRole{Apakah Akun Pemilih / Voter?}
    CheckRole -- Ya --> CheckVoted{Cek Status: has_voted == 1?}
    CheckRole -- Admin --> AdminSelect[Admin Memilih Pemilih DPT dari Dropdown]
    AdminSelect --> ShowPaslon[Tampilkan Pasangan Calon]

    CheckVoted -- Sudah Memilih --> LockedState[Terkunci: Tombol Coblos Dinonaktifkan]
    LockedState --> Notice[Tampilkan Pesan: Hak Suara Telah Digunakan]

    CheckVoted -- Belum Memilih --> ShowPaslon
    ShowPaslon --> VoterChoice[Pemilih Menekan Tombol Coblos]
    VoterChoice --> ModalConfirm{Modal Konfirmasi: Yakin Mencoblos?}
    ModalConfirm -- Batal --> ShowPaslon
    ModalConfirm -- Yakin --> PostCast[Kirim POST /vote/cast]

    PostCast --> DBTrans[Mulai DB Transaction: trans_start]
    DBTrans --> InsertVote[Insert Record ke Tabel 'votes']
    InsertVote --> UpdateVoter[Update voters: has_voted=1, voted_at=NOW]
    UpdateVoter --> CommitTrans{trans_complete Sukses?}

    CommitTrans -- Gagal --> Rollback[Rollback Data & Redirect dengan Pesan Error]
    CommitTrans -- Sukses --> RedirectDash[Flash Sukses & Redirect ke Dashboard]
    RedirectDash --> LiveCount[Live Count Auto-Refresh Memperbarui Grafik Real Count]
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- SECTION 4: DATABASE SCHEMA & ERD -->
              <div id="database-schema" class="card shadow-sm doc-section">
                <div class="card-header border-bottom">
                  <h4><i class="fas fa-database text-primary mr-2"></i> 4. Skema Database &amp; ERD (Entity Relationship)</h4>
                </div>
                <div class="card-body">
                  <p>
                    Database bernama <code>e_vote</code> terdiri dari 4 tabel relasional utama yang saling terhubung dengan foreign keys dan aturan integritas relasional:
                  </p>

                  <h6 class="font-weight-bold text-dark mt-3 mb-2"><i class="fas fa-project-diagram mr-1 text-info"></i> Entity Relationship Diagram (ERD Mermaid):</h6>
                  <div class="mermaid-card card border shadow-sm my-3">
                    <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                      <span class="small font-weight-bold text-muted"><i class="fas fa-search-plus mr-1 text-primary"></i> Zoom &amp; Pan Diagram</span>
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary btn-zoom-in" title="Zoom In (+)"><i class="fas fa-search-plus mr-1"></i> In</button>
                        <button type="button" class="btn btn-outline-primary btn-zoom-out" title="Zoom Out (-)"><i class="fas fa-search-minus mr-1"></i> Out</button>
                        <button type="button" class="btn btn-outline-secondary btn-zoom-reset" title="Reset Zoom (100%)"><i class="fas fa-undo mr-1"></i> <span class="zoom-level">100%</span></button>
                        <button type="button" class="btn btn-outline-secondary btn-fullscreen" title="Fullscreen"><i class="fas fa-expand"></i></button>
                      </div>
                    </div>
                    <div class="mermaid-viewport" style="overflow: auto; max-height: 550px; background: #fafbfc; padding: 25px 15px; text-align: center; cursor: grab;">
                      <div class="mermaid-zoom-target" style="transform-origin: center top; transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1); display: inline-block; min-width: 100%;">
                        <div class="mermaid">
erDiagram
    USERS ||--o| VOTERS : "voter_id linked"
    VOTERS ||--o| VOTES : "casts vote"
    CANDIDATES ||--o{ VOTES : "receives vote"

    USERS {
        int id PK
        string username UK
        string password
        string name
        enum role "admin, voter"
        string card_uid UK
        int voter_id FK
        datetime created_at
        datetime updated_at
    }

    VOTERS {
        int id PK
        string voter_code UK
        string card_uid UK
        string name
        enum gender "L, P"
        string class_or_dept
        tinyint has_voted "0 or 1"
        datetime voted_at
        datetime created_at
        datetime updated_at
    }

    CANDIDATES {
        int id PK
        int candidate_number UK
        string chairman_name
        string vice_chairman_name
        text vision
        text mission
        string photo
        string color
        datetime created_at
        datetime updated_at
    }

    VOTES {
        int id PK
        int voter_id FK, UK
        int candidate_id FK
        string ip_address
        datetime voted_at
    }
                        </div>
                      </div>
                    </div>
                  </div>

                  <h6 class="font-weight-bold text-dark mt-4 mb-2">Penjelasan Relasi Database:</h6>
                  <ul class="text-muted">
                    <li><strong><code>users.voter_id</code> &rarr; <code>voters.id</code></strong>: Relasi 1-to-1 opsional. Akun voter di tabel users memiliki voter_id yang mereferensikan baris pemilihnya di tabel voters (CASCADE on delete).</li>
                    <li><strong><code>votes.voter_id</code> &rarr; <code>voters.id</code></strong>: Relasi 1-to-1 unik (UNIQUE constraint) mencegah pemilih mencoblos lebih dari 1 kali di level skema database.</li>
                    <li><strong><code>votes.candidate_id</code> &rarr; <code>candidates.id</code></strong>: Relasi Many-to-1; setiap paslon dapat menerima banyak suara dari berbagai pemilih.</li>
                  </ul>
                </div>
              </div>

              <!-- SECTION 5: DML & QUERIES -->
              <div id="dml-queries" class="card shadow-sm doc-section">
                <div class="card-header border-bottom">
                  <h4><i class="fas fa-terminal text-primary mr-2"></i> 5. Contoh DML (Data Manipulation Language) Kunci</h4>
                </div>
                <div class="card-body">
                  <p class="text-muted">Kumpulan query SQL standar yang dieksekusi oleh sistem selama proses operasional aplikasi:</p>

                  <div class="mb-3">
                    <h6 class="font-weight-bold text-dark mb-1">A. Query Pencatatan Suara Sah (Voting Transaction):</h6>
                    <pre class="bg-code"><code>START TRANSACTION;

-- 1. Insert rekam suara masuk
INSERT INTO votes (voter_id, candidate_id, ip_address, voted_at) 
VALUES (10, 1, '127.0.0.1', NOW());

-- 2. Kunci status pemilih agar tidak bisa memilih kembali
UPDATE voters 
SET has_voted = 1, voted_at = NOW(), updated_at = NOW() 
WHERE id = 10;

COMMIT;</code></pre>
                  </div>

                  <div class="mb-3">
                    <h6 class="font-weight-bold text-dark mb-1">B. Query Penghitungan Real Count &amp; Persentase Suara:</h6>
                    <pre class="bg-code"><code>SELECT 
    c.id,
    c.candidate_number,
    c.chairman_name,
    c.vice_chairman_name,
    c.color,
    COUNT(v.id) AS total_votes,
    ROUND((COUNT(v.id) / (SELECT GREATEST(COUNT(*), 1) FROM votes)) * 100, 1) AS percentage
FROM candidates c
LEFT JOIN votes v ON c.id = v.candidate_id
GROUP BY c.id
ORDER BY c.candidate_number ASC;</code></pre>
                  </div>

                  <div class="mb-3">
                    <h6 class="font-weight-bold text-dark mb-1">C. Query Verifikasi Tap Card UID Multi-Tabel:</h6>
                    <pre class="bg-code"><code>SELECT u.*, v.has_voted, v.voter_code 
FROM users u
LEFT JOIN voters v ON u.voter_id = v.id
WHERE u.card_uid = '0001002010' 
   OR v.card_uid = '0001002010' 
   OR u.username = '0001002010'
LIMIT 1;</code></pre>
                  </div>
                </div>
              </div>

              <!-- SECTION 6: FEATURES & RBAC MATRIX -->
              <div id="features-matrix" class="card shadow-sm doc-section">
                <div class="card-header border-bottom">
                  <h4><i class="fas fa-user-shield text-primary mr-2"></i> 6. Matriks Fitur &amp; Role-Based Access Control (RBAC)</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead class="bg-light">
                        <tr>
                          <th>Modul / Fitur Aplikasi</th>
                          <th class="text-center" width="22%">Admin (<code>admin</code>)</th>
                          <th class="text-center" width="22%">Pemilih (<code>voter</code>)</th>
                          <th class="text-center" width="18%">Publik / Guest</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><strong>Login Username &amp; Password</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                        </tr>
                        <tr>
                          <td><strong>Bypass Login Tap ID Card (RFID/NFC)</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                        </tr>
                        <tr>
                          <td><strong>Dashboard Real Count &amp; Grafik</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Tidak</td>
                        </tr>
                        <tr>
                          <td><strong>Bilik Suara (Voting Elektronik)</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya (Bebas DPT)</td>
                          <td class="text-center text-info"><i class="fas fa-check-circle"></i> Ya (Akun Pribadi)</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Tidak</td>
                        </tr>
                        <tr>
                          <td><strong>CRUD Data Paslon (Kandidat)</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> CRUD Penuh</td>
                          <td class="text-center text-warning"><i class="fas fa-eye"></i> Hanya Baca</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Tidak</td>
                        </tr>
                        <tr>
                          <td><strong>CRUD Data Pemilih (DPT)</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> CRUD Penuh</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Ditolak</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Tidak</td>
                        </tr>
                        <tr>
                          <td><strong>Cetak Berita Acara &amp; Rekap PDF</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Tidak</td>
                        </tr>
                        <tr>
                          <td><strong>Migrasi &amp; Reset Suara Database</strong></td>
                          <td class="text-center text-success"><i class="fas fa-check-circle"></i> Ya</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Ditolak</td>
                          <td class="text-center text-danger"><i class="fas fa-times-circle"></i> Tidak</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- SECTION 7: API REFERENCE -->
              <div id="api-reference" class="card shadow-sm doc-section">
                <div class="card-header border-bottom">
                  <h4><i class="fas fa-network-wired text-primary mr-2"></i> 7. Referensi Endpoint API</h4>
                </div>
                <div class="card-body">
                  <div class="mb-4">
                    <h6 class="font-weight-bold"><span class="badge badge-success mr-2">POST</span> <code>/auth/tap_card</code></h6>
                    <p class="text-muted small mb-2">Endpoint autentikasi login via kartu identitas RFID/NFC.</p>
                    <pre class="bg-code"><code>curl -X POST http://localhost/e-vote/auth/tap_card \
  -H "X-Requested-With: XMLHttpRequest" \
  -d "card_uid=0001002010"</code></pre>
                  </div>

                  <div class="mb-4">
                    <h6 class="font-weight-bold"><span class="badge badge-primary mr-2">GET</span> <code>/dashboard/live_stats</code></h6>
                    <p class="text-muted small mb-2">Endpoint polling auto-refresh real-time live count.</p>
                    <pre class="bg-code"><code>curl http://localhost/e-vote/dashboard/live_stats</code></pre>
                  </div>

                  <div class="mb-2">
                    <h6 class="font-weight-bold"><span class="badge badge-info mr-2">GET</span> <code>/lang/switch/{id|en}</code></h6>
                    <p class="text-muted small mb-2">Endpoint pergantian bahasa antarmuka (Indonesian / English).</p>
                    <pre class="bg-code"><code>http://localhost/e-vote/lang/switch/en</code></pre>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </section>
      </div>

      <!-- Footer -->
      <footer class="main-footer mt-4">
        <div class="footer-left">
          <strong>Simple E-Vote</strong> &bull; <?php echo __t('app_tagline', 'Sistem E-Voting Modern dengan Fitur Tap ID Card (RFID/NFC)'); ?>
        </div>
        <div class="footer-right">
          <a href="#app" class="btn btn-sm btn-outline-primary"><i class="fas fa-arrow-up mr-1"></i> Ke Atas</a>
        </div>
      </footer>

    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/popper.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/stisla.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>

  <!-- Mermaid.js for Diagrams -->
  <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
  <script>
    mermaid.initialize({
      startOnLoad: true,
      theme: 'default',
      securityLevel: 'loose',
      flowchart: {
        useMaxWidth: true,
        htmlLabels: true
      }
    });

    // Mermaid Interactive Zoom & Pan Controls
    $(document).ready(function() {
      $('.mermaid-card').each(function() {
        var $card = $(this);
        var $viewport = $card.find('.mermaid-viewport');
        var $target = $card.find('.mermaid-zoom-target');
        var $zoomLabel = $card.find('.zoom-level');
        var currentScale = 1.0;

        function updateScale(newScale) {
          currentScale = Math.min(Math.max(newScale, 0.4), 3.0);
          currentScale = Math.round(currentScale * 10) / 10;
          $target.css('transform', 'scale(' + currentScale + ')');
          $zoomLabel.text(Math.round(currentScale * 100) + '%');
        }

        $card.find('.btn-zoom-in').on('click', function() {
          updateScale(currentScale + 0.2);
        });

        $card.find('.btn-zoom-out').on('click', function() {
          updateScale(currentScale - 0.2);
        });

        $card.find('.btn-zoom-reset').on('click', function() {
          updateScale(1.0);
        });

        $card.find('.btn-fullscreen').on('click', function() {
          var viewportEl = $viewport[0];
          if (!document.fullscreenElement) {
            if (viewportEl.requestFullscreen) {
              viewportEl.requestFullscreen();
            } else if (viewportEl.webkitRequestFullscreen) {
              viewportEl.webkitRequestFullscreen();
            }
          } else {
            if (document.exitFullscreen) {
              document.exitFullscreen();
            }
          }
        });

        // Mouse Drag-to-Pan support
        var isDown = false;
        var startX, startY, scrollLeft, scrollTop;

        $viewport.on('mousedown', function(e) {
          isDown = true;
          $viewport.css('cursor', 'grabbing');
          startX = e.pageX - $viewport.offset().left;
          startY = e.pageY - $viewport.offset().top;
          scrollLeft = $viewport.scrollLeft();
          scrollTop = $viewport.scrollTop();
        });

        $(document).on('mouseup', function() {
          if (isDown) {
            isDown = false;
            $viewport.css('cursor', 'grab');
          }
        });

        $viewport.on('mousemove', function(e) {
          if (!isDown) return;
          e.preventDefault();
          var x = e.pageX - $viewport.offset().left;
          var y = e.pageY - $viewport.offset().top;
          var walkX = (x - startX) * 1.5;
          var walkY = (y - startY) * 1.5;
          $viewport.scrollLeft(scrollLeft - walkX);
          $viewport.scrollTop(scrollTop - walkY);
        });
      });
    });
  </script>
</body>
</html>
