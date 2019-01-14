<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public $content;
	public function __construct() {
		parent::__construct();
    }

	public function index($data = null){
		if($this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/profile', 'refresh');
		}
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Sign In Area";
		$this->parser->parse('_login/index', $viewComp);
	}

	public function signin(){
		if($this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/profile', 'refresh');
		}
		$result = array();
		$result['response'] = false;
		$result['msg'] = "Fail to sign in, Please check your username and password...";

		if (strtolower($_SERVER['REQUEST_METHOD'])=="post") {
			$this->load->model('m_login');
			$resultofsignin = $this->m_login->signin($this->input->post('username'), md5($this->input->post('password')));

			$result['response'] = $resultofsignin;
			if ($resultofsignin == true) {
				$result['msg'] = "Success to sign in";
			}
		}
		echo json_encode($result);
	}

	public function signout(){
		if(!$this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/login', 'refresh');
		}
		$result = array();
		$result['response'] = false;
		$result['msg'] = "Fail to sign out";
		if (strtolower($_SERVER['REQUEST_METHOD'])=="post") {
			$this->session->sess_destroy();
			$result['response'] = true;
			$result['msg'] = "Success to sign out";
		}
		echo json_encode($result);
	}

	public function getMenu(){
		$result = array();
		if(!$this->session->userdata('LOGGED')) {
			$result['response'] = false;
			$result['msg'] = "You Log Out...";
		}
		$this->load->model('m_menu');
		$result['response'] = true;
		$result['msg'] = "Success to get menu...";
		$result['menu'] = $this->m_menu->getMenu($this->session->userdata('ROLL_ID'));
		echo json_encode($result);
	}
}