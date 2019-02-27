<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_report extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function wastelist(){
		$query = "
			SELECT WASTE_ID, WASTE_NAME
			FROM AAPWMS_TR_WASTE_LIST WL
			LEFT JOIN AAPWMS_TR_WASTE_TYPE WT ON WL.TYPE_ID = WT.TYPE_ID
			ORDER BY WL.TYPE_ID, WASTE_NAME ASC
		";

	public function getTotalOrder(){
		$this->db->select("*");
		$this->db->from("ORDER_WARTA_KAPAL");

		if($_POST['sdate'] != null and $_POST['edate'] != null) {
			$finddate = 'TO_DATE(TO_CHAR("ORDER_DATE", \'DD/MM/YYYY\'), \'DD/MM/YYYY\')';

	    	$start = "TO_DATE('".$_POST['sdate']."', 'DD/MM/YYYY')";
	    	$end = "TO_DATE('".$_POST['edate']."', 'DD/MM/YYYY')";
		    if ($_POST['sdate'] == $_POST['edate']) {
		    	$this->db->where($finddate." = ", $start, false);
		    }else{
		    	$this->db->where($finddate." >= ", $start, false);
		    	$this->db->where($finddate." <= ", $end, false);
		    }
	    }
	    $query = $this->db->get();
	    $arrdata = $query->result_array();
		$num_rows = count($arrdata);
		return $num_rows;
	}

	public function getOrderNew(){
		$this->db->select("*");
		$this->db->from("ORDER_WARTA_KAPAL");

		if($_POST['sdate'] != null and $_POST['edate'] != null) {
			$finddate = 'TO_DATE(TO_CHAR("ORDER_DATE", \'DD/MM/YYYY\'), \'DD/MM/YYYY\')';

	    	$start = "TO_DATE('".$_POST['sdate']."', 'DD/MM/YYYY')";
	    	$end = "TO_DATE('".$_POST['edate']."', 'DD/MM/YYYY')";
		    if ($_POST['sdate'] == $_POST['edate']) {
		    	$this->db->where($finddate." = ", $start, false);
		    }else{
		    	$this->db->where($finddate." >= ", $start, false);
		    	$this->db->where($finddate." <= ", $end, false);
		    }
	    }
	    $this->db->where('STATUS_ID', 1);
	    $query = $this->db->get();
	    $arrdata = $query->result_array();
		$num_rows = count($arrdata);
		return $num_rows;
	}

	public function getOrderOnProgress(){
		$this->db->select("*");
		$this->db->from("ORDER_WARTA_KAPAL");

		if($_POST['sdate'] != null and $_POST['edate'] != null) {
			$finddate = 'TO_DATE(TO_CHAR("ORDER_DATE", \'DD/MM/YYYY\'), \'DD/MM/YYYY\')';

	    	$start = "TO_DATE('".$_POST['sdate']."', 'DD/MM/YYYY')";
	    	$end = "TO_DATE('".$_POST['edate']."', 'DD/MM/YYYY')";
		    if ($_POST['sdate'] == $_POST['edate']) {
		    	$this->db->where($finddate." = ", $start, false);
		    }else{
		    	$this->db->where($finddate." >= ", $start, false);
		    	$this->db->where($finddate." <= ", $end, false);
		    }
	    }
	    $this->db->where('STATUS_ID', 2);
	    $query = $this->db->get();
	    $arrdata = $query->result_array();
		$num_rows = count($arrdata);
		return $num_rows;
	}

	public function getOrderDone(){
		$this->db->select("*");
		$this->db->from("ORDER_WARTA_KAPAL");

		if($_POST['sdate'] != null and $_POST['edate'] != null) {
			$finddate = 'TO_DATE(TO_CHAR("ORDER_DATE", \'DD/MM/YYYY\'), \'DD/MM/YYYY\')';

	    	$start = "TO_DATE('".$_POST['sdate']."', 'DD/MM/YYYY')";
	    	$end = "TO_DATE('".$_POST['edate']."', 'DD/MM/YYYY')";
		    if ($_POST['sdate'] == $_POST['edate']) {
		    	$this->db->where($finddate." = ", $start, false);
		    }else{
		    	$this->db->where($finddate." >= ", $start, false);
		    	$this->db->where($finddate." <= ", $end, false);
		    }
	    }
	    $this->db->where('STATUS_ID', 3);
	    $query = $this->db->get();
	    $arrdata = $query->result_array();
		$num_rows = count($arrdata);
		return $num_rows;
	}

	public function lists($roll_id, $start, $end){
		$query = "
			SELECT 
				WK.WARTA_KAPAL_IN_ID AS WARTA_KAPAL_IN_ID,
				TO_CHAR(WK.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS WARTA_KAPAL_DATE, 
				TO_CHAR(WO.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS ORDER_DATE, 
				WK.PKK_NO AS PKK_NO,
				WK.NO_LAYANAN AS LAYANAN_NO,
				WK.NAMA_PERUSAHAAN AS PERUSAHAAN_NAMA,
				WK.KODE_PELABUHAN AS PELABUHAN_KODE,
				WO.VENDOR_ID AS VENDOR_ID,
				WV.NAMA AS VENDOR_NAMA,
				CASE WHEN WO.STATUS_ID IS NULL THEN 0 ELSE WO.STATUS_ID END AS STATUS_ID,
				CASE WHEN OS.STATUS IS NULL THEN 'AVAILABLE' ELSE OS.STATUS END AS STATUS_NAMA
			FROM AAPWMS_TR_WARTA_KAPAL_IN WK
			LEFT JOIN AAPWMS_TR_WASTE_ORDER WO ON WK.WARTA_KAPAL_IN_ID = WO.WARTA_KAPAL_IN_ID
			LEFT JOIN AAPWMS_TR_ORDER_STATUS OS ON WO.STATUS_ID = OS.STATUS_ID
			LEFT JOIN AAPWMS_TR_WASTE_VENDOR WV ON WO.VENDOR_ID = WV.VENDOR_ID";
		$query .= " 
			WHERE 
				TO_DATE(TO_CHAR(WK.WARTA_KAPAL_IN_DATE, 'DD/MM/YYYY'), 'DD/MM/YYYY') >= TO_DATE(".$start.", 'DD/MM/YYYY')
				AND
				TO_DATE(TO_CHAR(WK.WARTA_KAPAL_IN_DATE, 'DD/MM/YYYY'), 'DD/MM/YYYY') <= TO_DATE(".$end.", 'DD/MM/YYYY')
			";
		if ($roll_id == 3) {
			$query .= " AND WO.VENDOR_ID = ".$this->session->userdata('VENDOR_ID');
		}
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function qty($oid, $wid){
		$query = "
			SELECT 
				REQUEST_QTY AS REQUEST,
				TONGKANG_QTY AS TONGKANG,
				TRUCKING_QTY AS TRUCKING
			FROM AAPWMS_TX_SHIP_WASTE_IN
			WHERE WARTA_KAPAL_IN_ID = ".$oid." AND WASTE_ID = ".$wid;
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		if ($arrdata) {
			return $arrdata[0];	
		}else{
			return false;
		}
	}

?>