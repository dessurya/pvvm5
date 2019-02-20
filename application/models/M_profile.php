<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profile extends CI_Model{

	public function __construct(){
		parent::__construct();
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
					TO_CHAR(ATWV.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE,
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					AAPWMS_TR_WASTE_VENDOR ATWV
				LEFT JOIN
					AAPWMS_TX_SYSTEM_AUTH ATSA
					ON ATWV.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN 
					AAPWMS_TR_AUTH_TYPE ATAT
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
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					AAPWMS_TR_WASTE_USER ATWU
				LEFT JOIN
					AAPWMS_TX_SYSTEM_AUTH ATSA
					ON ATWU.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN 
					AAPWMS_TR_AUTH_TYPE ATAT
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
					TO_CHAR(ATWV.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE,
					ATSA.USERNAME AS USERNAME,
					ATAT.AUTH_TYPE_NAME AS ROLL,
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					AAPWMS_TR_WASTE_VENDOR ATWV
				LEFT JOIN
					AAPWMS_TX_SYSTEM_AUTH ATSA
					ON ATWV.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN
					AAPWMS_TR_AUTH_TYPE ATAT
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
					TO_CHAR(ATWU.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE,
					ATSA.USERNAME AS USERNAME,
					ATAT.AUTH_TYPE_NAME AS ROLL,
					CASE ATSA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					AAPWMS_TR_WASTE_USER ATWU
				LEFT JOIN
					AAPWMS_TX_SYSTEM_AUTH ATSA
					ON ATWU.AUTH_ID = ATSA.AUTH_ID
				LEFT JOIN
					AAPWMS_TR_AUTH_TYPE ATAT
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
		if (isset($get['id'])) {
			$ID = $get['id'];
			$AUTH_ID = $this->finddata($roll_id,$ID);
			var_dump($AUTH_ID);
			$AUTH_ID = $AUTH_ID[0]['AUTH_ID'];
			// $PASSWORD = $AUTH_ID[0]['PASSWORD'];
		}else{
			$this->load->model('m_sequences');
			$AUTH_ID = $this->m_sequences->getNextVal("APWMS_TX_AUTH_ID_SEQ");
			$VENDOR_ID = $this->m_sequences->getNextVal("APWMS_TX_VENDOR_ID_SEQ");
		}

		$this->db->set('ID',  $AUTH_ID);
		$this->db->set('USERNAME',  $post['username']);
		// $this->db->set('USERNAME',  '_nev'.$AUTH_ID.$VENDOR_ID);
		// $this->db->set('PASSWORD',  md5("123"));
		// $this->db->set('TYPE',  3);
		if (isset($get['id'])) { 
			$this->db->where('ID',  $AUTH_ID); 
			$this->db->update('APWMS_TX_AUTH'); 
		} else {
			$this->db->insert('APWMS_TX_AUTH'); 
		}

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
				$this->db->update('AAPWMS_TR_WASTE_USER'); 
			} else { 
				$this->db->insert('AAPWMS_TR_WASTE_USER'); 
			}
		} else if ($roll_id == 3) {
			$this->db->set('VENDOR_ID',  $ID);
			$this->db->set('NAMA',  $post['name']);
			$this->db->set('PHONE',  $post['phone']);
			$this->db->set('EMAIL',  $post['email']);
			$this->db->set('NPWP',  $post['npwp']);
			if (isset($get['id'])) { 
				$this->db->where('VENDOR_ID',  $ID); 
				$this->db->update('AAPWMS_TR_WASTE_VENDOR'); 
			} else { 
				$this->db->insert('APWMS_TR_WASTE_VENDOR'); 
			}
		}

		$result['response'] = true;
		if (isset($get['id'])) { 
			$result['msg'] = "Success, update profile ".$post['name'];
			$result['type'] = "update";
		}
		else{ 
			$result['msg'] = "Success, add new  ".$post['name'];
			$result['type'] = "add";
		}

		// record history
			// $json = json_encode($this->finddata($roll_id, $ID));
			// $this->recordhistory('APWMS_TX_VENDOR', $result['type'], $result['msg'], $ID, $json);
		// record history
		return $result;
	}

	public function changepass($username, $get, $post){
		// $result['response'] = false;
		$auth_id = $get['auth_id'];
		$oldpass = md5($post['password']);
		$newpass = md5($post['npassword']);
		$is_exist =  $this->checkpass($this->db->escape($username), $this->db->escape($oldpass));

		if (!is_null($is_exist)) {
			$this->db->set('PASSWORD',  $newpass);
			// $this->db->where('AUTH_ID',  $auth_id);
			$this->db->where('USERNAME',  $username);
			$this->db->update('AAPWMS_TX_SYSTEM_AUTH');
			$rtitle = "Success";
			$result_msg = "Success, update password ".$username;
			$rtype = "success";
		} else {
			$rtitle = "Error";
			$result_msg = "Failed, the password you entered is incorrect. ";
			$rtype = "error";
		}

		$result['response'] = true;
		$result['msg'] = $result_msg;
		$result['type'] = $rtype;
		return $result;
	}

	private function checkpass($username,$oldpass){
		$query_cekpass = "SELECT * FROM AAPWMS_TX_SYSTEM_AUTH WHERE USERNAME=".$username." AND PASSWORD=".$oldpass."";
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
}
?>