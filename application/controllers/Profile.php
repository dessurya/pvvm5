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
		$this->load->model('m_profile');
		$roll_id = $this->session->userdata('ROLL_ID');
		// var_dump($this->session->userdata('AUTH_ID'));
		// exit();
		//old query
		// $query = "SELECT * FROM ".$this->session->userdata('TABLE_NAME')." WHERE AUTH_ID=".$this->session->userdata('AUTH_ID');
		// $runQuery = $this->db->query($query);
		// $detailProfile = $runQuery->result_array();
		$detailProfile = $this->m_profile->getdetail($this->session->userdata('ROLL_ID'), $this->session->userdata('AUTH_ID'));
		$arrdata = array();
		$arrdata['detailProfile'] = $detailProfile[0];
		$arrdata['route'] = site_url().'/profile/changepass?username='.$detailProfile[0]['USERNAME'].'&auth_id='.$detailProfile[0]['AUTH_ID'];
		if ($roll_id == 1) { // ipc cabang
			return $this->load->view('_main/_profile/user.php', $arrdata, true);
		}else if($roll_id == 2) { // shipping agent
			return $this->load->view('_main/_profile/shipping_agent.php', $arrdata, true);
		}else if($roll_id == 3) { // vendor
			return $this->load->view('_main/_profile/vendor.php', $arrdata, true);
		}
	}


	public function getdata($data = null){
		$this->load->model('m_order');	
		$this->load->model('m_profile');
		$roll_id = $this->session->userdata('ROLL_ID');

		header('Content-Type: application/json');
		if ($roll_id == 1) { // ipc cabang
			echo $this->m_profile->getdata($this->session->userdata('ROLL_ID'), $data, $this->session->userdata('AUTH_ID'));
		}else if($roll_id == 2) { // shipping agent
			echo $this->m_profile->getdata($this->session->userdata('ROLL_ID'), $data, $this->session->userdata('AUTH_ID'));
		}else if($roll_id == 3) { // vendor
			echo $this->m_profile->getdata($this->session->userdata('ROLL_ID'), $data, $this->session->userdata('AUTH_ID'));
		}
		// echo $this->m_profile->getdata($this->session->userdata('ROLL_ID'), $data, $this->session->userdata('AUTH_ID'));
	}

	public function JSON(){
		$this->load->model('m_history');
		header('Content-Type: application/json');
		echo json_encode($this->m_history->finddata($this->session->userdata('ROLL_ID'), 1));
	}

	public function callForm($data = null){
		$data = null;
		$html = '';
		$roll_id = $this->session->userdata('ROLL_ID');
		if ($roll_id == 3) {
			$url_view = '_main/_profile/form_vendor.php';
		} else {
			$url_view = '_main/_profile/form_user.php';
		}
		if (isset($_GET['id'])) {
			$this->load->model('m_profile');
			$id = explode('^', $_GET['id']);
			$data = $this->m_profile->finddata($this->session->userdata('ROLL_ID'), $id);
			// var_dump($data);
			foreach ($data as $list) {
				$arrdata = array();
				$arrdata['data'] = $list;
				$arrdata['route'] = site_url().'/profile/tools?action=store&id='.$list['ID'];
				$html .= $this->load->view($url_view, $arrdata, true);
			}
		}else{
			$arrdata = array();
			$arrdata['route'] = site_url().'/profile/tools?action=store';
			$html .= $this->load->view($url_view, $arrdata, true);
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
		$this->load->model('m_profile');
		$response = $this->m_profile->tools($this->session->userdata('ROLL_ID'), $_GET, $_POST);
		$response['reload'] = true;
		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function changepass($data = null){
		$this->load->model('m_profile');
		$response = $this->m_profile->changepass($this->session->userdata('USERNAME'), $_GET, $_POST);
		$response['reload'] = true;
		header('Content-Type: application/json');
		echo json_encode( $response );
	}
}