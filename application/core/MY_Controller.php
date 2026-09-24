<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $user;

	public function __construct() {
		parent::__construct();

		// Setup i18n Language (default: 'en')
		$lang = $this->session->userdata('site_lang') ?: 'en';
		$folder = ($lang === 'id') ? 'indonesian' : 'english';
		$this->lang->load('app', $folder);

		if ($this->input->is_cli_request()) {
			return;
		}

		if (!$this->session->userdata('logged_in')) {
			$this->session->set_flashdata('error', __t('msg_login_required', 'Please sign in to access the E-Voting system.'));
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
			$this->session->set_flashdata('error', __t('msg_admin_required', 'Access denied! This feature is restricted to Administrators.'));
			redirect('dashboard');
		}
	}

	protected function is_admin() {
		return ($this->user && $this->user->role === 'admin');
	}
}
