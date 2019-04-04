<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_admin extends CI_Model{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function checkAcces($roll_id){
		$url = $this->uri->segment(1);
		if ($roll_id != 2) {
			return $this->notDefaultRole($roll_id, $url);
		}else{
			if ($url == 'api') {
				return true;
			}else{
				return false;
			}
		}
	}

	private function notDefaultRole($roll_id, $url){

		if ($url == 'order') {
			if (in_array($this->uri->segment(2), array('getdata', 'show', 'tools'))) {
				return true;
			}
			$url = "order/index/".$this->uri->segment(3);
		}else if ($url == 'approve') {
			if (in_array($this->uri->segment(2), array('getdata', 'show', 'tools'))) {
				return true;
			}
		}else if($url == 'spk'){
			return true;
		}else if($url == 'history'){
			if (in_array($this->uri->segment(2), array('getdata'))) {
				return true;
			}
			$url = 'history/index/'.$this->uri->segment(3);
		}
		$query = "SELECT MENU_ID FROM PWMS_TR_SYSTEM_MENU WHERE URL_MENU like '".$url."'";
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		$MENU_ID = $arrdata[0]['MENU_ID'];

		$query = "
			SELECT COUNT(*) AS C
			FROM PWMS_TR_AUTH_TYPE_MENU 
			WHERE AUTH_TYPE_ID = ".$roll_id."
			AND MENU_ID = ".$MENU_ID;
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		$check = $arrdata[0]['C'];

		if($check == 0) return false;
		else return true;
	}

	public function getdata($roll_id){
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
			ATWV.USER_ID AS ADMIN_ID, 
			UPPER(NAMA) AS NAMA, 
			USERNAME AS USERNAME, 
			UPPER(EMAIL) AS EMAIL, 
			PHONE,
			NPWP,
			NIPP,
			ATAT.AUTH_TYPE_ID AS AUTH_TYPE_ID,
			UPPER(AUTH_TYPE_NAME) AS AUTH_TYPE_NAME,
			CASE FLAG_ACTIVE WHEN 'N' THEN 'NONACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
		");
	    $this->datatables->from('PWMS_TR_WASTE_USER ATWV');
	    $this->datatables->join('PWMS_TX_SYSTEM_AUTH ATSA', 'ATSA.AUTH_ID = ATWV.AUTH_ID', 'left');
	    $this->datatables->join('PWMS_TR_AUTH_TYPE ATAT', 'ATAT.AUTH_TYPE_ID = ATSA.AUTH_TYPE_ID', 'left');
	    $this->datatables->add_column('CHECKBOX', '<input type="checkbox" class="flat dtable" value="$1">', 'ADMIN_ID');
	    $this->datatables->where("ATSA.AUTH_TYPE_ID <>", 1);
	    $this->datatables->where("ATSA.AUTH_TYPE_ID <>", 2);

	    if (count($newpost) >= 1) {
        	foreach ($newpost as $list) {
        		$search = $list['val'];
        		if ($list['key'] == 'USERNAME') { $field = 'USERNAME'; }
        		else if ($list['key'] == 'NAMA') { $field = 'NAMA'; }
        		else if ($list['key'] == 'EMAIL') { $field = 'EMAIL'; }
        		else if ($list['key'] == 'PHONE') { $field = 'PHONE'; }
        		else if ($list['key'] == 'NIPP') { $field = 'NIPP'; }
        		else if ($list['key'] == 'NPWP') { 
        			$field = 'NPWP'; 
        			$search = str_replace('.','',$search);
					$search = str_replace('-','',$search);
        		}
        		else if ($list['key'] == 'AUTH_TYPE_NAME') { $field = 'AUTH_TYPE_NAME'; }
        		else if ($list['key'] == 'FLAG_ACTIVE') { 
        			$field = 'FLAG_ACTIVE';
        			if ($search == 'ACTIVED' ) { $search = 'Y'; }
        			else if ($search == 'NONACTIVE' ) { $search = 'N'; }
        		}
        		$this->datatables->like('UPPER('.$field.')', strtoupper($search));
        	}
        }
	    return $this->datatables->generate();
	}

	public function finddata($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'TV.USER_ID IN ('.$id.')';
		}else{
			$where = 'TV.USER_ID = '.$id;
		}

		$query = "
			SELECT 
				NAMA, 
				EMAIL, 
				PHONE, 
				NPWP, 
				USERNAME, 
				TV.AUTH_ID, 
				USER_ID,
				ORGANISASI,
				POSISI,
				NIPP,
				AT.AUTH_TYPE_ID AS AUTH_TYPE_ID,
				UPPER(AUTH_TYPE_NAME) AS AUTH_TYPE_NAME,
				TO_CHAR(TA.LAST_LOGIN, 'YYYY/MM/DD HH24:MI') AS LAST_LOGIN,
				CASE TA.FLAG_ACTIVE WHEN 'N' THEN 'NONACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
			FROM 
				PWMS_TR_WASTE_USER TV
			LEFT JOIN
				PWMS_TX_SYSTEM_AUTH TA
				ON TA.AUTH_ID = TV.AUTH_ID
			LEFT JOIN
				PWMS_TR_AUTH_TYPE AT
				ON AT.AUTH_TYPE_ID = TA.AUTH_TYPE_ID
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
			WHERE HL.TABLE_NAME = 'PWMS_TR_WASTE_USER' AND HL.TABLE_ID = ".$id."
			ORDER BY HL.CREATED_DATE DESC";
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function getRole($roll_id){
		$query = "SELECT * FROM PWMS_TR_AUTH_TYPE WHERE AUTH_TYPE_ID NOT IN (1,2,3)";
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
		}else if($action == 'reset_password'){
			$result = $this->resetPassword($roll_id, $get);
		}
		return $result;
	}

	private function store($roll_id, $get, $post){
		$result = array();
		$result['response'] = true;
		$AUTH_ID = null;
		$post['npwp'] = str_replace('.','',$post['npwp']);
		$post['npwp'] = str_replace('-','',$post['npwp']);
		if (isset($get['id'])) { 
			$result['type'] = "update"; 
			$ADMIN_ID = $get['id'];
			$AUTH_ID = $this->finddata($roll_id,$ADMIN_ID);
			$AUTH_ID = $AUTH_ID[0]['AUTH_ID'];
		}
		else{ $result['type'] = "add"; }
		if ($post['npwp'] != null and $post['npwp'] != '' and $post['npwp'] != '000000000000000') {
			if (strlen($post['npwp']) <= 14 or strlen($post['npwp']) >= 16 or is_numeric($post['npwp']) == false) {
				$result['response'] = false;
				$result['msg'] = "Sorry!, Please correct NPWP number";
			}
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
		if ($this->uniqUsername($post['email'], $result['type'], $AUTH_ID) == false) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, ".$result['type']." user ".$post['name']." fail cause email is exist...!";
		}
		if (strlen($post['phone']) <= 5 or strlen($post['phone']) >= 21) {
			$result['response'] = false;
			$result['msg'] = "Sorry!, Please correct phone number";
		}

		if ($result['response'] == false) {
			return $result;
		}

		if ($result['type'] == "add") {
			$this->load->model('m_sequences');
			$AUTH_ID = $this->m_sequences->getNextVal("AUTH_ID");
			$ADMIN_ID = $this->m_sequences->getNextVal("USER_ID");
		}


		$result['msg'] = "Success, ".$result['type']." user ".$post['name'];

		$deftpass = explode("@", $post['email']);
		$deftpass = md5($deftpass[0]);
		$this->db->set('AUTH_ID',  $AUTH_ID);
		$this->db->set('USERNAME',  strtolower($post['email']));
		$this->db->set('PASSWORD',  $deftpass);
		$this->db->set('AUTH_TYPE_ID',  $post['role']);
		if (isset($get['id'])) { $this->db->where('AUTH_ID',  $AUTH_ID); $this->db->update('PWMS_TX_SYSTEM_AUTH'); }
		else{ $this->db->set('FLAG_ACTIVE',  'N'); $this->db->insert('PWMS_TX_SYSTEM_AUTH'); }
		$this->db->set('USER_ID',  $ADMIN_ID);
		$this->db->set('AUTH_ID',  $AUTH_ID);
		$this->db->set('NAMA',  $post['name']);
		$this->db->set('NIPP',  $post['nipp']);
		$this->db->set('EMAIL',  strtolower($post['email']));
		$this->db->set('PHONE',  $post['phone']);
		$this->db->set('ORGANISASI',  $post['organisasi']);
		$this->db->set('POSISI',  $post['posisi']);
		$this->db->set('NPWP',  $post['npwp']);
		if (isset($get['id'])) { $this->db->where('USER_ID',  $ADMIN_ID); $this->db->update('PWMS_TR_WASTE_USER'); }
		else{ $this->db->insert('PWMS_TR_WASTE_USER'); }

		// record history
			$json = json_encode($this->finddata($roll_id, $ADMIN_ID));
			$this->recordhistory('PWMS_TR_WASTE_USER', $result['type'], $result['msg'], $ADMIN_ID, $json);
		// record history

		$result['form_id'] = $AUTH_ID;
		return $result;
	}

	public function uniqUsername($usrnm, $type, $authid){
		$query = "
			SELECT USERNAME FROM PWMS_TX_SYSTEM_AUTH
			WHERE USERNAME = '".strtolower($usrnm)."'";
		if ($type == "update") {
			$query .= " AND AUTH_ID <> ".$authid;
		}
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		if ( count($arrdata) >= 1 ) {
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
				$this->recordhistory('PWMS_TR_WASTE_VENDOR', 'delete', 'Success delete vendor '.$finddata['NAMA'], $finddata['ADMIN_ID'], $json);
			// record history
			$this->db->where('ADMIN_ID', $idr);
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
				$this->recordhistory('PWMS_TR_WASTE_USER', $get['action'], 'Success '.$get['action'].' user '.$finddata['USERNAME'].'/'.$finddata['NAMA'], $idr, $json);
			// record history
		}
		$result['response'] = true;
		$result['type'] = $get['action'];
		$result['msg'] = "Success, ".$get['action']." user ".substr($vendor, 0, -2);
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
				$this->recordhistory('PWMS_TR_WASTE_USER', $get['action'], 'Success '.$get['action'].' user '.$finddata['USERNAME'].'/'.$finddata['NAMA'], $idr, $json);
			// record history
		}
		$result['response'] = true;
		$result['type'] = $get['action'];
		$result['msg'] = "Success, ".$get['action']." user ".substr($vendor, 0, -2);
		return $result;
	}

	private function recordhistory($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_history');
		$this->m_history->record($tabname, $acttyp, $descrp, $tablid, $json);
	}
}
?>