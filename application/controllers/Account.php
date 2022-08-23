<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		$this->load->model('M_account', 'account');
	}

	public function index(){
		$this->global['pageTitle'] = 'BODC-Dashboard : Sign In';
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$this->load->view('V_sign_in', $data);
	}

	public function sign_in_process(){
		$username = strip_tags(str_replace("'", "", $this->input->post('username')));
		$password = strip_tags(str_replace("'", "", $this->input->post('password')));

		$data = [
			'username' => $username,
			'password' => md5($password)
		];

		$check = $this->account->sign_in_process($data);

		if(count($check) > 0){
			$username = $check[0]['username'];
			$this->session->set_userdata('username', $username);
			redirect(base_url().'Dashboard','refresh');
		}else{
			$this->session->set_flashdata('error', 'Username or password mismatch');
			redirect(base_url(),'refresh');
		}
	}
	public function sign_out_process(){
		$this->session->sess_destroy();
		redirect(base_url(),'refresh');
	}
}
