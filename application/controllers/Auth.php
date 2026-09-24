<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Setup i18n Language (default: 'id')
		$lang = $this->session->userdata('site_lang') ?: 'id';
		$folder = ($lang === 'en') ? 'english' : 'indonesian';
		$this->lang->load('app', $folder);

		$this->load->model('User_model');
	}

	public function login() {
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
		}

		$data = array(
			'title' => 'Login E-Voting'
		);
		$this->load->view('auth/login', $data);
	}

	public function authenticate() {
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
		}

		$this->form_validation->set_rules('username', 'Username / Kode Pemilih', 'required|trim', array(
			'required' => '%s wajib diisi.'
		));
		$this->form_validation->set_rules('password', 'Password', 'required', array(
			'required' => '%s wajib diisi.'
		));

		if ($this->form_validation->run() === FALSE) {
			$this->login();
			return;
		}

		$username = trim($this->input->post('username', TRUE));
		$password = $this->input->post('password');

		$user = $this->User_model->verify_login($username, $password);

		if ($user) {
			$session_data = array(
				'user_id'   => $user->id,
				'name'      => $user->name,
				'username'  => $user->username,
				'role'      => $user->role,
				'voter_id'  => $user->voter_id,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($session_data);

			$role_label = ($user->role === 'admin') ? 'Administrator' : 'Pemilih (DPT)';
			$this->session->set_flashdata('success', 'Selamat datang, ' . $user->name . '! Anda login sebagai ' . $role_label . '.');

			if ($user->role === 'voter') {
				redirect('vote');
			} else {
				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('error', 'Username atau password tidak sesuai. Silakan periksa kembali!');
			redirect('auth/login');
		}
	}

	public function tap_card() {
		if ($this->session->userdata('logged_in')) {
			if ($this->input->is_ajax_request()) {
				$redirect_url = ($this->session->userdata('role') === 'voter') ? base_url('vote') : base_url('dashboard');
				echo json_encode(array(
					'status'   => 'success',
					'message'  => 'Anda sudah dalam keadaan login.',
					'redirect' => $redirect_url
				));
				return;
			}
			redirect('dashboard');
		}

		$card_uid = trim($this->input->post('card_uid', TRUE));

		if (empty($card_uid)) {
			if ($this->input->is_ajax_request()) {
				echo json_encode(array(
					'status'  => 'error',
					'message' => 'Silakan tempelkan kartu ID / RFID Anda!'
				));
				return;
			}
			$this->session->set_flashdata('error', 'Silakan tempelkan kartu ID / RFID Anda!');
			redirect('auth/login');
			return;
		}

		$user = $this->User_model->get_by_card_uid($card_uid);

		if ($user) {
			$session_data = array(
				'user_id'   => $user->id,
				'name'      => $user->name,
				'username'  => $user->username,
				'role'      => $user->role,
				'voter_id'  => $user->voter_id,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($session_data);

			$redirect_url = ($user->role === 'voter') ? base_url('vote') : base_url('dashboard');
			$role_label   = ($user->role === 'admin') ? 'Administrator' : 'Pemilih (DPT)';
			$success_msg  = 'Kartu ID Terverifikasi! Selamat datang, ' . $user->name . ' (' . $role_label . ').';

			if ($this->input->is_ajax_request()) {
				echo json_encode(array(
					'status'   => 'success',
					'message'  => $success_msg,
					'name'     => $user->name,
					'role'     => $user->role,
					'redirect' => $redirect_url
				));
				return;
			}

			$this->session->set_flashdata('success', $success_msg);
			redirect(($user->role === 'voter') ? 'vote' : 'dashboard');
		} else {
			$error_msg = 'Kartu ID (' . htmlspecialchars($card_uid) . ') tidak terdaftar di sistem E-Voting!';
			if ($this->input->is_ajax_request()) {
				echo json_encode(array(
					'status'  => 'error',
					'message' => $error_msg
				));
				return;
			}

			$this->session->set_flashdata('error', $error_msg);
			redirect('auth/login');
		}
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('auth/login');
	}
}
