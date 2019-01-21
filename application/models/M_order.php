<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id){
		$this->datatables->select("
			ATOL.PKK_ID AS ID,
			ATOL.PKK_ID AS PKK_ID, 
			ATOL.SHIP_ID AS SHIP_ID, 
			ATOL.STATUS_ID AS STATUS_ID, 
			TO_CHAR(ATOL.CREATED_DATE, 'YYYY/MM/DD') AS CREATED_DATE, 
			UPPER(ATSS.STATUS) AS STATUS, 
			UPPER(ATS.SHIP_TYPE) AS SHIP_TYPE, 
			UPPER(ATA.NAME) AS AGENT_NAME
		");
        $this->datatables->from('APWMS_TX_ORDER_LIST ATOL');
        $this->datatables->join('APWMS_TR_STATUS ATSS', 'ATSS.STATUS_ID = ATOL.STATUS_ID', 'left');
        $this->datatables->join('APWMS_TR_SHIP ATS', 'ATS.SHIP_ID = ATOL.SHIP_ID', 'left');
        $this->datatables->join('APWMS_TX_AGENT ATA', 'ATA.ID = ATS.AGENT_ID', 'left');
		if ($roll_id == 1) {
		}else if($roll_id == 3){
			$query="
				SELECT
					DISTINCT(PKK_ID)
				FROM(
					SELECT
						ATOL.PKK_ID AS PKK_ID,
						ATOLD.PKK_DET_ID
					FROM
						APWMS_TX_ORDER_LIST_DET ATOLD
					JOIN
						APWMS_TX_ORDER_LIST ATOL
						ON ATOL.PKK_ID = ATOLD.PKK_ID
					WHERE VENDOR_ID = ".$this->session->userdata('DETAIL_ID')." )";
			$runQuery = $this->db->query($query);
			$arrdata = $runQuery->result_array();
			function ret($data){
				return $data['PKK_ID'];
			}
			$inid = array_map("ret", $arrdata);
			$this->datatables->where_in('ATOL.PKK_ID', $inid);
		}
        return $this->datatables->generate();
	}

	public function finddata($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'ATOL.PKK_ID IN ('.$id.')';
		}else{
			$where = 'ATOL.PKK_ID = '.$id;
		}

		$query = "
			SELECT 
				ATOL.PKK_ID AS PKK_ID, 
				ATOL.SHIP_ID AS SHIP_ID, 
				ATOL.STATUS_ID AS STATUS_ID, 
				TO_CHAR(ATOL.CREATED_DATE, 'YYYY/MM/DD') AS CREATED_DATE, 
				UPPER(ATSS.STATUS) AS STATUS, 
				UPPER(ATS.SHIP_TYPE) AS SHIP_TYPE, 
				UPPER(ATA.NAME) AS AGENT_NAME
			FROM 
				APWMS_TX_ORDER_LIST ATOL
			LEFT JOIN
				APWMS_TR_STATUS ATSS
				ON ATSS.STATUS_ID = ATOL.STATUS_ID
			LEFT JOIN
				APWMS_TR_SHIP ATS
				ON ATS.SHIP_ID = ATOL.SHIP_ID
			LEFT JOIN
				APWMS_TX_AGENT ATA
				ON ATA.ID = ATS.AGENT_ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function finddatadetail($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'ATOLD.PKK_ID IN ('.$id.')';
		}else{
			$where = 'ATOLD.PKK_ID = '.$id;
		}

		if ($roll_id == 3) {
			$where .= " and ATOLD.VENDOR_ID = ".$this->session->userdata('DETAIL_ID');
		}

		$query = "
			SELECT 
				PKK_ID,
				PKK_DET_ID,
				ATOLD.VENDOR_ID AS VENDOR_ID,
				ATV.NAME AS VENDOR_NAME,
				ATOLD.WASTE_ID AS WASTE_ID,
				ATW.WASTE_NAME AS WASTE_NAME,
				ATW.UM_ID AS UM_ID,
				ATWU.UM_NAME AS UM_NAME,
				MAX_QTY,
				LOAD_QTY,
				REQUEST_QTY,
				ACTUAL_QTY
			FROM 
				APWMS_TX_ORDER_LIST_DET ATOLD
			LEFT JOIN
				APWMS_TR_WASTE ATW
				ON ATOLD.WASTE_ID = ATW.WASTE_ID
			LEFT JOIN
				APWMS_TR_WASTE_UM ATWU
				ON ATW.UM_ID = ATWU.UM_ID
			LEFT JOIN
				APWMS_TX_VENDOR ATV
				ON ATOLD.VENDOR_ID = ATV.ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function history($roll_id, $id){
		$queryadd = " ATHL.TABLE_NAME = 'APWMS_TX_ORDER_LIST' AND ATHL.TABLE_ID = ".$id;
		if ($roll_id == 3) {
			$queryadd .=" AND ( ATHL.AUTH_ID = ".$this->session->userdata('AUTH_ID')." OR ATAT.ID = 1 ) ";
		}
		$queryadd .= " ORDER BY ATHL.CREATED_DATE DESC";
		$query = "
			SELECT 
				TO_CHAR(ATHL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS ') AS CDATE,
				ATHL.ACTION_TYPE AS ACTION_TYPE,
				ATHL.AUTH_ID AS AUTH_ID,
				ATA.USERNAME AS USERNAME,
				ATAT.NAME AS ROLL,
				ATAT.TABLE_NAME AS TAB_USER
			FROM 
				APWMS_TX_HISTORY_LOG ATHL
			LEFT JOIN
				APWMS_TX_AUTH ATA
				ON ATHL.AUTH_ID = ATA.ID
			LEFT JOIN
				APWMS_TR_AUTH_TYPE ATAT
				ON ATA.TYPE = ATAT.ID
			WHERE ".$queryadd;
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
		if (isset($get['id'])) { 
			$result['msg'] = "Success, update vendor ".$post['name'];
			$result['type'] = "update";
		}
		else{ 
			$result['msg'] = "Success, add new vendor ".$post['name'];
			$result['type'] = "add";
		}
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