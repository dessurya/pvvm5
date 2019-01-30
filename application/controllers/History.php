<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		if(!$this->session->userdata('LOGGED') or $this->session->userdata('ROLL_ID') != 1) {
			redirect(base_url().'index.php/login', 'refresh');
		}
    }

	public function index($data = null){
		$urlview = '_main/_history/index.php';
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | History";
		if ($data != null) {
			if ($this->uri->segment(5) == 'vendor') {
				$this->load->model('m_vendor');
				$result = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $data);
				if ($result == null or $result[0]['NAME'] != $this->uri->segment(4)) {
					redirect(base_url().'index.php/order', 'refresh');
				}
				$viewComp['_tittle_'] .= " : ".strtoupper($this->uri->segment(4));
			}
		}
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, '', true);

		$viewComp['_link_css_'] .= '<link href="'.base_url().'/_asset/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">';
	    $viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>';

	    $viewComp['_link_css_'] .= '<link href="'.base_url().'/_asset/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/iCheck/icheck.js"></script>';

	    $viewComp['_link_css_'] .= '<link href="'.base_url().'/_asset/jQuery-autoComplete-master/jquery.auto-complete.css" rel="stylesheet">';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/jQuery-autoComplete-master/jquery.auto-complete.js"></script>';


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