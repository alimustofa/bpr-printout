<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AuthModel');
	}

	public function index()
	{
		if (isset($this->session->userdata['login'])) {
			redirect('/admin/dashboard');
		}

		$this->load->view('admin/login');
	}

	public function action_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$checkUser = $this->AuthModel->checkUser($username, $password);

		if ($checkUser->num_rows() === 1) {
			$userData = $checkUser->row();
			$sessionData = [
				'id' => $userData->user_id,
				'username' => $userData->username,
				'type' => $userData->level,
			];

			$this->session->set_userdata('login', $sessionData);
			
			if ($userData->level == 'user') {
				redirect('/user/dashboard',$sessionData);
			}else{
				redirect('/admin/dashboard');
			}
		} else {
			$this->session->set_flashdata('response', [
				'error' => true,
				'msg' => 'Username atau password salah'
			]);

			redirect('/admin/auth');
		}
	}

	public function logout()
	{
		// print_r($this->session->userdata['login']['type']);die();
		if ($this->session->userdata['login']['type'] == 'user') { 
			$page = '/user/usermgt';
		}else{
			$page = '/admin/auth';
		}

		// print_r($page);die();
		$this->session->sess_destroy();

		redirect($page);
	}
}