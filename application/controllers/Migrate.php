<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->require_admin();
		$this->load->model('Voter_model');
	}

	public function index() {
		$this->seed();
	}

	public function seed() {
		$sql_file = FCPATH . 'database.sql';
		if (!file_exists($sql_file)) {
			echo "File database.sql tidak ditemukan!";
			return;
		}

		$sql_content = file_get_contents($sql_file);
		
		// Split sql by semicolon
		$queries = explode(";\n", $sql_content);

		$this->db->trans_start();
		foreach ($queries as $query) {
			$trimmed = trim($query);
			if (!empty($trimmed)) {
				$this->db->query($trimmed);
			}
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$msg = 'Migrasi & Seed database gagal dilakukan.';
			if ($this->input->is_cli_request()) {
				echo $msg . PHP_EOL;
				return;
			}
			$this->session->set_flashdata('error', $msg);
			redirect('dashboard');
		} else {
			$msg = 'Database e_vote berhasil dimigrasi dan di-seed dengan data awal!';
			if ($this->input->is_cli_request()) {
				echo $msg . PHP_EOL;
				return;
			}
			$this->session->set_flashdata('success', $msg);
			redirect('dashboard');
		}
	}

	public function reset() {
		$this->Voter_model->reset_all();
		$msg = 'Semua suara berhasil di-reset menjadi kosong.';
		if ($this->input->is_cli_request()) {
			echo $msg . PHP_EOL;
			return;
		}
		$this->session->set_flashdata('success', $msg);
		redirect('dashboard');
	}
}
