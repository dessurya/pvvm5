<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

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
		$urlview = '_main/_role/index.php';

		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Role";
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, '', true);

		$this->parser->parse('_main/index', $viewComp);
	}

	public function show($data = null){
		$response = array();
		$auth_type_id = $this->uri->segment(3);
		// $roll_id = $this->session->userdata('ROLL_ID');
		$urlview = '_main/_role/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$this->load->model('m_role');
			$find = $this->m_role->finddata($auth_type_id, $data);
			$find = $find[0];
			$send = array();
			$send['role'] = $this->m_role->finddata($auth_type_id, $data);
			$send['detail'] = $this->m_role->finddatadetail($data);
			$response['name'] = 'Role : '.$find['AUTH_TYPE_NAME'];
			$response['response'] = true;
			$response['result'] = $this->load->view($urlview, $send, true);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function getdata($data = null){
		$this->load->model('m_role');
		header('Content-Type: application/json');
		echo $this->m_role->getdata($this->session->userdata('ROLL_ID'), $data);
	}

	public function callForm($data = null){
		$data = null;
		$html = '';
		$this->load->model('m_role');
		if (isset($_GET['id'])) {
			$id = explode('^', $_GET['id']);
			$auth_type_id = $_GET['id'];
			// $data = $this->m_role->finddata($auth_type_id, $id);
			// foreach ($data as $list) {
				$arrdata = array();
				$arrdata['role'] = $this->m_role->finddata($auth_type_id, $data);
				// $arrdata['detail'] = $data;
				$arrdata['detail'] = $this->m_role->finddatadetail($auth_type_id, $id);
				// echo "auth_type_id = ".$auth_type_id;
				// echo "<pre>";
				// var_dump($arrdata['detail']);
				// echo "</pre>";
				// exit();

				$arrdata['route'] = site_url().'/role/tools?action=store&id='.$auth_type_id;
				$html .= $this->load->view('_main/_role/form.php', $arrdata, true);
			// }
		}else{
			$data = null;
			$auth_type_id = null;
			// $list_menu = $this->m_role->finddatadetail($auth_type_id, $data);
			$arrdata = array();
			$arrdata['list_menu'] =$this->m_role->findlistmenu();
			$arrdata['route'] = site_url().'/role/tools?action=store';
			$html .= $this->load->view('_main/_role/form.php', $arrdata, true);
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
		$this->load->model('m_role');
		$response = $this->m_role->tools($this->session->userdata('ROLL_ID'), $_GET, $_POST);
		$response['reload'] = true;
		header('Content-Type: application/json');
		echo json_encode( $response );
	}
}