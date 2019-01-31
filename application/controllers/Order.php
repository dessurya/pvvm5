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
		if ($data != null) {
			$this->load->model('m_vendor');
			$result = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $data);
			if ($result == null or $result[0]['NAME'] != $this->uri->segment(4)) {
				redirect(base_url().'index.php/order', 'refresh');
			}
			$viewComp['_tittle_'] .= " : ".strtoupper($this->uri->segment(4));
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

		$viewComp['_link_css_'] .='
		<style type="text/css">
			#orderwastedetail input,
			#orderwastedetail select{
				padding: 3px;
			}
			#orderwastedetail input[name="WASTE_NAME"],
			#orderwastedetail input[name="WASTE_TYPE_NAME"]{
				width: 140px;
			}
			#orderwastedetail input[name="UM_NAME"]{
				width: 65px;
			}
			#orderwastedetail input[name="MAX_LOAD_QTY"],
			#orderwastedetail input[name="KEEP_QTY"],
			#orderwastedetail input[name="REQUEST_QTY"],
			#orderwastedetail input[name="TOTAL_QTY"],
			#orderwastedetail input[name="ACTUAL_REQUEST_QTY"]{
				text-align: right;
				width: 50px;
			}
			#orderwastedetail select[name="VENDOR_NAME"]{
				width: 180px;
			}
		</style>
		';
		$this->parser->parse('_main/index', $viewComp);
	}

	public function getdata($data = null){
		$this->load->model('m_order');
		header('Content-Type: application/json');
		echo $this->m_order->getdata($this->session->userdata('ROLL_ID'), $data);
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
			$response['reload'] = true;

			if ($find['STATUS_ID'] == 101) {
				$this->m_order->changestatus($this->session->userdata('ROLL_ID'), $find['PKK_ID'], $find['STATUS_ID'], 'open');
			}
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function tools($data = null){
		$response = array();
		$response['response'] = true;
		$response['url'] = site_url().'/order/show/'.$_GET['pkk_id'];
		$response['msg'] = 'Success...';
		$response['type'] = $data;
		$send = array();
		$send['post'] = $_POST;
		$send['get'] = $_GET;
		$this->load->model('m_order');
		if ($data == 'verifyvendor') {
			$this->m_order->verifyvendor($this->session->userdata('ROLL_ID'), $send);
			$response['reload'] = true;
		}else if($data == 'saveact') {
			$this->m_order->saveact($this->session->userdata('ROLL_ID'), $send);
			$response['reload'] = false;
		}else if($data == 'submact') {
			// $response['reload'] = $this->m_order->submact($this->session->userdata('ROLL_ID'), $send);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}
}