<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		date_default_timezone_set('Asia/Jakarta');
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
			$setsesion['NAME'] = $resultofexcute['data']['DETAILAUTH']['NAMA'];
			$setsesion['EMAIL'] = $resultofexcute['data']['DETAILAUTH']['EMAIL'];
			$setsesion['TABLE_NAME'] = $resultofexcute['data']['TABLE_NAME'];
			$setsesion['PHOTO'] = $resultofexcute['data']['DETAILAUTH']['PHOTO'];
			if ($resultofexcute['data']['ROLLID'] == 3 or $resultofexcute['data']['ROLLID'] == 4) {
				$setsesion['VENDOR_ID'] = $resultofexcute['data']['DETAILAUTH']['VENDOR_ID'];
				$setsesion['DETAIL_ID'] = $resultofexcute['data']['DETAILAUTH']['VENDOR_ID'];
			} else{
				$setsesion['USER_ID'] = $resultofexcute['data']['DETAILAUTH']['USER_ID'];
				$setsesion['DETAIL_ID'] = $resultofexcute['data']['DETAILAUTH']['USER_ID'];
			}
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
		$query = "SELECT * FROM PWMS_TX_SYSTEM_AUTH WHERE USERNAME=".strtolower($username)." AND PASSWORD=".$password;
		$runQuery = $this->db->query($query);
		if ($runQuery->num_rows() > 0) {
			$arrdata = $runQuery->result_array();
			$this->db->set('LAST_LOGIN', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
			$this->db->where('AUTH_ID', $arrdata[0]['AUTH_ID']);
			$this->db->update('PWMS_TX_SYSTEM_AUTH');
			$getdetailauth = $this->getdetailauth($arrdata[0]['AUTH_ID'], $arrdata[0]['AUTH_TYPE_ID']);
			$result['response'] = true;
			$result['data'] = $getdetailauth;
			$result['active'] = $arrdata[0]['FLAG_ACTIVE'];
		}
		return $result;
	}

	public function getdetailauth($id, $type){
		$result = array();
		$query = "SELECT * FROM PWMS_TR_AUTH_TYPE WHERE AUTH_TYPE_ID=".$type;
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		
		$result['ROLLID'] = $type;
		$result['ROLLNAME'] = $arrdata[0]['AUTH_TYPE_NAME'];
		$result['TABLE_NAME'] = $arrdata[0]['TABLE_NAME'];
		$query2 = "SELECT * FROM ".$arrdata[0]['TABLE_NAME']." WHERE AUTH_ID=".$id;
		$runQuery2 = $this->db->query($query2);
		$arrdata2 = $runQuery2->result_array();
		$result['DETAILAUTH'] = $arrdata2[0];
		return $result;
	}

	public function getnotif($rollid){
		$addwhere = "";
		if ($rollid == 1){
			$addwhere = " ATOL.STATUS_ID = 101";
		}else if ($rollid == 3) {
			$addwhere = " ATOLD.STATUS_ID = 202 AND ATOLD.VENDOR_ID = ".$this->session->userdata('DETAIL_ID');
		}
		$result = array();
		$result['response'] = false;
		$result['notif'] = 0;
		$sql = "
		SELECT
			COUNT(DISTINCT(ATOL.PKK_ID)) AS CPI
		FROM
			PWMS_TX_ORDER_LIST_DET ATOLD
		JOIN
			PWMS_TX_ORDER_LIST ATOL
			ON ATOL.PKK_ID = ATOLD.PKK_ID
		WHERE".$addwhere;
		$run = $this->db->query($sql);
		$arrdata = $run->result_array();
		if ($arrdata[0]['CPI'] > 0) {
			$result['response'] = true;
			$result['notif'] = $arrdata[0]['CPI'];
		}
		return $result;
	}
}
?>