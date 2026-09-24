<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voter extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->require_admin();
		$this->load->model('Voter_model');
		$this->load->model('Vote_model');
	}

	public function index() {
		$data = array(
			'title'         => __t('voter_registry', 'Registered Voters (DPT)'),
			'voters'        => $this->Voter_model->get_all(),
			'total_voters'  => $this->Voter_model->count_all(),
			'total_voted'   => $this->Voter_model->count_voted(),
			'total_unvoted' => $this->Voter_model->count_unvoted()
		);
		$this->load->view('voter/index', $data);
	}

	public function create() {
		$data = array(
			'title' => __t('add_voter_title', 'Add New Voter (DPT)')
		);
		$this->load->view('voter/create', $data);
	}

	public function store() {
		$this->form_validation->set_rules('voter_code', __t('voter_code', 'Voter Code / Student ID'), 'required|trim|is_unique[voters.voter_code]', array(
			'required'  => __t('field_required', '%s is required.'),
			'is_unique' => __t('field_unique_voter', '%s is already registered in the system.')
		));
		$this->form_validation->set_rules('name', __t('voter_name', 'Full Name'), 'required|trim', array(
			'required' => __t('field_required', '%s is required.')
		));
		$this->form_validation->set_rules('gender', __t('gender', 'Gender'), 'required|in_list[L,P]');
		$this->form_validation->set_rules('class_or_dept', __t('class_or_dept', 'Class / Major / Unit'), 'required|trim', array(
			'required' => __t('field_required', '%s is required.')
		));

		if ($this->form_validation->run() === FALSE) {
			$this->create();
			return;
		}

		$card_uid = trim($this->input->post('card_uid', TRUE));
		if (!empty($card_uid) && $this->Voter_model->is_card_uid_exists($card_uid)) {
			$this->session->set_flashdata('error', sprintf(__t('msg_card_uid_taken', 'Card UID %s is already assigned to another voter.'), $card_uid));
			$this->create();
			return;
		}

		$payload = array(
			'voter_code'    => strtoupper(trim($this->input->post('voter_code', TRUE))),
			'card_uid'      => !empty($card_uid) ? $card_uid : null,
			'name'          => $this->input->post('name', TRUE),
			'gender'        => $this->input->post('gender', TRUE),
			'class_or_dept' => $this->input->post('class_or_dept', TRUE)
		);

		$this->Voter_model->insert($payload);
		$this->session->set_flashdata('success', sprintf(__t('msg_voter_added', 'Voter %s (%s) has been successfully registered!'), $payload['name'], $payload['voter_code']));
		redirect('voter');
	}

	public function edit($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', __t('msg_voter_not_found', 'Voter record not found.'));
			redirect('voter');
		}

		$data = array(
			'title' => __t('edit_voter_title', 'Edit Voter Details'),
			'voter' => $voter
		);
		$this->load->view('voter/edit', $data);
	}

	public function update($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', __t('msg_voter_not_found', 'Voter record not found.'));
			redirect('voter');
		}

		$voter_code = strtoupper(trim($this->input->post('voter_code', TRUE)));
		if ($this->Voter_model->is_code_exists($voter_code, $id)) {
			$this->session->set_flashdata('error', sprintf(__t('msg_voter_code_taken', 'Voter code %s is already assigned to another voter.'), $voter_code));
			redirect('voter/edit/' . $id);
			return;
		}

		$card_uid = trim($this->input->post('card_uid', TRUE));
		if (!empty($card_uid) && $this->Voter_model->is_card_uid_exists($card_uid, $id)) {
			$this->session->set_flashdata('error', sprintf(__t('msg_card_uid_taken', 'Card UID %s is already assigned to another voter.'), $card_uid));
			redirect('voter/edit/' . $id);
			return;
		}

		$this->form_validation->set_rules('name', __t('voter_name', 'Full Name'), 'required|trim');
		$this->form_validation->set_rules('gender', __t('gender', 'Gender'), 'required|in_list[L,P]');
		$this->form_validation->set_rules('class_or_dept', __t('class_or_dept', 'Class / Major / Unit'), 'required|trim');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id);
			return;
		}

		$payload = array(
			'voter_code'    => $voter_code,
			'card_uid'      => !empty($card_uid) ? $card_uid : null,
			'name'          => $this->input->post('name', TRUE),
			'gender'        => $this->input->post('gender', TRUE),
			'class_or_dept' => $this->input->post('class_or_dept', TRUE)
		);

		$this->Voter_model->update($id, $payload);
		$this->session->set_flashdata('success', __t('msg_voter_updated', 'Voter details updated successfully!'));
		redirect('voter');
	}

	public function delete($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', __t('msg_voter_not_found', 'Voter record not found.'));
			redirect('voter');
		}

		$this->Voter_model->delete($id);
		$this->session->set_flashdata('success', sprintf(__t('msg_voter_deleted', 'Voter %s has been successfully deleted.'), $voter->name));
		redirect('voter');
	}

	public function reset_status($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', __t('msg_voter_not_found', 'Voter record not found.'));
			redirect('voter');
		}

		$this->Voter_model->reset_voter_status($id);
		$this->session->set_flashdata('success', sprintf(__t('msg_voter_status_reset', 'Voting status for %s has been reset to Not Voted.'), $voter->name));
		redirect('voter');
	}

	public function reset_all() {
		$this->Voter_model->reset_all();
		$this->session->set_flashdata('success', __t('msg_all_votes_reset', 'All voting records have been cleared! All voters are now set to Not Voted.'));
		redirect('voter');
	}
}
