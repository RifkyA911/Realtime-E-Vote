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
			'title'      => 'Data Pasangan Calon (Kandidat)',
			'candidates' => $this->Candidate_model->get_with_votes_count()
		);
		$this->load->view('candidate/index', $data);
	}

	public function create() {
		$this->require_admin();
		$next_number = $this->Candidate_model->get_next_number();
		$data = array(
			'title'       => 'Tambah Kandidat Baru',
			'next_number' => $next_number
		);
		$this->load->view('candidate/create', $data);
	}

	public function store() {
		$this->require_admin();
		$this->form_validation->set_rules('candidate_number', 'Nomor Urut', 'required|numeric|is_unique[candidates.candidate_number]', array(
			'required'  => '%s wajib diisi.',
			'numeric'   => '%s harus berupa angka.',
			'is_unique' => '%s sudah digunakan oleh pasangan calon lain.'
		));
		$this->form_validation->set_rules('chairman_name', 'Nama Calon Ketua', 'required|trim', array(
			'required' => '%s wajib diisi.'
		));
		$this->form_validation->set_rules('vice_chairman_name', 'Nama Calon Wakil Ketua', 'required|trim', array(
			'required' => '%s wajib diisi.'
		));
		$this->form_validation->set_rules('vision', 'Visi', 'required|trim', array(
			'required' => '%s wajib diisi.'
		));
		$this->form_validation->set_rules('mission', 'Misi', 'required|trim', array(
			'required' => '%s wajib diisi.'
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
				$this->session->set_flashdata('error', 'Gagal upload foto: ' . $this->upload->display_errors('', ''));
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
		$this->session->set_flashdata('success', 'Pasangan calon no. urut ' . $payload['candidate_number'] . ' berhasil ditambahkan!');
		redirect('candidate');
	}

	public function edit($id) {
		$this->require_admin();
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', 'Data kandidat tidak ditemukan.');
			redirect('candidate');
		}

		$data = array(
			'title'     => 'Edit Data Kandidat',
			'candidate' => $candidate
		);
		$this->load->view('candidate/edit', $data);
	}

	public function update($id) {
		$this->require_admin();
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', 'Data kandidat tidak ditemukan.');
			redirect('candidate');
		}

		$candidate_number = (int) $this->input->post('candidate_number', TRUE);
		if ($this->Candidate_model->is_number_exists($candidate_number, $id)) {
			$this->session->set_flashdata('error', 'Nomor urut ' . $candidate_number . ' sudah dipakai kandidat lain.');
			redirect('candidate/edit/' . $id);
			return;
		}

		$this->form_validation->set_rules('chairman_name', 'Nama Calon Ketua', 'required|trim');
		$this->form_validation->set_rules('vice_chairman_name', 'Nama Calon Wakil Ketua', 'required|trim');
		$this->form_validation->set_rules('vision', 'Visi', 'required|trim');
		$this->form_validation->set_rules('mission', 'Misi', 'required|trim');

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
				$this->session->set_flashdata('error', 'Gagal upload foto: ' . $this->upload->display_errors('', ''));
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
		$this->session->set_flashdata('success', 'Data kandidat berhasil diperbarui!');
		redirect('candidate');
	}

	public function delete($id) {
		$this->require_admin();
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', 'Data kandidat tidak ditemukan.');
			redirect('candidate');
		}

		$this->Candidate_model->delete($id);
		$this->session->set_flashdata('success', 'Kandidat no. urut ' . $candidate->candidate_number . ' (' . $candidate->chairman_name . ') berhasil dihapus.');
		redirect('candidate');
	}

	public function detail($id) {
		$candidate = $this->Candidate_model->get_by_id($id);
		if (!$candidate) {
			$this->session->set_flashdata('error', 'Data kandidat tidak ditemukan.');
			redirect('candidate');
		}

		$data = array(
			'title'     => 'Profil Lengkap Kandidat No. ' . $candidate->candidate_number,
			'candidate' => $candidate
		);
		$this->load->view('candidate/detail', $data);
	}
}
