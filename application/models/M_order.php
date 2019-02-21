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
				$onpost['key'] = $list['name'];
				$onpost['val'] = $list['search']['value'];
				array_push($newpost, $onpost);
			}
		}

		$this->datatables->select("
			WARTA_KAPAL_IN_ID AS ID,
			PKK_NO,
			NO_LAYANAN,
			KODE_PELABUHAN,
			NAMA_PERUSAHAAN,
			ORDER_ID,
			VENDOR_ID, 
			VENDOR_NAMA,
			STATUS_ID,
			STATUS,
			TO_CHAR(WARTA_KAPAL_IN_DATE, 'YYYY/MM/DD HH24:MI:SS') AS WARTA_KAPAL_IN_DATE, 
			TO_CHAR(ORDER_DATE, 'YYYY/MM/DD HH24:MI:SS') AS ORDER_DATE
		");
        $this->datatables->from('ORDER_WARTA_KAPAL');
	    $this->datatables->add_column('CHECKBOX', '<input type="checkbox" class="flat dtable" value="$1">', 'ID');

	    if ($roll_id == 3 and $data == 'pickup') {
	    	$this->datatables->where('VENDOR_ID', null);
	    	$finddate = 'TO_DATE(TO_CHAR("WARTA_KAPAL_IN_DATE", \'DD/MM/YYYY\'), \'DD/MM/YYYY\')';
	    } else if ($roll_id == 3 and $data == 'list') {
	    	$this->datatables->where('VENDOR_ID', $this->session->userdata('VENDOR_ID'));
	    	$finddate = 'TO_DATE(TO_CHAR("ORDER_DATE", \'DD/MM/YYYY\'), \'DD/MM/YYYY\')';
	    }

	    if($_POST['startDate'] != null and $_POST['endDate'] != null) {
	    	$start = "TO_DATE('".$_POST['startDate']."', 'DD/MM/YYYY')";
	    	$end = "TO_DATE('".$_POST['endDate']."', 'DD/MM/YYYY')";
		    if ($_POST['startDate'] == $_POST['endDate']) {
		    	$this->datatables->where($finddate." = ", $start, false);
		    }else{
		    	$this->datatables->where($finddate." >= ", $start, false);
		    	$this->datatables->where($finddate." <= ", $end, false);
		    }
	    }

        if (count($newpost) >= 1) {
        	foreach ($newpost as $list) {
        		$search = $list['val'];
        		$this->datatables->like('UPPER('.$list['key'].')', strtoupper($search));
        	}
        }
        return $this->datatables->generate();
	}

	public function finddata($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'WK.WARTA_KAPAL_IN_ID IN ('.$id.')';
		}else{
			$where = "WK.WARTA_KAPAL_IN_ID = ".$id;
		}

		$query = "
			SELECT 
				WK.WARTA_KAPAL_IN_ID AS WARTA_KAPAL_IN_ID,
				TO_CHAR(WK.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS WARTA_KAPAL_DATE, 
				WK.BATCH_ID AS BATCH_ID,
				WK.PKK_NO AS PKK_NO,
				WK.NO_LAYANAN AS LAYANAN_NO,
				WK.NAMA_PERUSAHAAN AS PERUSAHAAN_NAMA,
				WK.KODE_PELABUHAN AS PELABUHAN_KODE,
				WK.PELABUHAN_BONGKAR_TERAKHIR AS PELABUHAN_BONGKAR_TERAKHIR,
				TO_CHAR(WK.TANGGAL_BONGKAR_TERAKHIR, 'YYYY/MM/DD HH24:MI:SS') AS TANGGAL_BONGKAR_TERAKHIR, 
				WK.NO_DOKUMEN AS DOKUMEN_NO,
				WK.SUMBER_LIMBAH AS SUMBER_LIMBAH,
				WO.ORDER_ID AS ORDER_ID,
				TO_CHAR(WO.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS ORDER_DATE, 
				TO_CHAR(WO.TONGKANG_PICKUP_DATE, 'YYYY/MM/DD') AS TONGKANG_PICKUP_DATE, 
				TO_CHAR(WO.TRUCKING_PICKUP_DATE, 'YYYY/MM/DD') AS TRUCKING_PICKUP_DATE, 
				WO.VENDOR_ID AS VENDOR_ID,
				WV.NAMA AS VENDOR_NAMA,
				CASE WHEN WO.STATUS_ID IS NULL THEN 0 ELSE WO.STATUS_ID END AS STATUS_ID,
				CASE WHEN OS.STATUS IS NULL THEN 'AVAILABLE' ELSE OS.STATUS END AS STATUS_NAMA
			FROM AAPWMS_TR_WARTA_KAPAL_IN WK
			LEFT JOIN AAPWMS_TR_WASTE_ORDER WO ON WK.WARTA_KAPAL_IN_ID = WO.WARTA_KAPAL_IN_ID
			LEFT JOIN AAPWMS_TR_WASTE_VENDOR WV ON WO.VENDOR_ID = WV.VENDOR_ID
			LEFT JOIN AAPWMS_TR_ORDER_STATUS OS ON WO.STATUS_ID = OS.STATUS_ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function finddatadetail($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'SWI.WARTA_KAPAL_IN_ID IN ('.$id.')';
		}else{
			$where = "SWI.WARTA_KAPAL_IN_ID = '".$id."'";
		}

		$query = "
			SELECT 
				SWI.WARTA_KAPAL_IN_ID AS WARTA_KAPAL_IN_ID,
				SWI.DET_WARTA_IN_ID AS DET_WARTA_IN_ID,
				SWI.MAX_LOAD_QTY AS MAX_LOAD_QTY,
				SWI.KEEP_QTY AS KEEP_QTY,
				SWI.REQUEST_QTY AS REQUEST_QTY,
				SWI.TOTAL_QTY AS TOTAL_QTY,
				SWI.TONGKANG_QTY AS TONGKANG_QTY,
				SWI.TRUCKING_QTY AS TRUCKING_QTY,
				SWI.WASTE_ID AS WASTE_ID,
				WL.WASTE_NAME AS WASTE_NAME,
				WL.TYPE_ID AS TYPE_ID,
				WT.TYPE_NAME AS TYPE_NAME,
				WL.UM_ID AS UM_ID,
				WU.UM_NAME AS UM_NAME
			FROM AAPWMS_TX_SHIP_WASTE_IN SWI
			LEFT JOIN AAPWMS_TR_WASTE_LIST WL ON SWI.WASTE_ID = WL.WASTE_ID
			LEFT JOIN AAPWMS_TR_WASTE_TYPE WT ON WL.TYPE_ID = WT.TYPE_ID
			LEFT JOIN AAPWMS_TR_WASTE_UM WU ON WL.UM_ID = WU.UM_ID
			WHERE ".$where." ORDER BY WL.TYPE_ID ASC";
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function history($roll_id, $id){
		$queryadd = " HL.TABLE_NAME = 'AAPWMS_TR_WARTA_KAPAL_IN' AND HL.TABLE_ID =  ".$id;
		$queryadd .= " ORDER BY HL.CREATED_DATE DESC";
		$query = "
			SELECT 
				TO_CHAR(HL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS ') AS CREATED_DATE,
				HL.AUTH_ID AS AUTH_ID, 
				ACTION_TYPE,
				WU.NAMA||WV.NAMA||' - '||USERNAME||' - '||AUTH_TYPE_NAME AS NAMA,
				TABLE_ID
			FROM AAPWMS_TX_HISTORY_LOG HL
			LEFT JOIN AAPWMS_TX_SYSTEM_AUTH TA ON HL.AUTH_ID = TA.AUTH_ID
			LEFT JOIN AAPWMS_TR_WASTE_USER WU ON HL.AUTH_ID = WU.AUTH_ID
			LEFT JOIN AAPWMS_TR_WASTE_VENDOR WV ON HL.AUTH_ID = WV.AUTH_ID
			LEFT JOIN AAPWMS_TR_AUTH_TYPE AT ON TA.AUTH_TYPE_ID = AT.AUTH_TYPE_ID
			WHERE ".$queryadd;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
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

	public function store($roll_id, $data){
		foreach ($data['post'] as $list) {
			if ($list != null or $list != undefined) {
				$this->db->set('TONGKANG_QTY',  $list['TONGKANG_QTY']);
				$this->db->set('TRUCKING_QTY',  $list['TRUCKING_QTY']);
				$this->db->where('DET_WARTA_IN_ID', $list['DET_WARTA_IN_ID']);
				$this->db->update('AAPWMS_TX_SHIP_WASTE_IN');
			}
		}
		if ($data['get']['type'] == 'save') {
			$this->db->set('STATUS_ID',  2);
		}else if ($data['get']['type'] == 'submit'){
			$this->db->set('STATUS_ID',  3);
		}
		$this->db->where('WARTA_KAPAL_IN_ID', $data['get']['warta_kapal_in_id']);
		$this->db->update('AAPWMS_TR_WASTE_ORDER');

		// record history
			$object = array();
			$object['head'] = $this->finddata($roll_id, $data['get']['warta_kapal_in_id']);
			$object['detail'] = $this->finddatadetail($roll_id, $data['get']['warta_kapal_in_id']);
			$json = json_encode($object);
			$this->recordhistory('AAPWMS_TR_WARTA_KAPAL_IN', $data['get']['type'].' actual order', 'Success '.$data['get']['type'].' actual order on order PKK : '.$object['head'][0]['PKK_NO'], $data['get']['warta_kapal_in_id'], $json);
		// record history
	}

	public function pickupordersubmit($roll_id, $data){

		$this->db->set('VENDOR_ID',  $this->session->userdata('VENDOR_ID'));
		$this->db->set('STATUS_ID',  1);
		$this->db->set('PKK_NO',  $data['post']['PKK_NO']);
		$this->db->set('WARTA_KAPAL_IN_ID',  $data['get']['warta_kapal_in_id']);
		$this->db->set('CREATED_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
		$this->db->set('TONGKANG_PICKUP_DATE', "TO_DATE('".$data['post']['TONGKANG_PICKUP_DATE']."','DD/MM/YYYY')", false);
		$this->db->set('TRUCKING_PICKUP_DATE', "TO_DATE('".$data['post']['TRUCKING_PICKUP_DATE']."','DD/MM/YYYY')", false);

		$this->db->insert('AAPWMS_TR_WASTE_ORDER');

		// record history
			$object = array();
			$object['head'] = $this->finddata($roll_id, $data['get']['warta_kapal_in_id']);
			$object['detail'] = $this->finddatadetail($roll_id, $data['get']['warta_kapal_in_id']);
			$json = json_encode($object);
			$this->recordhistory('AAPWMS_TR_WARTA_KAPAL_IN', 'pick up order', 'Success to pick up order on PKK : '.$data['post']['PKK_NO'], $data['get']['warta_kapal_in_id'], $json);
		// record history
	}

	private function recordhistory($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_history');
		$this->m_history->record($tabname, $acttyp, $descrp, $tablid, $json);
	}
}
?>