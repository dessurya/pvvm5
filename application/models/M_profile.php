<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profile extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function finddata($roll_id, $id){

		if ($roll_id == 3) {
			if (is_array($id)) {
				$id = implode(',', $id);
				$where = 'ATHL.HISTORY_ID IN ('.$id.')';
			}else{
				$where = 'ATHL.HISTORY_ID = '.$id;
			}
			$query = "
				SELECT 
					NAME, 
					EMAIL, 
					PHONE, 
					USERNAME, 
					PASSWORD,
					AUTH_ID, 
					TV.ID AS ID,
					TA.TYPE AS TYPE,
					TO_CHAR(TA.LAST_LOGIN, 'YYYY/MM/DD HH24:MI') AS LAST_LOGIN,
					CASE TA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
				FROM 
					AAPWMS_TR_WASTE_VENDOR ATWV
				LEFT JOIN
					AAPWMS_TX_AUTH TA
					ON TA.ID = TV.AUTH_ID
				WHERE 
					AUTH_ID = ".$this->session->userdata('AUTH_ID')."";
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
					ATWU.NAMA AS NAME,
					ATAT.AUTH_TYPE_NAME AS ROLL,
					ATWU.NIPP AS NIPP,
					ATWU.AUTH_ID AS AUTH_ID,
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
			$this->db->set('AUTH_ID',  $AUTH_ID);
			$this->db->set('NIPP',  $post['nipp']);
			$this->db->set('NAMA',  $post['name']);
			$this->db->set('POSISI',  $post['posisi']);
			$this->db->set('ORGANISASI',  $post['organisasi']);
			$this->db->set('PHONE',  $post['phone']);
			$this->db->set('EMAIL',  $post['email']);
			$this->db->set('NPWP',  $post['npwp']);
			if (isset($get['id'])) { 
				$this->db->where('PERSON_ID',  $ID); 
				$this->db->update('APWMS_TX_EMPLOYE'); 
			} else { 
				$this->db->insert('APWMS_TX_EMPLOYE'); 
			}
		} else if ($roll_id == 3) {
			$this->db->set('VENDOR_ID',  $ID);
			$this->db->set('AUTH_ID',  $AUTH_ID);
			$this->db->set('NAMA',  $post['name']);
			$this->db->set('PHONE',  $post['phone']);
			$this->db->set('EMAIL',  $post['email']);
			$this->db->set('NPWP',  $post['npwp']);
			if (isset($get['id'])) { 
				$this->db->where('ID',  $ID); 
				$this->db->update('APWMS_TX_VENDOR'); 
			} else { 
				$this->db->insert('APWMS_TX_VENDOR'); 
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

	private function recordhistory($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_history');
		$this->m_history->record($tabname, $acttyp, $descrp, $tablid, $json);
	}
}
?>