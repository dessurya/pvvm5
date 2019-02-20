<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		if(!$this->session->userdata('LOGGED') or !in_array($this->session->userdata('ROLL_ID'), array(1,4))) {
			redirect(base_url().'index.php/login', 'refresh');
		}
    }

	public function index($data){
		$urlview = '_main/_history/index.php';
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | HISTORY ".strtoupper($data);
		
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, '', true);

		$this->parser->parse('_main/index', $viewComp);
	}

	public function getdata($data = null){
		$this->load->model('m_history');
		header('Content-Type: application/json');
		echo $this->m_history->getdata($this->session->userdata('ROLL_ID'), $data);
	}

	public function JSON(){
		$this->load->model('m_history');
		header('Content-Type: application/json');
		echo json_encode($this->m_history->finddata($this->session->userdata('ROLL_ID'), 1));
	}

	public function show($data = null){
		$response = array();
		$urlview = '_main/_history/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$send = array();
			$this->load->model('m_history');
			$this->load->model('m_login');
			$find = $this->m_history->finddata($this->session->userdata('ROLL_ID'), $data);
			$find = $find[0];
			$send['head'] = $find;
			$detail = $this->m_login->getdetailauth($find['AUTH_ID'], $find['ROLL_ID']);
			$send['detail'] = $detail;
			$response['response'] = true;
			$response['name'] = 'History : '.$find['CREATED_DATE'];
			$response['result'] = $this->load->view($urlview, $send, true);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

}