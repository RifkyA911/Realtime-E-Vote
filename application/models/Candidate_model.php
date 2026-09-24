<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_all() {
		return $this->db->order_by('candidate_number', 'ASC')->get('candidates')->result();
	}

	public function get_by_id($id) {
		return $this->db->where('id', $id)->get('candidates')->row();
	}

	public function get_next_number() {
		$row = $this->db->select_max('candidate_number', 'max_num')->get('candidates')->row();
		return ($row && $row->max_num) ? ((int)$row->max_num + 1) : 1;
	}

	public function is_number_exists($number, $exclude_id = null) {
		$this->db->where('candidate_number', $number);
		if ($exclude_id !== null) {
			$this->db->where('id !=', $exclude_id);
		}
		return $this->db->count_all_results('candidates') > 0;
	}

	public function get_with_votes_count() {
		$total_votes = (int) $this->db->count_all('votes');
		
		$query = $this->db->select('c.*, COUNT(v.id) AS total_votes')
			->from('candidates c')
			->join('votes v', 'c.id = v.candidate_id', 'left')
			->group_by('c.id')
			->order_by('c.candidate_number', 'ASC')
			->get();

		$candidates = $query->result();

		foreach ($candidates as &$candidate) {
			$candidate->total_votes = (int) $candidate->total_votes;
			$candidate->percentage = ($total_votes > 0) ? round(($candidate->total_votes / $total_votes) * 100, 1) : 0;
		}

		return $candidates;
	}

	public function insert($data) {
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$this->db->insert('candidates', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data) {
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->where('id', $id)->update('candidates', $data);
	}

	public function delete($id) {
		$candidate = $this->get_by_id($id);
		if ($candidate && !empty($candidate->photo)) {
			$photo_path = FCPATH . 'assets/uploads/candidates/' . $candidate->photo;
			// Don't delete seeded default avatars
			if (file_exists($photo_path) && !in_array($candidate->photo, array('candidate-1.png', 'candidate-2.png', 'candidate-3.png', 'avatar-1.png', 'avatar-2.png', 'avatar-3.png'))) {
				@unlink($photo_path);
			}
		}
		return $this->db->where('id', $id)->delete('candidates');
	}

	public function count_all() {
		return $this->db->count_all('candidates');
	}
}
