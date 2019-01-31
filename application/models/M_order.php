<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id, $data){
		$newpost = array();
		foreach ($_POST['columns'] as $list) {
			if ($list['searchable'] == 'true' and ($list['search']['value'] != "" or $list['search']['value'] != null)) {
				$onpost = array();
				$onpost['key'] = $list['data'];
				$onpost['val'] = $list['search']['value'];
				array_push($newpost, $onpost);
			}
		}

		$this->datatables->select("
			ATOL.PKK_ID AS ID,
			ATOL.PKK_ID AS PKK_ID, 
			ATOL.NO_LAYANAN AS NO_LAYANAN, 
			ATOL.KODE_PELABUHAN AS KODE_PELABUHAN, 
			ATOL.NAMA_PERUSAHAAN AS AGENT_NAME, 
			ATOL.STATUS_ID AS STATUS_ID, 
			TO_CHAR(ATOL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE, 
			UPPER(ATSS.STATUS) AS STATUS
		");
        $this->datatables->from('APWMS_TX_ORDER_LIST ATOL');
        $this->datatables->join('APWMS_TR_STATUS ATSS', 'ATSS.STATUS_ID = ATOL.STATUS_ID', 'left');
        // $this->datatables->join('APWMS_TX_AGENT ATA', 'ATA.ID = ATS.AGENT_ID', 'left');

        if (count($newpost) >= 1) {
        	foreach ($newpost as $list) {
        		$search = $list['val'];
        		if ($list['key'] == 'CREATED_DATE') { $field = 'ATOL.CREATED_DATE'; }
        		else if ($list['key'] == 'PKK_ID') { $field = 'ATOL.PKK_ID'; }
        		else if ($list['key'] == 'NO_LAYANAN') { $field = 'ATOL.NO_LAYANAN'; }
        		else if ($list['key'] == 'STATUS') { $field = 'ATSS.STATUS'; }
        		else if ($list['key'] == 'KODE_PELABUHAN') { $field = 'ATOL.KODE_PELABUHAN'; }
        		else if ($list['key'] == 'AGENT_NAME') { $field = 'ATOL.NAMA_PERUSAHAAN'; }
        		$this->datatables->like('UPPER('.$field.')', strtoupper($search));
        	}
        }

		if($roll_id == 3 or $data != null){
			if ($data == null and $roll_id == 3) {
				$venid = $this->session->userdata('DETAIL_ID');
			}else{
				$venid = $data;
			}
			$query="
				SELECT
					DISTINCT(ATOL.PKK_ID) AS PKK_ID
				FROM
					APWMS_TX_ORDER_LIST_DET ATOLD
				JOIN
					APWMS_TX_ORDER_LIST ATOL
					ON ATOL.PKK_ID = ATOLD.PKK_ID
				WHERE ATOLD.STATUS_ID <> 201 AND VENDOR_ID = ".$venid;
			$runQuery = $this->db->query($query);
			$arrdata = $runQuery->result_array();
			if ($arrdata) {
				function ret($data){
					return $data['PKK_ID'];
				}
				$inid = array_map("ret", $arrdata);
			}else{
				$inid = array(0);
			}
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
				ATOL.STATUS_ID AS STATUS_ID, 
				ATOL.NO_LAYANAN AS NO_LAYANAN, 
				ATOL.KODE_PELABUHAN AS KODE_PELABUHAN, 
				ATOL.NAMA_PERUSAHAAN AS AGENT_NAME, 
				ATOL.PELABUHAN_BONGKAR_TERAKHIR AS PELABUHAN_BONGKAR_TERAKHIR, 
				TO_CHAR(ATOL.TANGGAL_BONGKAR_TERAKHIR, 'YYYY/MM/DD HH24:MI:SS') AS TANGGAL_BONGKAR_TERAKHIR, 
				ATOL.NOMOR_DOKUMEN AS NOMOR_DOKUMEN, 
				ATOL.SUMBER_LIMBAH AS SUMBER_LIMBAH, 
				TO_CHAR(ATOL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE, 
				UPPER(ATSS.STATUS) AS STATUS
			FROM 
				APWMS_TX_ORDER_LIST ATOL
			LEFT JOIN
				APWMS_TR_STATUS ATSS
				ON ATSS.STATUS_ID = ATOL.STATUS_ID
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
				ATOLD.STATUS_ID AS STATUS_ID,
				ATS.STATUS AS STATUS,
				ATOLD.WASTE_ID AS WASTE_ID,
				ATW.WASTE_NAME AS WASTE_NAME,
				ATW.WASTE_TYPE_ID AS WASTE_TYPE_ID,
				ATWT.WASTE_TYPE_NAME AS WASTE_TYPE_NAME,
				ATW.UM_ID AS UM_ID,
				ATWU.UM_NAME AS UM_NAME,
				MAX_LOAD_QTY,
				KEEP_QTY,
				REQUEST_QTY,
				ACTUAL_REQUEST_QTY,
				TOTAL_QTY
			FROM 
				APWMS_TX_ORDER_LIST_DET ATOLD
			LEFT JOIN
				APWMS_TR_STATUS ATS
				ON ATOLD.STATUS_ID = ATS.STATUS_ID
			LEFT JOIN
				APWMS_TR_WASTE ATW
				ON ATOLD.WASTE_ID = ATW.WASTE_ID
			LEFT JOIN
				APWMS_TR_WASTE_TYPE ATWT
				ON ATW.WASTE_TYPE_ID = ATWT.WASTE_TYPE_ID
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

	public function changestatus($roll_id, $id, $stid, $act){
		if (in_array($stid, array(101, 102, 103))) {
			$table = 'APWMS_TX_ORDER_LIST';
			$wid = 'PKK_ID';
		}else{
			$table = 'APWMS_TX_ORDER_LIST_DET';
			$wid = 'PKK_DET_ID';
		}

		if ($stid == 101 and $act == 'open') {
			$this->db->set('STATUS_ID',  102);
		}else if ($stid == 102 and $act == 'verifyvendor'){
			$this->db->set('STATUS_ID',  103);
		}else if($stid == 201 and $act == 'verifyvendor'){
			$this->db->set('STATUS_ID',  202);
		}
		$this->db->set('MODIFY_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
		$this->db->where($wid,  $id);
		$this->db->update($table);
	}

	public function verifyvendor($roll_id, $data){
		foreach ($data['post'] as $list) {
			$this->db->set('MODIFY_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
			$this->db->set('MODIFY_BY',  $this->session->userdata('AUTH_ID'));
			$this->db->set('VENDOR_ID',  $list['VENDOR_ID']);
			$this->db->where('PKK_DET_ID', $list['PKK_DET_ID']);
			$this->db->update('APWMS_TX_ORDER_LIST_DET');
			$this->changestatus($roll_id, $list['PKK_DET_ID'], $list['STATUS_ID'], 'verifyvendor');
		}
		$this->db->set('MODIFY_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
		$this->db->set('MODIFY_BY',  $this->session->userdata('AUTH_ID'));
		$this->db->where('PKK_ID', $data['get']['pkk_id']);
		$this->db->update('APWMS_TX_ORDER_LIST');
		$this->changestatus($roll_id, $data['get']['pkk_id'], 102, 'verifyvendor');

		// record history
			$object = array();
			$object['head'] = $this->finddata($roll_id, $data['get']['pkk_id']);
			$object['detail'] = $this->finddatadetail($roll_id, $data['get']['pkk_id']);
			$json = json_encode($object);
			$this->recordhistory('APWMS_TX_ORDER_LIST', 'verify vendor', 'Success verify vendor on order PKK : '.$data['get']['pkk_id'], $data['get']['pkk_id'], $json);
		// record history
	}

	public function saveact($roll_id, $data){
		foreach ($data['post'] as $list) {
			if ($list != null or $list != undefined) {
				$this->db->set('MODIFY_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
				$this->db->set('MODIFY_BY',  $this->session->userdata('AUTH_ID'));
				$this->db->set('ACTUAL_REQUEST_QTY',  $list['ACTUAL_REQUEST_QTY']);
				$this->db->where('PKK_DET_ID', $list['PKK_DET_ID']);
				$this->db->update('APWMS_TX_ORDER_LIST_DET');
			}
		}
		// record history
			$object = array();
			$object['head'] = $this->finddata($roll_id, $data['get']['pkk_id']);
			$object['detail'] = $this->finddatadetail($roll_id, $data['get']['pkk_id']);
			$json = json_encode($object);
			$this->recordhistory('APWMS_TX_ORDER_LIST', 'save actual order', 'Success save actual order on order PKK : '.$data['get']['pkk_id'], $data['get']['pkk_id'], $json);
		// record history
	}

	public function submact($roll_id, $data){
		foreach ($data['post'] as $list) {
			if ($list != null or $list != undefined) {
				$this->db->set('MODIFY_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
				$this->db->set('MODIFY_BY',  $this->session->userdata('AUTH_ID'));
				$this->db->set('ACTUAL_REQUEST_QTY',  $list['ACTUAL_REQUEST_QTY']);
				$this->db->where('PKK_DET_ID', $list['PKK_DET_ID']);
				$this->db->update('APWMS_TX_ORDER_LIST_DET');
			}
		}
		// record history
			$object = array();
			$object['head'] = $this->finddata($roll_id, $data['get']['pkk_id']);
			$object['detail'] = $this->finddatadetail($roll_id, $data['get']['pkk_id']);
			$json = json_encode($object);
			$this->recordhistory('APWMS_TX_ORDER_LIST', 'save actual order', 'Success save actual order on order PKK : '.$data['get']['pkk_id'], $data['get']['pkk_id'], $json);
		// record history
	}

	private function recordhistory($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_history');
		$this->m_history->record($tabname, $acttyp, $descrp, $tablid, $json);
	}
}
?>