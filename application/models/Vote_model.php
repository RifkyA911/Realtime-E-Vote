<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function cast_vote($voter_id, $candidate_id, $ip_address = null) {
		$this->db->trans_start();

		// Insert vote record
		$this->db->insert('votes', array(
			'voter_id'     => $voter_id,
			'candidate_id' => $candidate_id,
			'ip_address'   => $ip_address ?: $this->input->ip_address(),
			'voted_at'     => date('Y-m-d H:i:s')
		));

		// Update voter status
		$this->db->where('id', $voter_id)->update('voters', array(
			'has_voted'  => 1,
			'voted_at'   => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));

		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function has_voted($voter_id) {
		return $this->db->where('voter_id', $voter_id)->count_all_results('votes') > 0;
	}

	public function count_total_votes() {
		return (int) $this->db->count_all('votes');
	}

	public function get_recent_votes($limit = 6) {
		return $this->db->select('v.id, v.voted_at, vt.name AS voter_name, vt.voter_code, vt.class_or_dept, c.candidate_number, c.chairman_name, c.vice_chairman_name, c.color')
			->from('votes v')
			->join('voters vt', 'v.voter_id = vt.id')
			->join('candidates c', 'v.candidate_id = c.id')
			->order_by('v.id', 'DESC')
			->limit($limit)
			->get()
			->result();
	}
}
