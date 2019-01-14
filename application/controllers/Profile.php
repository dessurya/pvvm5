<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
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
		$this->parser->parse('_main/index', $viewComp);
	}

	public function show($data = null){
		$this->index();
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

}