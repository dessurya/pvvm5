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

	public function index($data){
		$urlview = '_main/_order/index.php';
		if ($data == 'list') {
			$tittle = 'Order List';
		}else if ($data == 'pickup') {
			$tittle = 'Pick Up Order';
		}
		$send['tittle'] = $tittle;
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | ".$tittle;
		if ($data == 'for') {
			// $this->load->model('m_vendor');
			// $result = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $data);
			// if ($result == null or $result[0]['NAME'] != $this->uri->segment(4)) {
			// 	redirect(base_url().'index.php/order', 'refresh');
			// }
			// $viewComp['_tittle_'] .= " : ".strtoupper($this->uri->segment(4));
		}
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, $send, true);
		$this->parser->parse('_main/index', $viewComp);
	}

	public function getdata($data){
		$this->load->model('m_order');
		header('Content-Type: application/json');
		echo $this->m_order->getdata($this->session->userdata('ROLL_ID'), $data);
	}

	public function show($data = null){
		$response = array();
		$roll_id = $this->session->userdata('ROLL_ID');
		if($roll_id == 1 or $roll_id == 4) {
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