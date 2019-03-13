<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_vendor extends CI_Model{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function getdata($roll_id, $data){
		if ($data == null) {
			$newpost = array();
			foreach ($_POST['columns'] as $list) {
				if ($list['searchable'] == 'true' and ($list['search']['value'] != "" or $list['search']['value'] != null)) {
					$onpost = array();
					$onpost['key'] = $list['name'];
					$onpost['val'] = $list['search']['value'];
					array_push($newpost, $onpost);
				}
			}

			$this->datatables->select("
				ATWV.VENDOR_ID AS VENDOR_ID, 
				UPPER(NAMA) AS NAMA, 
				USERNAME AS USERNAME, 
				UPPER(EMAIL) AS EMAIL, 
				PHONE,
				NPWP,
				CASE FLAG_ACTIVE WHEN 'N' THEN 'NONACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
			");
		    $this->datatables->from('PWMS_TR_WASTE_VENDOR ATWV');
		    $this->datatables->join('PWMS_TX_SYSTEM_AUTH ATSA', 'ATSA.AUTH_ID = ATWV.AUTH_ID', 'left');
		    $this->datatables->add_column('CHECKBOX', '<input type="checkbox" class="flat dtable" value="$1">', 'VENDOR_ID');

		    if (count($newpost) >= 1) {
	        	foreach ($newpost as $list) {
	        		$search = $list['val'];
	        		if ($list['key'] == 'USERNAME') { $field = 'USERNAME'; }
	        		else if ($list['key'] == 'NAMA') { $field = 'NAMA'; }
	        		else if ($list['key'] == 'EMAIL') { $field = 'EMAIL'; }
	        		else if ($list['key'] == 'PHONE') { $field = 'PHONE'; }
	        		else if ($list['key'] == 'NPWP') { $field = 'NPWP'; }
	        		else if ($list['key'] == 'FLAG_ACTIVE') { 
	        			$field = 'FLAG_ACTIVE';
	        			if ($search == 'ACTIVED' ) { $search = 'Y'; }
	        			else if ($search == 'NONACTIVE' ) { $search = 'N'; }
	        		}
	        		$this->datatables->like('UPPER('.$field.')', strtoupper($search));
	        	}
	        }
		    return $this->datatables->generate();
		}else if($data == 'autoComplate'){
			$query = "
				SELECT 
					LOWER(NAME) AS VENDOR_NAME, 
					TV.ID AS VENDOR_ID
				FROM 
					PWMS_TX_VENDOR TV
				LEFT JOIN
					PWMS_TX_AUTH TA
					ON TA.ID = TV.AUTH_ID
				WHERE TA.FLAG_ACTIVE = 'Y' AND TA.TYPE <> 5";
			$runQuery = $this->db->query($query);
			$arrdata = $runQuery->result_array();
			return json_encode($arrdata);
		}
	}

	public function finddata($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'TV.VENDOR_ID IN ('.$id.')';
		}else{
			$where = 'TV.VENDOR_ID = '.$id;
		}

		$query = "
			SELECT 
				NAMA, 
				EMAIL, 
				PHONE, 
				NPWP, 
				USERNAME, 
				TV.AUTH_ID, 
				VENDOR_ID,
				AUTH_TYPE_ID,
				TO_CHAR(TA.LAST_LOGIN, 'YYYY/MM/DD HH24:MI') AS LAST_LOGIN,
				CASE TA.FLAG_ACTIVE WHEN 'N' THEN 'NONACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
			FROM 
				PWMS_TR_WASTE_VENDOR TV
			LEFT JOIN
				PWMS_TX_SYSTEM_AUTH TA
				ON TA.AUTH_ID = TV.AUTH_ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function findhistory($roll_id, $id){
		$query = "
			SELECT 
				TO_CHAR(HL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS ') AS CREATED_DATE,
				HL.AUTH_ID AS AUTH_ID, 
				ACTION_TYPE,
				WU.NAMA||WV.NAMA||' - '||AUTH_TYPE_NAME AS NAMA,
				TABLE_ID
			FROM PWMS_TX_HISTORY_LOG HL
			LEFT JOIN PWMS_TX_SYSTEM_AUTH TA ON HL.AUTH_ID = TA.AUTH_ID
			LEFT JOIN PWMS_TR_WASTE_USER WU ON HL.AUTH_ID = WU.AUTH_ID
			LEFT JOIN PWMS_TR_WASTE_VENDOR WV ON HL.AUTH_ID = WV.AUTH_ID
			LEFT JOIN PWMS_TR_AUTH_TYPE AT ON TA.AUTH_TYPE_ID = AT.AUTH_TYPE_ID
			WHERE HL.TABLE_NAME = 'PWMS_TR_WASTE_VENDOR' AND HL.TABLE_ID = ".$id."
			ORDER BY HL.CREATED_DATE DESC";
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function orderinfo($roll_id, $id){
		$result = array();
		$fdone = "
			SELECT
				COUNT(STATUS_ID) AS COUNTVAL
			FROM
				PWMS_TR_WASTE_ORDER
			WHERE
				STATUS_ID NOT LIKE 3
				AND VENDOR_ID = ".$id;
		$rfdone = $this->db->query($fdone);
		$arfdone = $rfdone->result_array();
		$result['ndone'] = $arfdone[0]['COUNTVAL'];
		$tdone = "
			SELECT
				COUNT(STATUS_ID) AS COUNTVAL
			FROM
				PWMS_TR_WASTE_ORDER
			WHERE
				STATUS_ID = 3
				AND VENDOR_ID = ".$id;
		$rtdone = $this->db->query($tdone);
		$artdone = $rtdone->result_array();
		$result['ydone'] = $artdone[0]['COUNTVAL'];
		return $result;
	}

	public function tools($roll_id, $get, $post){
		$action = $get['action'];
		if ($action == 'store'){
			$result = $this->store($roll_id, $get, $post);
		}else if ($action == 'delete') {
			$result = $this->delete($roll_id, $get['id']);
		}else if($action == 'deactived' or $action == 'actived'){
			$result = $this->activedeactive($roll_id, $get);
		}else if($action == 'reset_password'){
			$result = $this->resetPassword($roll_id, $get);
		}
		return $result;
	}

	private function store($roll_id, $get, $post){
		$result = array();
		$result['response'] = true;
		if (isset($get['id'])) { $result['type'] = "update"; }
		else{ $result['type'] = "add"; }
		if (strlen($post['npwp']) <= 14 or strlen($post['npwp']) >= 16) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, Please correct NPWP number";
		}
		if (strpos($post['email'], '@') === false) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, Please correct email address";
		}else{
			$mail = explode('@', $post['email']);
			$mail = $mail[1];
			if (strpos($mail, '.') === false) {
				$result['response'] = false;
				$result['msg'] = "Sorry!, Please correct email address";
			}
		}
		if ($this->uniqUsername($post['email'], $result['type']) == false) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, ".$result['type']." vendor ".$post['name']." fail cause email is exist...!";
		}
		if (strlen($post['phone']) <= 5 or strlen($post['phone']) >= 21) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, Please correct phone number";
		}
		if ($result['response'] == false) {
			return $result;
		}

		if (isset($get['id'])) {
			$VENDOR_ID = $get['id'];
			$AUTH_ID = $this->finddata($roll_id,$VENDOR_ID);
			$AUTH_ID = $AUTH_ID[0]['AUTH_ID'];
		}else{
			$this->load->model('m_sequences');
			$AUTH_ID = $this->m_sequences->getNextVal("AUTH_ID");
			$VENDOR_ID = $this->m_sequences->getNextVal("VENDOR_ID");
		}

		$result['msg'] = "Success, ".$result['type']." vendor ".$post['name'];


		$deftpass = explode("@", $post['email']);
		$deftpass = md5($deftpass[0]);
		$this->db->set('AUTH_ID',  $AUTH_ID);
		$this->db->set('USERNAME',  $post['email']);
		$this->db->set('PASSWORD',  $deftpass);
		$this->db->set('AUTH_TYPE_ID',  3);
		if (isset($get['id'])) { $this->db->where('AUTH_ID',  $AUTH_ID); $this->db->update('PWMS_TX_SYSTEM_AUTH'); }
		else{ $this->db->set('FLAG_ACTIVE',  'N'); $this->db->insert('PWMS_TX_SYSTEM_AUTH'); }
		$this->db->set('VENDOR_ID',  $VENDOR_ID);
		$this->db->set('AUTH_ID',  $AUTH_ID);
		$this->db->set('NAMA',  $post['name']);
		$this->db->set('EMAIL',  $post['email']);
		$this->db->set('PHONE',  $post['phone']);
		$this->db->set('NPWP',  $post['npwp']);
		if (isset($get['id'])) { $this->db->where('VENDOR_ID',  $VENDOR_ID); $this->db->update('PWMS_TR_WASTE_VENDOR'); }
		else{ $this->db->insert('PWMS_TR_WASTE_VENDOR'); }

		// record history
			$json = json_encode($this->finddata($roll_id, $VENDOR_ID));
			$this->recordhistory('PWMS_TR_WASTE_VENDOR', $result['type'], $result['msg'], $VENDOR_ID, $json);
		// record history
		return $result;
	}

	public function uniqUsername($usrnm, $type){
		$query = "
			SELECT USERNAME FROM PWMS_TX_SYSTEM_AUTH
			WHERE USERNAME = '".$usrnm."'";
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		if (
			(count($arrdata) >= 1 and $type == "add") or 
			(count($arrdata) >= 2 and $type == "update")
		) {
			return false;
		}else{
			return true;
		}
	}
	
	private function delete($roll_id, $id){
		$arrid = explode('^', $id);
		$result = array();
		$vendor = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$vendor .= $finddata['NAMA'].', ';
			if ($finddata['AUTH_ID'] != null) {
				$this->db->where('AUTH_ID', $finddata['AUTH_ID']);
				$this->db->delete('PWMS_TX_SYSTEM_AUTH');
			}
			// record history
				$json = json_encode($finddata);
				$this->recordhistory('PWMS_TR_WASTE_VENDOR', 'delete', 'Success delete vendor '.$finddata['NAMA'], $finddata['VENDOR_ID'], $json);
			// record history
			$this->db->where('VENDOR_ID', $idr);
			$this->db->delete('PWMS_TR_WASTE_VENDOR');
		}
		$result['response'] = true;
		$result['type'] = "delete";
		$result['msg'] = "Success, delete vendor ".substr($vendor, 0, -2);
		return $result;
	}

	private function activedeactive($roll_id, $get){
		$arrid = explode('^', $get['id']);
		$result = array();
		$vendor = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$vendor .= $finddata['NAMA'].', ';
			$this->db->set('FLAG_ACTIVE',  $get['action'] == 'actived' ? 'Y' : 'N');
			$this->db->where('AUTH_ID', $finddata['AUTH_ID']);
			$this->db->update('PWMS_TX_SYSTEM_AUTH');
			// record history
				$json = json_encode($finddata);
				$this->recordhistory('PWMS_TR_WASTE_VENDOR', $get['action'], 'Success '.$get['action'].' vendor '.$finddata['USERNAME'].'/'.$finddata['NAMA'], $idr, $json);
			// record history
		}
		$result['response'] = true;
		$result['type'] = $get['action'];
		$result['msg'] = "Success, ".$get['action']." vendor ".substr($vendor, 0, -2);
		return $result;
	}

	private function resetPassword($roll_id, $get){
		$arrid = explode('^', $get['id']);
		$result = array();
		$vendor = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$vendor .= $finddata['NAMA'].', ';
			$deftpass = explode("@", $finddata['EMAIL']);
			$deftpass = md5($deftpass[0]);
			$this->db->set('PASSWORD',  $deftpass);
			$this->db->where('AUTH_ID', $finddata['AUTH_ID']);
			$this->db->update('PWMS_TX_SYSTEM_AUTH');
			// record history
				$json = json_encode($finddata);
				$this->recordhistory('PWMS_TR_WASTE_VENDOR', $get['action'], 'Success '.$get['action'].' vendor '.$finddata['USERNAME'].'/'.$finddata['NAMA'], $idr, $json);
			// record history
		}
		$result['response'] = true;
		$result['type'] = $get['action'];
		$result['msg'] = "Success, ".$get['action']." vendor ".substr($vendor, 0, -2);
		return $result;
	}

	private function recordhistory($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_history');
		$this->m_history->record($tabname, $acttyp, $descrp, $tablid, $json);
	}
}
?>