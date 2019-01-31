<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		if(!$this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/login', 'refresh');
		}
    }

	public function index($data = null){
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Profile";
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->getContent();

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

	private function getContent(){
		$roll_id = $this->session->userdata('ROLL_ID');
		$query = "SELECT * FROM ".$this->session->userdata('TABLE_NAME')." WHERE AUTH_ID=".$this->session->userdata('AUTH_ID');
		$runQuery = $this->db->query($query);
		$detailProfile = $runQuery->result_array();

		$arrdata = array();
		$arrdata['detailProfile'] = $detailProfile[0];
		if ($roll_id == 1) { // ipc cabang
			return $this->load->view('_main/_profile/ipc_cabang.php', $arrdata, true);
		}else if($roll_id == 2) { // shipping agent
			return $this->load->view('_main/_profile/shipping_agent.php', $arrdata, true);
		}else if($roll_id == 2) { // vendor
			return $this->load->view('_main/_profile/vendor.php', $arrdata, true);
		}
	}

	public function getdata($data = null){
		$this->load->model('m_profile');
		header('Content-Type: application/json');
		echo $this->m_profile->getdata($this->session->userdata('ROLL_ID'), $data, $this->session->userdata('AUTH_ID'));
	}

	public function JSON(){
		$this->load->model('m_history');
		header('Content-Type: application/json');
		echo json_encode($this->m_history->finddata($this->session->userdata('ROLL_ID'), 1));
	}

	public function show($data = null){
		$response = array();
		$urlview = '_main/_profile/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$send = array();
			$this->load->model('m_profile');
			$this->load->model('m_login');
			$find = $this->m_profile->finddata($this->session->userdata('ROLL_ID'), $data);
			$find = $find[0];
			$send['head'] = $find;
			$detail = $this->m_login->getdetailauth($find['AUTH_ID'], $find['ROLL_ID']);
			$send['detail'] = $detail;
			$response['response'] = true;
			$response['name'] = 'Activity : '.$find['CREATED_DATE'];
			$response['result'] = $this->load->view($urlview, $send, true);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

}