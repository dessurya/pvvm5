<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

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
			$urlview = '_main/_order/index.php';
		}else if($roll_id == 2) {
			$urlview = '_main/_order/shipping_agent.php';
		}else if($roll_id == 3) {
			$urlview = '_main/_order/index.php';
		}

		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Order";
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
		$this->load->model('m_order');
		header('Content-Type: application/json');
		echo $this->m_order->getdata($this->session->userdata('ROLL_ID'));
	}

	public function show($data = null){
		$response = array();
		$roll_id = $this->session->userdata('ROLL_ID');
		if($roll_id == 1) {
			$urlview = '_main/_order/show.php';
		}else if($roll_id == 2) {
			$urlview = '_main/_order/shipping_agent.php';
		}else if($roll_id == 3) {
			$urlview = '_main/_order/show.php';
		}

		if ($data == null) {
			$response['response'] = false;
		}else{
			$send = array();
			$this->load->model('m_order');
			$find = $this->m_order->finddata($this->session->userdata('ROLL_ID'), $data);
			$find = $find[0];
			$send['head'] = $find;
			$send['detail'] = $this->m_order->finddatadetail($this->session->userdata('ROLL_ID'), $data);
			$send['history'] = $this->m_order->history($this->session->userdata('ROLL_ID'), $data);
			$response['response'] = true;
			$response['name'] = 'Order Waste : '.$find['PKK_ID'];
			$response['result'] = $this->load->view($urlview, $send, true);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

}