<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voter_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_all($limit = null, $offset = 0) {
		$this->db->order_by('id', 'DESC');
		if ($limit !== null) {
			$this->db->limit($limit, $offset);
		}
		return $this->db->get('voters')->result();
	}

	public function get_by_id($id) {
		return $this->db->where('id', $id)->get('voters')->row();
	}

	public function get_by_code($code) {
		return $this->db->where('voter_code', $code)->get('voters')->row();
	}

	public function get_unvoted() {
		return $this->db->where('has_voted', 0)->order_by('name', 'ASC')->get('voters')->result();
	}

	public function get_by_card_uid($card_uid) {
		return $this->db->where('card_uid', $card_uid)->get('voters')->row();
	}

	public function is_code_exists($code, $exclude_id = null) {
		$this->db->where('voter_code', $code);
		if ($exclude_id !== null) {
			$this->db->where('id !=', $exclude_id);
		}
		return $this->db->count_all_results('voters') > 0;
	}

	public function is_card_uid_exists($card_uid, $exclude_id = null) {
		if (empty($card_uid)) return false;
		$this->db->where('card_uid', $card_uid);
		if ($exclude_id !== null) {
			$this->db->where('id !=', $exclude_id);
		}
		return $this->db->count_all_results('voters') > 0;
	}

	public function insert($data) {
		$data['has_voted'] = 0;
		$data['voted_at'] = null;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$this->db->insert('voters', $data);
		$voter_id = $this->db->insert_id();

		// Create user login account for this voter
		$this->db->insert('users', array(
			'name'       => $data['name'],
			'username'   => $data['voter_code'],
			'password'   => password_hash('voter123', PASSWORD_BCRYPT),
			'role'       => 'voter',
			'card_uid'   => isset($data['card_uid']) ? $data['card_uid'] : null,
			'voter_id'   => $voter_id,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));

		return $voter_id;
	}

	public function update($id, $data) {
		$data['updated_at'] = date('Y-m-d H:i:s');
		$res = $this->db->where('id', $id)->update('voters', $data);

		// Sync user account if name, voter_code, or card_uid changed
		$user_update = array('updated_at' => date('Y-m-d H:i:s'));
		if (isset($data['name'])) {
			$user_update['name'] = $data['name'];
		}
		if (isset($data['voter_code'])) {
			$user_update['username'] = $data['voter_code'];
		}
		if (array_key_exists('card_uid', $data)) {
			$user_update['card_uid'] = $data['card_uid'];
		}
		$this->db->where('voter_id', $id)->update('users', $user_update);

		return $res;
	}

	public function delete($id) {
		return $this->db->where('id', $id)->delete('voters');
	}

	public function count_all() {
		return (int) $this->db->count_all('voters');
	}

	public function count_voted() {
		return (int) $this->db->where('has_voted', 1)->count_all_results('voters');
	}

	public function count_unvoted() {
		return (int) $this->db->where('has_voted', 0)->count_all_results('voters');
	}

	public function reset_voter_status($id) {
		$this->db->trans_start();
		$this->db->where('voter_id', $id)->delete('votes');
		$this->db->where('id', $id)->update('voters', array(
			'has_voted' => 0,
			'voted_at'  => null,
			'updated_at' => date('Y-m-d H:i:s')
		));
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function reset_all() {
		$this->db->trans_start();
		$this->db->empty_table('votes');
		$this->db->update('voters', array(
			'has_voted' => 0,
			'voted_at'  => null,
			'updated_at' => date('Y-m-d H:i:s')
		));
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}
