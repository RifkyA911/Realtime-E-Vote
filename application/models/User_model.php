<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_by_username($username) {
		return $this->db->where('username', $username)->get('users')->row();
	}

	public function get_by_id($id) {
		return $this->db->where('id', $id)->get('users')->row();
	}

	/**
	 * Cari user berdasarkan Card UID (RFID / NFC / Barcode).
	 * Mendukung format:
	 * 1. 10-digit decimal RFID (output standar USB reader & hextodes)
	 * 2. Raw Hex NFC UID (dengan konversi hextodes little-endian ala absensi_gebyar)
	 * 3. voter_code / NIM / NIS
	 * 4. username
	 */
	public function get_by_card_uid($raw_uid) {
		if (empty($raw_uid)) {
			return null;
		}

		$raw_uid = trim((string) $raw_uid);
		$clean_uid = str_replace(array(':', ' ', '-'), '', $raw_uid);

		// List kandidat UID yang akan dicek
		$candidates = array($raw_uid, $clean_uid);

		// Jika format hex 8 karakter (4 byte UID NFC), konversikan ke desimal 10 digit (hextodes ala absensi_gebyar)
		if (strlen($clean_uid) === 8 && ctype_xdigit($clean_uid)) {
			// reverse byte order (Little Endian)
			$reversed_hex = substr($clean_uid, 6, 2) . substr($clean_uid, 4, 2) . substr($clean_uid, 2, 2) . substr($clean_uid, 0, 2);
			$dec_val = hexdec($reversed_hex);
			$candidates[] = str_pad((string) $dec_val, 10, '0', STR_PAD_LEFT);
			$candidates[] = (string) $dec_val;
		}

		$candidates = array_unique(array_filter($candidates));

		// 1. Cek di tabel users (card_uid atau username)
		$user = $this->db->group_start()
			->where_in('card_uid', $candidates)
			->or_where_in('username', $candidates)
			->group_end()
			->get('users')
			->row();

		if ($user) {
			return $user;
		}

		// 2. Cek di tabel voters (card_uid atau voter_code)
		$voter = $this->db->group_start()
			->where_in('card_uid', $candidates)
			->or_where_in('voter_code', $candidates)
			->group_end()
			->get('voters')
			->row();

		if ($voter) {
			return $this->db->where('voter_id', $voter->id)->get('users')->row();
		}

		return null;
	}

	public function verify_login($username, $password) {
		$user = $this->get_by_username($username);
		if (!$user) {
			return false;
		}

		if (password_verify($password, $user->password)) {
			return $user;
		}

		return false;
	}

	public function create_voter_user($voter_id, $name, $voter_code, $plain_password = 'voter123') {
		$data = array(
			'name'       => $name,
			'username'   => $voter_code,
			'password'   => password_hash($plain_password, PASSWORD_BCRYPT),
			'role'       => 'voter',
			'voter_id'   => $voter_id,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

	public function update_voter_user($voter_id, $name, $voter_code) {
		$data = array(
			'name'       => $name,
			'username'   => $voter_code,
			'updated_at' => date('Y-m-d H:i:s')
		);
		return $this->db->where('voter_id', $voter_id)->update('users', $data);
	}
}
