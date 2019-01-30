<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_vendor extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id, $data){
		if ($data == null) {
			$this->datatables->select("
				ATV.ID AS ID, 
				UPPER(NAME) AS NAME, 
				UPPER(USERNAME) AS USERNAME, 
				UPPER(EMAIL) AS EMAIL, 
				PHONE,
				CASE FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
			");
		    $this->datatables->from('APWMS_TX_VENDOR ATV');
		    $this->datatables->join('APWMS_TX_AUTH ATA', 'ATA.ID = ATV.AUTH_ID', 'left');
		    $this->datatables->add_column('CHECKBOX', '<input type="checkbox" class="flat dtable" value="$1">', 'ID');
		    return $this->datatables->generate();
		}else if($data == 'autoComplate'){
			$query = "
				SELECT 
					LOWER(NAME) AS VENDOR_NAME, 
					TV.ID AS VENDOR_ID
				FROM 
					APWMS_TX_VENDOR TV
				LEFT JOIN
					APWMS_TX_AUTH TA
					ON TA.ID = TV.AUTH_ID
				WHERE TA.FLAG_ACTIVE = 'Y'";
			$runQuery = $this->db->query($query);
			$arrdata = $runQuery->result_array();
			return json_encode($arrdata);
		}
	}

	public function finddata($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'TV.ID IN ('.$id.')';
		}else{
			$where = 'TV.ID = '.$id;
		}

		$query = "
			SELECT 
				NAME, 
				EMAIL, 
				PHONE, 
				USERNAME, 
				AUTH_ID, 
				TV.ID AS VENDOR_ID,
				TO_CHAR(TA.LAST_LOGIN, 'YYYY/MM/DD HH24:MI') AS LAST_LOGIN,
				CASE TA.FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
			FROM 
				APWMS_TX_VENDOR TV
			LEFT JOIN
				APWMS_TX_AUTH TA
				ON TA.ID = TV.AUTH_ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function orderinfo($roll_id, $id){
		$result = array();
		$idin = "
			SELECT
				DISTINCT(ATOL.PKK_ID) AS PKK_ID
			FROM
				APWMS_TX_ORDER_LIST_DET ATOLD
			JOIN
				APWMS_TX_ORDER_LIST ATOL
				ON ATOL.PKK_ID = ATOLD.PKK_ID
			WHERE VENDOR_ID = ".$id;

		$fdone = "
			SELECT
				COUNT(STATUS_ID) AS COUNTVAL
			FROM
				APWMS_TX_ORDER_LIST
			WHERE
				STATUS_ID NOT LIKE 18
				AND PKK_ID IN (".$idin.")";
		$rfdone = $this->db->query($fdone);
		$arfdone = $rfdone->result_array();
		$result['ndone'] = $arfdone[0]['COUNTVAL'];
		$tdone = "
			SELECT
				COUNT(STATUS_ID) AS COUNTVAL
			FROM
				APWMS_TX_ORDER_LIST
			WHERE
				STATUS_ID = 18
				AND PKK_ID IN (".$idin.")";
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
			// $result = array('response' => false, 'type' => 'actived/deactived', 'msg' => 'not finished function');
		}
		return $result;
	}

	private function store($roll_id, $get, $post){
		$result = array();
		if (isset($get['id'])) {
			$VENDOR_ID = $get['id'];
			$AUTH_ID = $this->finddata($roll_id,$VENDOR_ID);
			$AUTH_ID = $AUTH_ID[0]['AUTH_ID'];
		}else{
			$this->load->model('m_sequences');
			$AUTH_ID = $this->m_sequences->getNextVal("APWMS_TX_AUTH_ID_SEQ");
			$VENDOR_ID = $this->m_sequences->getNextVal("APWMS_TX_VENDOR_ID_SEQ");
		}
		$this->db->set('ID',  $AUTH_ID);
		$this->db->set('TYPE',  3);
		$this->db->set('PASSWORD',  md5("123"));
		// $this->db->set('USERNAME',  $post['username']);
		if (isset($get['id'])) { $this->db->where('ID',  $AUTH_ID); $this->db->update('APWMS_TX_AUTH'); }
		else{ $this->db->insert('APWMS_TX_AUTH'); }
		$this->db->set('ID',  $VENDOR_ID);
		$this->db->set('AUTH_ID',  $AUTH_ID);
		$this->db->set('NAME',  $post['name']);
		$this->db->set('EMAIL',  $post['email']);
		$this->db->set('PHONE',  $post['phone']);
		if (isset($get['id'])) { $this->db->where('ID',  $VENDOR_ID); $this->db->update('APWMS_TX_VENDOR'); }
		else{ $this->db->insert('APWMS_TX_VENDOR'); }

		$result['response'] = true;
		$this->load->model('m_history');
		if (isset($get['id'])) { 
			$result['msg'] = "Success, update vendor ".$post['name'];
			$result['type'] = "update";
		}
		else{ 
			$result['msg'] = "Success, add new vendor ".$post['name'];
			$result['type'] = "add";
		}
		$object->
		$this->m_history->record('APWMS_TX_AUTH', $result['type'], $result['msg'], $AUTH_ID);
		$this->m_history->record('APWMS_TX_VENDOR', $result['type'], $result['msg'], $VENDOR_ID);
		return $result;
	}
	
	private function delete($roll_id, $id){
		$arrid = explode('^', $id);
		$result = array();
		$vendor = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$vendor .= $finddata['NAME'].', ';
			if ($finddata['AUTH_ID'] != null) {
				$this->db->where('ID', $finddata['AUTH_ID']);
				$this->db->delete('APWMS_TX_AUTH');
			}
			$this->db->where('ID', $idr);
			$this->db->delete('APWMS_TX_VENDOR');
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
			$vendor .= $finddata['NAME'].', ';
			$this->db->set('FLAG_ACTIVE',  $get['action'] == 'actived' ? 'Y' : 'N');
			$this->db->where('ID', $finddata['AUTH_ID']);
			$this->db->update('APWMS_TX_AUTH');
		}
		$result['response'] = true;
		$result['type'] = $get['action'];
		$result['msg'] = "Success, ".$get['action']." vendor ".substr($vendor, 0, -2);
		return $result;
	}
}
?>