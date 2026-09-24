<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docs extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Setup i18n Language (default: 'en')
		$lang = $this->session->userdata('site_lang') ?: 'en';
		$folder = ($lang === 'id') ? 'indonesian' : 'english';
		$this->lang->load('app', $folder);
	}

	public function index() {
		$data = array(
			'title'        => __t('docs_title', 'System Architecture & Documentation &mdash; Simple E-Vote'),
			'active_lang'  => $this->session->userdata('site_lang') ?: 'en',
			'is_logged_in' => (bool) $this->session->userdata('logged_in'),
			'user_name'    => $this->session->userdata('name'),
			'user_role'    => $this->session->userdata('role')
		);

		$this->load->view('docs/index', $data);
	}
}
