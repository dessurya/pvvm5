<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approve extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		if(!$this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/login', 'refresh');
		}
		$this->load->model('m_admin');
		if ($this->m_admin->checkAcces($this->session->userdata('ROLL_ID')) == false) {
			redirect(base_url().'index.php/profile', 'refresh');
		}
    }

	public function index(){
		$urlview = '_main/_order/index.php';
		$send = array();
		$send['tittle'] = "Approval";
		$send['approve'] = true;
		$viewComp = array();
		$viewComp['_tittle_'] = "PWMS | Approval";
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, $send, true);
		$this->parser->parse('_main/index', $viewComp);
	}

	public function getdata(){
		$data = "approve";
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
			$send['approve'] = true;
			$this->load->model('m_order');
			$find = $this->m_order->finddata($roll_id, $data);
			$find = $find[0];
			$send['head'] = $find;
			$send['detail'] = $this->m_order->finddatadetail($roll_id, $data);
			$send['attachment_tongkang'] = $this->m_order->getAttachment($roll_id, $data, 'TONGKANG');
			$send['attachment_trucking'] = $this->m_order->getAttachment($roll_id, $data, 'TRUCKING');
			$send['history'] = $this->m_order->history($roll_id, $data);
			$send['all_status'] = $this->m_order->getallstatus();
			$response['response'] = true;
			$response['name'] = 'Order Waste : '.$find['PKK_NO'];
			$response['result'] = $this->load->view($urlview, $send, true);
			$response['reload'] = true;
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function tools($data = null){
		$roll_id = $this->session->userdata('ROLL_ID');
		$response = array();
		$response['response'] = true;
		$response['url'] = site_url().'/approve/show/'.$_GET['warta_kapal_in_id'];
		$response['msg'] = 'Success...';
		$response['type'] = 'orderrecalldetail';
		$response['reload'] = true;
		$send = array();
		$send['post'] = $_POST;
		$send['get'] = $_GET;
		$response['post'] = $_POST;
		$response['get'] = $_GET;
		$this->load->model('m_order');
		if($data == 'revised'){
			$fbck = $this->m_order->revised($roll_id, $send);
		}else if($data == 'approved'){
			$fbck = $this->m_order->approved($roll_id, $send);
		}

		if ($fbck == null) {
			header('Content-Type: application/json');
			echo json_encode( $response );
		}else if ($fbck == 'sendapi') {
			$response['id'] = $_GET['warta_kapal_in_id'];
			$this->sendapi($response);
		}
	}

	private function sendapi($dataPost){
		$curl = curl_init();
		$data = array();
		// $data[CURLOPT_URL] = "http://localhost/pwms_api/devlop/index.php/inaport/sendapi";
		$data[CURLOPT_URL] = "http://10.10.33.56/cfs_dev/_pwms_api/devlop/index.php/inaport/sendapi";
		$data[CURLOPT_RETURNTRANSFER] = true;
		$data[CURLOPT_SSL_VERIFYPEER] = false;
		$data[CURLOPT_ENCODING] = "";
		$data[CURLOPT_MAXREDIRS] = 10;
		$data[CURLOPT_TIMEOUT] = 30;
		$data[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
		$data[CURLOPT_CUSTOMREQUEST] = "POST";
		$data[CURLOPT_POSTFIELDS] = $dataPost['id'];
		curl_setopt_array($curl,$data);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			$dataPost['apires'] = "cURL Error #:" . $err;
		} else {
			$dataPost['apires'] = $response;
		}
		header('Content-Type: application/json');
		echo json_encode($dataPost);
	}

}