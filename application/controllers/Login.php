<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public $content;
	public function __construct() {
		parent::__construct();
    }

	public function index($data = null){
		if($this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/dashboard', 'refresh');
		}
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Sign In Area";
		$this->parser->parse('_login/index', $viewComp);
	}

	public function signin(){
		if($this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/dashboard', 'refresh');
		}
		$result = array();
		$result['response'] = false;
		$result['msg'] = "must post request";
		if (strtolower($_SERVER['REQUEST_METHOD'])=="post") {
			$this->load->model('m_login');
			$result = $this->m_login->signin($this->input->post('username'), md5($this->input->post('password')));
		}
		header('Content-Type: application/json');
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
		header('Content-Type: application/json');
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
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function checkNotivication(){
		$result = array();
		if(!$this->session->userdata('LOGGED')) {
			$result['response'] = false;
			$result['msg'] = "You Log Out...";
		}
		$this->load->model('m_login');
		$notiv = $this->m_login->getNotiv($this->session->userdata('ROLL_ID'));
		$result['response'] = $notiv['response'];
		$result['notif'] = $notiv['notiv'];
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}