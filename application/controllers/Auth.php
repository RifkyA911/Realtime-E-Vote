<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Setup i18n Language (default: 'en')
		$lang = $this->session->userdata('site_lang') ?: 'en';
		$folder = ($lang === 'id') ? 'indonesian' : 'english';
		$this->lang->load('app', $folder);

		$this->load->model('User_model');
	}

	public function login() {
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
		}

		$data = array(
			'title' => __t('login_title', 'Sign In to Simple E-Vote')
		);
		$this->load->view('auth/login', $data);
	}

	public function authenticate() {
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
		}

		$this->form_validation->set_rules('username', __t('username', 'Username / Voter Code'), 'required|trim', array(
			'required' => __t('field_required', '%s is required.')
		));
		$this->form_validation->set_rules('password', __t('password', 'Password'), 'required', array(
			'required' => __t('field_required', '%s is required.')
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

			$role_label = ($user->role === 'admin') ? __t('admin', 'Administrator') : __t('voter', 'Voter (DPT)');
			$this->session->set_flashdata('success', sprintf(__t('msg_welcome_role', 'Welcome, %s! Signed in as %s.'), $user->name, $role_label));

			if ($user->role === 'voter') {
				redirect('vote');
			} else {
				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('error', __t('msg_invalid_credentials', 'Invalid username or password. Please verify your credentials!'));
			redirect('auth/login');
		}
	}

	public function tap_card() {
		if ($this->session->userdata('logged_in')) {
			if ($this->input->is_ajax_request()) {
				$redirect_url = ($this->session->userdata('role') === 'voter') ? base_url('vote') : base_url('dashboard');
				echo json_encode(array(
					'status'   => 'success',
					'message'  => __t('msg_already_logged_in', 'You are already signed in.'),
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
					'message' => __t('msg_tap_card_prompt', 'Please tap your ID card on the reader!')
				));
				return;
			}
			$this->session->set_flashdata('error', __t('msg_tap_card_prompt', 'Please tap your ID card on the reader!'));
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
			$role_label   = ($user->role === 'admin') ? __t('admin', 'Administrator') : __t('voter', 'Voter (DPT)');
			$success_msg  = sprintf(__t('msg_card_verified_welcome', 'Card ID Verified! Welcome, %s (%s).'), $user->name, $role_label);

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
			$error_msg = sprintf(__t('msg_card_unregistered', 'Card ID (%s) is not registered in the E-Voting system!'), htmlspecialchars($card_uid));
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
