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
		$this->load->model('m_admin');
		if ($this->m_admin->checkAcces($this->session->userdata('ROLL_ID')) == false) {
			redirect(base_url().'index.php/profile', 'refresh');
		}
    }

	public function index($data = null){
		$roll_id = $this->session->userdata('ROLL_ID');
		$urlview = '_main/_vendor/index.php';

		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Vendor";
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, '', true);

		$this->parser->parse('_main/index', $viewComp);
	}

	public function show($data = null){
		$response = array();
		$roll_id = $this->session->userdata('ROLL_ID');
		$urlview = '_main/_vendor/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$this->load->model('m_vendor');
			$find = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $data);
			$find = $find[0];
			$send = array();
			$send['vendor'] = $find;
			$send['orderinfo'] = $this->m_vendor->orderinfo($this->session->userdata('ROLL_ID'), $data);
			$send['history'] = $this->m_vendor->findhistory($this->session->userdata('ROLL_ID'), $data);
			$response['response'] = true;
			$response['name'] = 'Vendor : '.$find['NAMA'];
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
				$html .= $this->load->view('_main/_vendor/form.php', $arrdata, true);
			}
		}else{
			$arrdata = array();
			$arrdata['route'] = site_url().'/vendor/tools?action=store';
			$html .= $this->load->view('_main/_vendor/form.php', $arrdata, true);
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
		if ($response['response'] == false) {
			$response['reload'] = false;
		}
		header('Content-Type: application/json');
		echo json_encode( $response );
	}
}