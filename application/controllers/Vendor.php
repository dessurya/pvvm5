<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		if(!$this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/login', 'refresh');
		}
    }

	public function index($data = null){
		$roll_id = $this->session->userdata('ROLL_ID');
		if($roll_id == 1) {
			$urlview = '_main/_vendor/ipc_cabang.php';
		}else if($roll_id == 2) {
			$urlview = '_main/_vendor/shipping_agent.php';
		}else if($roll_id == 3) {
			$urlview = '_main/_vendor/index.php';
		}

		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Vendor";
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

	public function show($data = null){
		$response = array();
		$roll_id = $this->session->userdata('ROLL_ID');
		if($roll_id == 1) {
			$urlview = '_main/_vendor/show_ipc_cabang.php';
		}else if($roll_id == 2) {
			$urlview = '_main/_vendor/shipping_agent.php';
		}else if($roll_id == 3) {
			$urlview = '_main/_vendor/index.php';
		}

		if ($data == null) {
			$response['response'] = false;
		}else{
			$this->load->model('m_vendor');
			$find = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $data);
			$find = $find[0];
			$send = array();
			$send['vendor'] = $find;
			$response['response'] = true;
			$response['name'] = 'Vendor : '.$find['NAME'];
			$response['result'] = $this->load->view($urlview, $send, true);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function getdata($data = null){
		$this->load->model('m_vendor');
		header('Content-Type: application/json');
		echo $this->m_vendor->getdata($this->session->userdata('ROLL_ID'), $data);
	}

	public function callForm($data = null){
		$data = null;
		$html = '';
		if (isset($_GET['id'])) {
			$this->load->model('m_vendor');
			$id = explode('^', $_GET['id']);
			$data = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $id);
			foreach ($data as $list) {
				$arrdata = array();
				$arrdata['data'] = $list;
				$arrdata['route'] = site_url().'/vendor/tools?action=store&id='.$list['VENDOR_ID'];
				$html .= $this->load->view('_main/_vendor/ipc_cabang-form.php', $arrdata, true);
			}
		}else{
			$arrdata = array();
			$arrdata['route'] = site_url().'/vendor/tools?action=store';
			$html .= $this->load->view('_main/_vendor/ipc_cabang-form.php', $arrdata, true);
		}
		header('Content-Type: application/json');
		echo json_encode(
			array(
				"response"=>true,
				"result"=>$html
			)
		);
	}

	public function tools($data = null){
		$this->load->model('m_vendor');
		$response = $this->m_vendor->tools($this->session->userdata('ROLL_ID'), $_GET, $_POST);
		$response['reload'] = true;
		header('Content-Type: application/json');
		echo json_encode( $response );
	}
}