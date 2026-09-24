<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $user;

	public function __construct() {
		parent::__construct();

		// Setup i18n Language (default: 'id')
		$lang = $this->session->userdata('site_lang') ?: 'id';
		$folder = ($lang === 'en') ? 'english' : 'indonesian';
		$this->lang->load('app', $folder);

		if ($this->input->is_cli_request()) {
			return;
		}

		if (!$this->session->userdata('logged_in')) {
			$this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk mengakses sistem E-Voting.');
			redirect('auth/login');
		}

		$this->user = (object) array(
			'id'       => $this->session->userdata('user_id'),
			'name'     => $this->session->userdata('name'),
			'username' => $this->session->userdata('username'),
			'role'     => $this->session->userdata('role'),
			'voter_id' => $this->session->userdata('voter_id')
		);
	}

	protected function require_admin() {
		if ($this->user->role !== 'admin') {
			$this->session->set_flashdata('error', 'Akses ditolak! Fitur ini hanya dapat diakses oleh Administrator.');
			redirect('dashboard');
		}
	}

	protected function is_admin() {
		return ($this->user && $this->user->role === 'admin');
	}
}
