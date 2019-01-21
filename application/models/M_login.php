<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function signin($username, $password){
		$result = array();
		$result['response'] = true;
		$result['msg'] = "Success to sign in";
		$resultofexcute = $this->findauth($this->db->escape($username), $this->db->escape($password));
		if ($resultofexcute['response'] == true and $resultofexcute['active'] == 'Y') {
			$setsesion['LOGGED'] = true;
			$setsesion['IP'] = $_SERVER['REMOTE_ADDR'];
			$setsesion['USERNAME'] = $username;
			$setsesion['ROLL_ID'] = $resultofexcute['data']['ROLLID'];
			$setsesion['ROLLNAME'] = $resultofexcute['data']['ROLLNAME'];
			$setsesion['AUTH_ID'] = $resultofexcute['data']['DETAILAUTH']['AUTH_ID'];
			$setsesion['NAME'] = $resultofexcute['data']['DETAILAUTH']['NAME'];
			$setsesion['EMAIL'] = $resultofexcute['data']['DETAILAUTH']['EMAIL'];
			$setsesion['TABLE_NAME'] = $resultofexcute['data']['TABLE_NAME'];
			$this->session->set_userdata($setsesion);
		} else{
			$result['response'] = false;
			$result['msg'] = "Fail to sign in, Please check your username and password...";
			if ($resultofexcute['active'] == 'N') {
				$result['msg'] = "Your account is not active, please contact administrator for actived your account... thank you...";
			}
		}
		return $result;
	}

	private function findauth($username, $password){
		$result = array();
		$result['response'] = false;
		$result['data'] = null;
		$result['active'] = null;
		$query = "SELECT * FROM APWMS_TX_AUTH WHERE USERNAME=".$username." AND PASSWORD=".$password;
		$runQuery = $this->db->query($query);
		if ($runQuery->num_rows() > 0) {
			$arrdata = $runQuery->result_array();
			$this->db->set('LAST_LOGIN', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
			$this->db->where('ID', $arrdata[0]['ID']);
			$this->db->update('APWMS_TX_AUTH');
			$getdetailauth = $this->getdetailauth($arrdata[0]['ID'], $arrdata[0]['TYPE']);
			$result['response'] = true;
			$result['data'] = $getdetailauth;
			$result['active'] = $arrdata[0]['FLAG_ACTIVE'];
		}
		return $result;
	}

	public function getdetailauth($id, $type){
		$result = array();
		$query = "SELECT * FROM APWMS_TR_AUTH_TYPE WHERE ID=".$type;
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		$result['ROLLID'] = $type;
		$result['ROLLNAME'] = $arrdata[0]['NAME'];
		$result['TABLE_NAME'] = $arrdata[0]['TABLE_NAME'];
		$query2 = "SELECT * FROM ".$arrdata[0]['TABLE_NAME']." WHERE AUTH_ID=".$id;
		$runQuery2 = $this->db->query($query2);
		$arrdata2 = $runQuery2->result_array();
		$result['DETAILAUTH'] = $arrdata2[0];
		return $result;
	}
}
?>