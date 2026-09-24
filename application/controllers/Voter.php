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
			'title'         => 'Data Pemilih Tetap (DPT)',
			'voters'        => $this->Voter_model->get_all(),
			'total_voters'  => $this->Voter_model->count_all(),
			'total_voted'   => $this->Voter_model->count_voted(),
			'total_unvoted' => $this->Voter_model->count_unvoted()
		);
		$this->load->view('voter/index', $data);
	}

	public function create() {
		$data = array(
			'title' => 'Tambah Data Pemilih Baru'
		);
		$this->load->view('voter/create', $data);
	}

	public function store() {
		$this->form_validation->set_rules('voter_code', 'Kode Pemilih / NIM / NIS', 'required|trim|is_unique[voters.voter_code]', array(
			'required'  => '%s wajib diisi.',
			'is_unique' => '%s sudah terdaftar di sistem.'
		));
		$this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim', array(
			'required' => '%s wajib diisi.'
		));
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required|in_list[L,P]');
		$this->form_validation->set_rules('class_or_dept', 'Kelas / Jurusan / Unit', 'required|trim', array(
			'required' => '%s wajib diisi.'
		));

		if ($this->form_validation->run() === FALSE) {
			$this->create();
			return;
		}

		$card_uid = trim($this->input->post('card_uid', TRUE));
		if (!empty($card_uid) && $this->Voter_model->is_card_uid_exists($card_uid)) {
			$this->session->set_flashdata('error', 'UID Kartu ' . $card_uid . ' sudah terdaftar untuk pemilih lain.');
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
		$this->session->set_flashdata('success', 'Pemilih ' . $payload['name'] . ' (' . $payload['voter_code'] . ') berhasil didaftarkan!');
		redirect('voter');
	}

	public function edit($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', 'Data pemilih tidak ditemukan.');
			redirect('voter');
		}

		$data = array(
			'title' => 'Edit Data Pemilih',
			'voter' => $voter
		);
		$this->load->view('voter/edit', $data);
	}

	public function update($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', 'Data pemilih tidak ditemukan.');
			redirect('voter');
		}

		$voter_code = strtoupper(trim($this->input->post('voter_code', TRUE)));
		if ($this->Voter_model->is_code_exists($voter_code, $id)) {
			$this->session->set_flashdata('error', 'Kode pemilih ' . $voter_code . ' sudah digunakan oleh pemilih lain.');
			redirect('voter/edit/' . $id);
			return;
		}

		$card_uid = trim($this->input->post('card_uid', TRUE));
		if (!empty($card_uid) && $this->Voter_model->is_card_uid_exists($card_uid, $id)) {
			$this->session->set_flashdata('error', 'UID Kartu ' . $card_uid . ' sudah dipakai oleh pemilih lain.');
			redirect('voter/edit/' . $id);
			return;
		}

		$this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required|in_list[L,P]');
		$this->form_validation->set_rules('class_or_dept', 'Kelas / Jurusan / Unit', 'required|trim');

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
		$this->session->set_flashdata('success', 'Data pemilih berhasil diperbarui!');
		redirect('voter');
	}

	public function delete($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', 'Data pemilih tidak ditemukan.');
			redirect('voter');
		}

		$this->Voter_model->delete($id);
		$this->session->set_flashdata('success', 'Pemilih ' . $voter->name . ' berhasil dihapus.');
		redirect('voter');
	}

	public function reset_status($id) {
		$voter = $this->Voter_model->get_by_id($id);
		if (!$voter) {
			$this->session->set_flashdata('error', 'Data pemilih tidak ditemukan.');
			redirect('voter');
		}

		$this->Voter_model->reset_voter_status($id);
		$this->session->set_flashdata('success', 'Status pemilih ' . $voter->name . ' telah di-reset menjadi Belum Memilih.');
		redirect('voter');
	}

	public function reset_all() {
		$this->Voter_model->reset_all();
		$this->session->set_flashdata('success', 'Semua data suara berhasil di-reset! Semua pemilih kembali berstatus Belum Memilih.');
		redirect('voter');
	}
}
