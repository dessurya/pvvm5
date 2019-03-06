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

	public function index($data, $show = null){
		$urlview = '_main/_order/index.php';
		if ($data == 'list') {
			$tittle = 'Order List';
		}else if ($data == 'pickup') {
			$tittle = 'Pick Up Order';
		}
		$send['tittle'] = $tittle;
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | ".$tittle;
		if ($show == 'for') {
			$this->load->model('m_vendor');
			$result = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $this->uri->segment(5));
			if ($result == null and $result[0]['VENDOR_ID'] != $this->uri->segment(5)) {
				redirect(base_url().'index.php/order', 'refresh');
			}
			$viewComp['_tittle_'] .= " : ".strtoupper($result[0]['NAMA']);
			$send['showNama'] = strtoupper($result[0]['NAMA']);
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
		$urlview = '_main/_order/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$roll_id = $this->session->userdata('ROLL_ID');
			$send = array();
			$this->load->model('m_order');
			$find = $this->m_order->finddata($roll_id, $data);
			$find = $find[0];
			$send['head'] = $find;
			$send['detail'] = $this->m_order->finddatadetail($roll_id, $data);
			$send['history'] = $this->m_order->history($roll_id, $data);
			$response['response'] = true;
			$response['name'] = 'Order Waste : '.$find['PKK_NO'];
			$response['result'] = $this->load->view($urlview, $send, true);
			$response['reload'] = true;
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function tools($data = null){
		$response = array();
		$response['response'] = true;
		$response['url'] = site_url().'/order/show/'.$_GET['warta_kapal_in_id'];
		$response['msg'] = 'Success...';
		$response['type'] = 'orderrecalldetail';
		$response['reload'] = true;
		$send = array();
		$send['post'] = $_POST;
		$send['get'] = $_GET;
		$this->load->model('m_order');
		if ($data == 'store') {
			$fbck = $this->m_order->store($this->session->userdata('ROLL_ID'), $send);
		}else if($data == 'pickupordersubmit') {
			$fbck = $this->m_order->pickupordersubmit($this->session->userdata('ROLL_ID'), $send);
		}

		if ($fbck == null) {
			header('Content-Type: application/json');
			echo json_encode( $response );
		}else if ($fbck == 'sendapi') {
			$response['id'] = $_GET['warta_kapal_in_id'];
			$this->session->set_flashdata('send',$response);
			redirect(base_url().'index.php/api/sendapi');
		}
	}

}