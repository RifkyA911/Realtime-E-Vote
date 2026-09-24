<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Candidate_model');
		$this->load->model('Voter_model');
		$this->load->model('Vote_model');
	}

	public function index() {
		$selected_voter = null;
		$user_role      = $this->user->role;
		$already_voted  = false;
		$my_voter       = null;

		if ($user_role === 'voter') {
			$my_voter       = $this->Voter_model->get_by_id($this->user->voter_id);
			$selected_voter = $my_voter;
			if ($my_voter && ($my_voter->has_voted == 1 || $this->Vote_model->has_voted($my_voter->id))) {
				$already_voted = true;
			}
		} else {
			$selected_code = $this->input->get('code', TRUE);
			if (!empty($selected_code)) {
				$selected_voter = $this->Voter_model->get_by_code(trim($selected_code));
			}
		}

		$data = array(
			'title'          => 'Bilik Suara (E-Voting Booth)',
			'candidates'     => $this->Candidate_model->get_all(),
			'unvoted_voters' => $this->Voter_model->get_unvoted(),
			'total_unvoted'  => $this->Voter_model->count_unvoted(),
			'selected_voter' => $selected_voter,
			'user_role'      => $user_role,
			'my_voter'       => $my_voter,
			'already_voted'  => $already_voted
		);

		$this->load->view('vote/index', $data);
	}

	public function cast() {
		if ($this->user->role === 'voter') {
			$voter_id = (int) $this->user->voter_id;
		} else {
			$voter_id = (int) $this->input->post('voter_id', TRUE);
		}

		$candidate_id = (int) $this->input->post('candidate_id', TRUE);

		if (empty($voter_id) || empty($candidate_id)) {
			$this->session->set_flashdata('error', 'Silakan tentukan pasangan calon yang ingin dicoblos.');
			redirect('vote');
			return;
		}

		$voter = $this->Voter_model->get_by_id($voter_id);
		if (!$voter) {
			$this->session->set_flashdata('error', 'Data pemilih tidak valid.');
			redirect('vote');
			return;
		}

		if ($voter->has_voted == 1 || $this->Vote_model->has_voted($voter_id)) {
			$this->session->set_flashdata('error', 'Pemilih ' . $voter->name . ' (' . $voter->voter_code . ') sudah menggunakan hak suaranya sebelumnya.');
			redirect('vote');
			return;
		}

		$candidate = $this->Candidate_model->get_by_id($candidate_id);
		if (!$candidate) {
			$this->session->set_flashdata('error', 'Kandidat yang dipilih tidak valid.');
			redirect('vote');
			return;
		}

		$success = $this->Vote_model->cast_vote($voter_id, $candidate_id, $this->input->ip_address());

		if ($success) {
			$this->session->set_flashdata('vote_success', array(
				'voter_name'       => $voter->name,
				'voter_code'       => $voter->voter_code,
				'candidate_number' => $candidate->candidate_number,
				'candidate_name'   => $candidate->chairman_name . ' & ' . $candidate->vice_chairman_name
			));
			$this->session->set_flashdata('success', 'Selamat! Hak suara pemilih ' . $voter->name . ' telah berhasil digunakan untuk mencoblos Paslon No. ' . $candidate->candidate_number . '!');
			redirect('dashboard');
		} else {
			$this->session->set_flashdata('error', 'Terjadi kesalahan sistem saat merekam suara. Silakan coba lagi.');
			redirect('vote');
		}
	}
}
