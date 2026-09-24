<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Candidate_model');
		$this->load->model('Vote_model');
	}

	public function index() {
		$data = array(
			'title'      => __t('candidate_registry', 'Candidate Pairs Registry'),
			'candidates' => $this->Candidate_model->get_with_votes_count()
		);
		$this->load->view('candidate/index', $data);
	}

	public function create() {
		$this->require_admin();
		$next_number = $this->Candidate_model->get_next_number();
		$data = array(
			'title'       => __t('add_candidate_title', 'Add New Candidate Pair'),
			'next_number' => $next_number
		);
		$this->load->view('candidate/create', $data);
	}

	public function store() {
		$this->require_admin();
		$this->form_validation->set_rules('candidate_number', __t('candidate_number', 'Ballot Number'), 'required|numeric|is_unique[candidates.candidate_number]', array(
			'required'  => __t('field_required', '%s is required.'),
			'numeric'   => __t('field_numeric', '%s must be a valid number.'),
			'is_unique' => __t('field_unique_candidate', '%s is already taken by another candidate.')
		));
		$this->form_validation->set_rules('chairman_name', __t('chairman', 'Chairman Candidate Name'), 'required|trim', array(
			'required' => __t('field_required', '%s is required.')
		));
		$this->form_validation->set_rules('vice_chairman_name', __t('vice_chairman', 'Vice Chairman Candidate Name'), 'required|trim', array(
			'required' => __t('field_required', '%s is required.')
		));
		$this->form_validation->set_rules('vision', __t('vision', 'Vision'), 'required|trim', array(
			'required' => __t('field_required', '%s is required.')
		));
		$this->form_validation->set_rules('mission', __t('mission', 'Mission'), 'required|trim', array(
			'required' => __t('field_required', '%s is required.')
		));

		if ($this->form_validation->run() === FALSE) {
			$this->create();
			return;
		}

		$photo_filename = null;
		if (!empty($_FILES['photo']['name'])) {
			$config['upload_path']   = './assets/uploads/candidates/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = 3072; // 3MB
			$config['file_name']     = 'candidate_' . time();

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('photo')) {
				$upload_data = $this->upload->data();
				$photo_filename = $upload_data['file_name'];
			} else {
				$this->session->set_flashdata('error', __t('msg_photo_upload_error', 'Photo upload failed: ') . $this->upload->display_errors('', ''));
				$this->create();
				return;
			}
		} else {
			// Default avatar fallback
			$photo_filename = 'candidate-1.png';
		}

		$payload = array(
			'candidate_number'   => (int) $this->input->post('candidate_number', TRUE),
			'chairman_name'      => $this->input->post('chairman_name', TRUE),
			'vice_chairman_name' => $this->input->post('vice_chairman_name', TRUE),
			'vision'             => $this->input->post('vision', TRUE),
			'mission'            => $this->input->post('mission', TRUE),
			'photo'              => $photo_filename,
			'color'              => $this->input->post('color', TRUE) ?: '#6777ef'
		);

		$this->Candidate_model->insert($payload);
		$this->session->set_flashdata('success', sprintf(__t('msg_candidate_added', 'Candidate pair #%s has been successfully registered!'), $payload['candidate_number']));
		redirect('candidate');
	}

	public function edit($id) {
		$this->require_admin();
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', __t('msg_candidate_not_found', 'Candidate record not found.'));
			redirect('candidate');
		}

		$data = array(
			'title'     => __t('edit_candidate_title', 'Edit Candidate Pair'),
			'candidate' => $candidate
		);
		$this->load->view('candidate/edit', $data);
	}

	public function update($id) {
		$this->require_admin();
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', __t('msg_candidate_not_found', 'Candidate record not found.'));
			redirect('candidate');
		}

		$candidate_number = (int) $this->input->post('candidate_number', TRUE);
		if ($this->Candidate_model->is_number_exists($candidate_number, $id)) {
			$this->session->set_flashdata('error', sprintf(__t('msg_candidate_number_taken', 'Ballot number #%s is already used by another candidate.'), $candidate_number));
			redirect('candidate/edit/' . $id);
			return;
		}

		$this->form_validation->set_rules('chairman_name', __t('chairman', 'Chairman Candidate Name'), 'required|trim');
		$this->form_validation->set_rules('vice_chairman_name', __t('vice_chairman', 'Vice Chairman Candidate Name'), 'required|trim');
		$this->form_validation->set_rules('vision', __t('vision', 'Vision'), 'required|trim');
		$this->form_validation->set_rules('mission', __t('mission', 'Mission'), 'required|trim');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id);
			return;
		}

		$photo_filename = $candidate->photo;
		if (!empty($_FILES['photo']['name'])) {
			$config['upload_path']   = './assets/uploads/candidates/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = 3072; // 3MB
			$config['file_name']     = 'candidate_' . time();

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('photo')) {
				$upload_data = $this->upload->data();
				// Remove old photo if custom
				if ($candidate->photo && file_exists(FCPATH . 'assets/uploads/candidates/' . $candidate->photo) && !in_array($candidate->photo, array('candidate-1.png', 'candidate-2.png', 'candidate-3.png', 'avatar-1.png', 'avatar-2.png', 'avatar-3.png'))) {
					@unlink(FCPATH . 'assets/uploads/candidates/' . $candidate->photo);
				}
				$photo_filename = $upload_data['file_name'];
			} else {
				$this->session->set_flashdata('error', __t('msg_photo_upload_error', 'Photo upload failed: ') . $this->upload->display_errors('', ''));
				redirect('candidate/edit/' . $id);
				return;
			}
		}

		$payload = array(
			'candidate_number'   => $candidate_number,
			'chairman_name'      => $this->input->post('chairman_name', TRUE),
			'vice_chairman_name' => $this->input->post('vice_chairman_name', TRUE),
			'vision'             => $this->input->post('vision', TRUE),
			'mission'            => $this->input->post('mission', TRUE),
			'photo'              => $photo_filename,
			'color'              => $this->input->post('color', TRUE) ?: $candidate->color
		);

		$this->Candidate_model->update($id, $payload);
		$this->session->set_flashdata('success', __t('msg_candidate_updated', 'Candidate details updated successfully!'));
		redirect('candidate');
	}

	public function delete($id) {
		$this->require_admin();
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', __t('msg_candidate_not_found', 'Candidate record not found.'));
			redirect('candidate');
		}

		$this->Candidate_model->delete($id);
		$this->session->set_flashdata('success', sprintf(__t('msg_candidate_deleted', 'Candidate #%s (%s) has been successfully deleted.'), $candidate->candidate_number, $candidate->chairman_name));
		redirect('candidate');
	}

	public function detail($id) {
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', __t('msg_candidate_not_found', 'Candidate record not found.'));
			redirect('candidate');
		}

		$data = array(
			'title'     => sprintf(__t('candidate_profile_title', 'Candidate Profile #%s &mdash; %s'), $candidate->candidate_number, $candidate->chairman_name),
			'candidate' => $candidate
		);
		$this->load->view('candidate/detail', $data);
	}
}
