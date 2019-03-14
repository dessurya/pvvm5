<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$urlview = '_main/_admin/index.php';

		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | User";
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, '', true);

		$this->parser->parse('_main/index', $viewComp);
	}

	public function show($data = null){
		$response = array();
		$roll_id = $this->session->userdata('ROLL_ID');
		$urlview = '_main/_admin/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$this->load->model('m_admin');
			$find = $this->m_admin->finddata($this->session->userdata('ROLL_ID'), $data);
			$find = $find[0];
			$send = array();
			$send['admin'] = $find;
			$send['history'] = $this->m_admin->findhistory($this->session->userdata('ROLL_ID'), $data);
			$response['response'] = true;
			$response['name'] = 'Vendor : '.$find['NAMA'];
			$response['result'] = $this->load->view($urlview, $send, true);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function getdata($data = null){
		$this->load->model('m_admin');
		header('Content-Type: application/json');
		echo $this->m_admin->getdata($this->session->userdata('ROLL_ID'), $data);
	}

	public function callForm($data = null){
		$data = null;
		$html = '';
		$this->load->model('m_admin');
		$role = $this->session->userdata('ROLL_ID');
		if (isset($_GET['id'])) {
			$id = explode('^', $_GET['id']);
			$data = $this->m_admin->finddata($role, $id);
			foreach ($data as $list) {
				$arrdata = array();
				$arrdata['data'] = $list;
				$arrdata['role'] = $this->m_admin->getRole($role);
				$arrdata['route'] = site_url().'/admin/tools?action=store&id='.$list['USER_ID'];
				$html .= $this->load->view('_main/_admin/form.php', $arrdata, true);
			}
		}else{
			$arrdata = array();
			$arrdata['role'] = $this->m_admin->getRole($role);
			$arrdata['route'] = site_url().'/admin/tools?action=store';
			$html .= $this->load->view('_main/_admin/form.php', $arrdata, true);
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
		$this->load->model('m_admin');
		$response = $this->m_admin->tools($this->session->userdata('ROLL_ID'), $_GET, $_POST);
		$response['reload'] = true;
		header('Content-Type: application/json');
		echo json_encode( $response );
	}
}