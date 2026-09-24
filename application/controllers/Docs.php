<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docs extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Setup i18n Language (default: 'id')
		$lang = $this->session->userdata('site_lang') ?: 'id';
		$folder = ($lang === 'en') ? 'english' : 'indonesian';
		$this->lang->load('app', $folder);
	}

	public function index() {
		$data = array(
			'title'        => 'Dokumentasi Sistem & Arsitektur Simple E-Vote',
			'active_lang'  => $this->session->userdata('site_lang') ?: 'id',
			'is_logged_in' => (bool) $this->session->userdata('logged_in'),
			'user_name'    => $this->session->userdata('name'),
			'user_role'    => $this->session->userdata('role')
		);

		$this->load->view('docs/index', $data);
	}
}
