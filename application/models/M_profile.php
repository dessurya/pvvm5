<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profile extends CI_Model{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function finddata($roll_id, $id){

		if ($roll_id == 3) {
			if (is_array($id)) {
				$id = implode(',', $id);
				$where = 'ATWV.VENDOR_ID IN ('.$id.')';
			}else{
				$where = 'ATWV.VENDOR_ID = '.$id;
			}
			$query = "
				SELECT 
					ATWV.VENDOR_ID AS ID,
					ATSA.USERNAME AS USERNAME,
					ATWV.AUTH_ID AS AUTH_ID,
					ATWV.NAMA AS NAMA,
					ATAT.AUTH_TYPE_NAME AS ROLL,
					ATWV.PHONE AS PHONE, 
					ATWV.EMAIL AS EMAIL, 
					ATWV.NPWP AS NPWP,
					ATWV.PHOTO AS PHOTO,
					TO_CHAR(ATWV.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE,
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					PWMS_TR_WASTE_VENDOR ATWV
				LEFT JOIN
					PWMS_TX_SYSTEM_AUTH ATSA
					ON ATWV.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN 
					PWMS_TR_AUTH_TYPE ATAT
					ON ATAT.AUTH_TYPE_ID = ATSA.AUTH_TYPE_ID
				WHERE ".$where;
		} else {
			if (is_array($id)) {
				$id = implode(',', $id);
				$where = 'ATWU.USER_ID IN ('.$id.')';
			}else{
				$where = 'ATWU.USER_ID = '.$id;
			}
			$query = "
				SELECT 
					ATWU.USER_ID AS ID,
					ATSA.USERNAME AS USERNAME,
					ATWU.AUTH_ID AS AUTH_ID,
					ATWU.NAMA AS NAME,
					ATAT.AUTH_TYPE_NAME AS ROLL,
					ATWU.NIPP AS NIPP,
					ATWU.EMAIL AS EMAIL,
					ATWU.PHONE AS PHONE,
					ATWU.POSISI AS POSISI,
					ATWU.ORGANISASI AS ORGANISASI,
					ATWU.NPWP AS NPWP,
					ATWU.PHOTO AS PHOTO,
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					PWMS_TR_WASTE_USER ATWU
				LEFT JOIN
					PWMS_TX_SYSTEM_AUTH ATSA
					ON ATWU.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN 
					PWMS_TR_AUTH_TYPE ATAT
					ON ATAT.AUTH_TYPE_ID = ATSA.AUTH_TYPE_ID
				WHERE ".$where;
		}
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function getdetail($roll_id, $auth_id){
		if ($roll_id == 3) {
			$query = "
				SELECT 
					ATWV.VENDOR_ID AS ID,
					ATWV.AUTH_ID AS AUTH_ID,
					ATWV.NAMA AS NAMA,
					ATWV.PHONE AS PHONE,
					ATWV.EMAIL AS EMAIL,
					ATWV.NPWP AS NPWP,
					ATWV.PHOTO AS PHOTO,
					TO_CHAR(ATWV.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE,
					ATSA.USERNAME AS USERNAME,
					ATAT.AUTH_TYPE_NAME AS ROLL,
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					PWMS_TR_WASTE_VENDOR ATWV
				LEFT JOIN
					PWMS_TX_SYSTEM_AUTH ATSA
					ON ATWV.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN
					PWMS_TR_AUTH_TYPE ATAT
					ON ATSA.AUTH_TYPE_ID = ATAT.AUTH_TYPE_ID
				WHERE 
					ATWV.AUTH_ID = ".$auth_id."";
		} else {
			$query = "
				SELECT 
					ATWU.USER_ID AS ID,
					ATWU.AUTH_ID AS AUTH_ID,
					ATWU.NIPP AS NIPP,
					ATWU.NAMA AS NAMA,
					ATWU.POSISI AS POSISI,
					ATWU.ORGANISASI AS ORGANISASI,
					ATWU.PHONE AS PHONE,
					ATWU.EMAIL AS EMAIL,
					ATWU.NPWP AS NPWP,
					ATWU.PHOTO AS PHOTO,
					TO_CHAR(ATWU.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE,
					ATSA.USERNAME AS USERNAME,
					ATAT.AUTH_TYPE_NAME AS ROLL,
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					PWMS_TR_WASTE_USER ATWU
				LEFT JOIN
					PWMS_TX_SYSTEM_AUTH ATSA
					ON ATWU.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN
					PWMS_TR_AUTH_TYPE ATAT
					ON ATSA.AUTH_TYPE_ID = ATAT.AUTH_TYPE_ID
				WHERE 
					ATWU.AUTH_ID = ".$auth_id."";
		}
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function tools($roll_id, $get, $post){
		$action = $get['action'];
		if ($action == 'store'){
			$result = $this->store($roll_id, $get, $post);
		}else if ($action == 'delete') {
			$result = $this->delete($roll_id, $get['id']);
		}else if($action == 'deactived' or $action == 'actived'){
			$result = $this->activedeactive($roll_id, $get);
		}
		return $result;
	}

	private function store($roll_id, $get, $post){
		$result = array();
		$result['response'] = true;
		
		if (strlen($post['npwp']) <= 14 or strlen($post['npwp']) >= 16) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, Please correct NPWP number";
			$result['type'] = "error";
		}
		if (strpos($post['email'], '@') === false) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, Please correct email address";
			$result['type'] = "error";
		} else {
			$mail = explode('@', $post['email']);
			$mail = $mail[1];
			if (strpos($mail, '.') === false) {
				$result['response'] = false;
				$result['msg'] = "Sorry!, Please correct email address";
				$result['type'] = "error";
			}
		}
		if (strlen($post['phone']) <= 5 or strlen($post['phone']) >= 21) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, Please correct phone number";
			$result['type'] = "error";
		}
		if ($result['response'] == false) {
			return $result;
		}

		if (isset($get['id'])) { 
			$ID = $get['id'];
			$AUTH_ID = $this->finddata($roll_id,$ID);
			$AUTH_ID = $AUTH_ID[0]['AUTH_ID'];
		}
		$result['msg'] = "Success, update profile ".$post['name'];
		$result['type'] = "success";

		if ($roll_id == 1) {
			$this->db->set('USER_ID',  $ID);
			$this->db->set('NAMA',  $post['name']);
			$this->db->set('NIPP',  $post['nipp']);
			$this->db->set('POSISI',  $post['posisi']);
			$this->db->set('ORGANISASI',  $post['organisasi']);
			$this->db->set('PHONE',  $post['phone']);
			$this->db->set('EMAIL',  $post['email']);
			$this->db->set('NPWP',  $post['npwp']);
			if (isset($get['id'])) { 
				$this->db->where('USER_ID',  $ID); 
				$this->db->update('PWMS_TR_WASTE_USER'); 
			} else { 
				$this->db->insert('PWMS_TR_WASTE_USER'); 
			}
		} else if ($roll_id == 3) {
			$this->db->set('VENDOR_ID',  $ID);
			$this->db->set('NAMA',  $post['name']);
			$this->db->set('PHONE',  $post['phone']);
			$this->db->set('EMAIL',  $post['email']);
			$this->db->set('NPWP',  $post['npwp']);
			if (isset($get['id'])) { 
				$this->db->where('VENDOR_ID',  $ID); 
				$this->db->update('PWMS_TR_WASTE_VENDOR'); 
			} else { 
				$this->db->insert('PWMS_TR_WASTE_VENDOR'); 
			}
		}

		$setsesion['NAME'] = $post['name'];
		$setsesion['EMAIL'] = $post['email'];
		$this->session->set_userdata($setsesion);

		return $result;
	}

	public function changepass($username, $get, $post){
		$result['response'] = false;
		$auth_id = $get['auth_id'];
		$pass_len = strlen($post['npassword']);
		$oldpass = md5($post['password']);
		$newpass = md5($post['npassword']);
		$is_exist =  $this->checkpass($this->db->escape($username), $this->db->escape($oldpass));

		if ($pass_len >= 8 and $pass_len <= 20 ) {
			if (!is_null($is_exist)) {
				$this->db->set('PASSWORD',  $newpass);
				$this->db->where('USERNAME',  $username);
				$this->db->update('PWMS_TX_SYSTEM_AUTH');
				$result['response'] = true;
				$rtitle = "Success";
				$result_msg = "Success, update password ".$username;
				$rtype = "success";
			} else {
				$result['response'] = false;
				$rtitle = "Error";
				$result_msg = "Failed, the password you entered is incorrect. ";
				$rtype = "error";
			}
		} else {
			$result['response'] = false;
			$rtitle = "Error";
			$result_msg = "Failed, minimum 8 characters and maximum 20 characters. ";
			$rtype = "error";
		} 

		$result['title'] = $rtitle;
		$result['msg'] = $result_msg;
		$result['type'] = $rtype;
		return $result;
	}

	private function checkpass($username,$oldpass){
		$query_cekpass = "SELECT * FROM PWMS_TX_SYSTEM_AUTH WHERE USERNAME=".$username." AND PASSWORD=".$oldpass."";
		$runQuery = $this->db->query($query_cekpass);
		if ($runQuery->num_rows() > 0) {
			$result = $runQuery->result_array();
		} else {
			return NULL;
		}
		return $result;
	}

	private function recordhistory($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_history');
		$this->m_history->record($tabname, $acttyp, $descrp, $tablid, $json);
	}

	public function save_upload($image){
		$table_name = $this->session->userdata('TABLE_NAME');
		$auth_id = $this->session->userdata('AUTH_ID');
		
		$this->db->where('AUTH_ID',  $auth_id);
		$this->db->set('PHOTO',  $image);
	    $upload = $this->db->update($table_name);
	    // var_dump($upload);
	    if ($upload) {
			$rtitle = "Success";
			$result_msg = "Success, upload new photo";
			$rtype = "success";
		} else {
			$rtitle = "Error";
			$result_msg = "Failed...!";
			$rtype = "error";
		}

		$setsesion['PHOTO'] = $image;
		$this->session->set_userdata($setsesion);

		$result['response'] = true;
		$result['title'] = $rtitle;
		$result['msg'] = $result_msg;
		$result['type'] = $rtype;
		return $result;
	}

}
?>