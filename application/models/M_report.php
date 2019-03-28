<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_report extends CI_Model{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function wastelist(){
		$query = "
			SELECT WASTE_ID, WASTE_NAME
			FROM PWMS_TR_WASTE_LIST WL
			LEFT JOIN PWMS_TR_WASTE_TYPE WT ON WL.TYPE_ID = WT.TYPE_ID
			ORDER BY WL.TYPE_ID, WASTE_NAME ASC
		";

		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function getTotalOrder($roll_id, $self_id){
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
	    if ($roll_id == 3) {
	    	$this->db->where("VENDOR_ID", $self_id);
	    }
	    if ($_POST['kpal'] != null and $_POST['agnt'] != null) {
	    	$where = array(
	    		'NAMA_PERUSAHAAN' => $_POST['agnt'],
	    		'NAMA_KAPAL' => $_POST['kpal']
	    	);
	    	$this->db->where($where);
		} else if ($_POST['kpal'] != null) {
			$this->db->where("NAMA_KAPAL", $_POST['kpal'] );
		} else if ($_POST['agnt'] != null) {
			$this->db->where("NAMA_PERUSAHAAN", $_POST['agnt']);
		}
	    $query = $this->db->get();
	    $arrdata = $query->result_array();
		$num_rows = count($arrdata);
		return $num_rows;
	}

	public function getOrderNew($roll_id, $self_id){
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
	    if ($roll_id == 3) {
	    	$this->db->where("VENDOR_ID", $self_id);
	    }
	    if ($_POST['kpal'] != null and $_POST['agnt'] != null) {
	    	$where = array(
	    		'NAMA_PERUSAHAAN' => $_POST['agnt'],
	    		'NAMA_KAPAL' => $_POST['kpal']
	    	);
	    	$this->db->where($where);
		} else if ($_POST['kpal'] != null) {
			$this->db->where("NAMA_KAPAL", $_POST['kpal'] );
		} else if ($_POST['agnt'] != null) {
			$this->db->where("NAMA_PERUSAHAAN", $_POST['agnt']);
		}
	    $this->db->where('STATUS_ID', 1);
	    $query = $this->db->get();
	    $arrdata = $query->result_array();
		$num_rows = count($arrdata);
		return $num_rows;
	}

	public function getOrderOnProgress($roll_id, $self_id){
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
	    if ($_POST['kpal'] != null and $_POST['agnt'] != null) {
	    	$where = array(
	    		'NAMA_PERUSAHAAN' => $_POST['agnt'],
	    		'NAMA_KAPAL' => $_POST['kpal']
	    	);
	    	$this->db->where($where);
		} else if ($_POST['kpal'] != null) {
			$this->db->where("NAMA_KAPAL", $_POST['kpal'] );
		} else if ($_POST['agnt'] != null) {
			$this->db->where("NAMA_PERUSAHAAN", $_POST['agnt']);
		}
	    $this->db->where('STATUS_ID', 2);
	    if ($roll_id == 3) {
	    	$this->db->where("VENDOR_ID", $self_id);
	    }
	    $query = $this->db->get();
	    $arrdata = $query->result_array();
		$num_rows = count($arrdata);
		return $num_rows;
	}

	public function getOrderDone($roll_id, $self_id){
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
	    if ($_POST['kpal'] != null and $_POST['agnt'] != null) {
	    	$where = array(
	    		'NAMA_PERUSAHAAN' => $_POST['agnt'],
	    		'NAMA_KAPAL' => $_POST['kpal']
	    	);
	    	$this->db->where($where);
		} else if ($_POST['kpal'] != null) {
			$this->db->where("NAMA_KAPAL", $_POST['kpal'] );
		} else if ($_POST['agnt'] != null) {
			$this->db->where("NAMA_PERUSAHAAN", $_POST['agnt']);
		}
	    $this->db->where('STATUS_ID', 3);
	    if ($roll_id == 3) {
	    	$this->db->where("VENDOR_ID", $self_id);
	    }
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
			FROM PWMS_TR_WARTA_KAPAL_IN WK
			LEFT JOIN PWMS_TR_WASTE_ORDER WO ON WK.WARTA_KAPAL_IN_ID = WO.WARTA_KAPAL_IN_ID
			LEFT JOIN PWMS_TR_ORDER_STATUS OS ON WO.STATUS_ID = OS.STATUS_ID
			LEFT JOIN PWMS_TR_WASTE_VENDOR WV ON WO.VENDOR_ID = WV.VENDOR_ID";
		$query .= " 
			WHERE 
				TO_DATE(TO_CHAR(WO.CREATED_DATE, 'DD/MM/YYYY'), 'DD/MM/YYYY') >= TO_DATE('".$start."', 'DD/MM/YYYY')
				AND
				TO_DATE(TO_CHAR(WO.CREATED_DATE, 'DD/MM/YYYY'), 'DD/MM/YYYY') <= TO_DATE('".$end."', 'DD/MM/YYYY')
			";
		if (isset($_GET['kpal']) and is_null($_GET['kpal']) and$_GET['kpal'] != null and $_GET['agnt'] != null) {
			$query .= " AND WK.NAMA_KAPAL = '".$_GET['kpal']."' AND WK.NAMA_PERUSAHAAN = '".$_GET['agnt']."'";
		} else if (isset($_GET['kpal']) and $_GET['kpal'] != null) {
			$query .= " AND WK.NAMA_KAPAL = '".$_GET['kpal']."'";
		} else if (isset($_GET['agnt']) and $_GET['agnt'] != null) {
			$query .= " AND WK.NAMA_PERUSAHAAN = '".$_GET['agnt']."'";
		}
		if ($roll_id == 3) {
			$query .= " AND WO.VENDOR_ID = ".$this->session->userdata('VENDOR_ID');
		}
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function qty($oid, $wid){
		$query = "
			SELECT 
				SUM(REQUEST_QTY) AS REQUEST,
				SUM(TONGKANG_QTY) AS TONGKANG,
				SUM(TRUCKING_QTY) AS TRUCKING
			FROM PWMS_TX_SHIP_WASTE_IN
			WHERE WARTA_KAPAL_IN_ID = ".$oid." AND WASTE_ID = ".$wid;
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		if ($arrdata) {
			return $arrdata[0];	
		}else{
			return false;
		}
	}

	public function getWasteReport($roll_id, $self_id){
		$start = $_POST['sdate'];
		$end = $_POST['edate'];
		$kpal = $_POST['kpal'];
		$agnt = $_POST['agnt'];

		$query = "
		SELECT 
			* 
		FROM (
			SELECT
				SW.WASTE_ID AS WASTE_ID,
				WT.TYPE_NAME AS TYPE_NAME,
				WL.WASTE_NAME AS WASTE_NAME,
				WT.TYPE_ID AS TYPE_ID,
				WU.UM_NAME AS UM_NAME,
				SUM(REQUEST_QTY) AS REQUEST_QTY,
				SUM(TONGKANG_QTY) AS TONGKANG_QTY,
				SUM(TRUCKING_QTY) AS TRUCKING_QTY,
				WK.NAMA_PERUSAHAAN AS NAMA_PERUSAHAAN,
				WK.NAMA_KAPAL AS NAMA_KAPAL
			FROM 
				PWMS_TX_SHIP_WASTE_IN SW
			LEFT JOIN 
				PWMS_TR_WASTE_LIST WL 
				ON SW.WASTE_ID = WL.WASTE_ID
			LEFT JOIN
				PWMS_TR_WASTE_ORDER WO
				ON SW.WARTA_KAPAL_IN_ID = WO.WARTA_KAPAL_IN_ID
			LEFT JOIN
				PWMS_TR_WARTA_KAPAL_IN WK
				ON SW.WARTA_KAPAL_IN_ID = WK.WARTA_KAPAL_IN_ID
			LEFT JOIN
	    		PWMS_TR_WASTE_TYPE WT
	    		ON WL.TYPE_ID = WT.TYPE_ID
	    	LEFT JOIN
	    		PWMS_TR_WASTE_UM WU
	    		ON WL.UM_ID = WU.UM_ID
			WHERE
				TO_DATE(TO_CHAR(WO.CREATED_DATE, 'DD/MM/YYYY'), 'DD/MM/YYYY') >= TO_DATE('".$start."', 'DD/MM/YYYY')
				AND
				TO_DATE(TO_CHAR(WO.CREATED_DATE, 'DD/MM/YYYY'), 'DD/MM/YYYY') <= TO_DATE('".$end."', 'DD/MM/YYYY')
			";
			if ($this->session->userdata('ROLL_ID') == 3) {
				$query .= "AND WO.VENDOR_ID = ".$this->session->userdata('VENDOR_ID');
			}
			if ($_POST['kpal'] != null and $_POST['agnt'] != null) {
				$query .= " AND WK.NAMA_KAPAL = '".$_POST['kpal']."' AND WK.NAMA_PERUSAHAAN = '".$_POST['agnt']."'";
			} else if ($_POST['kpal'] != null) {
				$query .= " AND WK.NAMA_KAPAL = '".$_POST['kpal']."'";
			} else if ($_POST['agnt'] != null) {
				$query .= " AND WK.NAMA_PERUSAHAAN = '".$_POST['agnt']."'";
			}
			$query .= " GROUP BY SW.WASTE_ID, WT.TYPE_NAME, WL.WASTE_NAME, WT.TYPE_ID, WU.UM_NAME, WK.NAMA_PERUSAHAAN, WK.NAMA_KAPAL ) ORDER BY TYPE_ID, WASTE_ID ASC";
			
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function search_agent($search) {
		$query = "
			SELECT DISTINCT UPPER(NAMA_PERUSAHAAN) as NAMA_PERUSAHAAN
			FROM ORDER_WARTA_KAPAL
			WHERE UPPER(NAMA_PERUSAHAAN) LIKE '%".strtoupper($search)."%' 
			";

		if ($this->session->userdata('ROLL_ID') == 3) {
			$query .= "AND VENDOR_ID = ".$this->session->userdata('VENDOR_ID')." ORDER BY UPPER(NAMA_PERUSAHAAN) ASC";
		} else {
			$query .= "ORDER BY UPPER(NAMA_PERUSAHAAN) ASC";
		}

		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		// var_dump($arrdata);
		$lists = array();
		$key = 0;
		$temp_id = 1;
		foreach ($arrdata as $row) {
			$lists[$key]['id'] = $temp_id;
			$lists[$key]['text'] = $row['NAMA_PERUSAHAAN'];
			$key++;$temp_id++;
		}
		return $lists;
		// var_dump($lists);
		// var_dump($arrdata);
		// exit();
	}

	public function search_kapal($search) {
		$query = "
			SELECT DISTINCT UPPER(NAMA_KAPAL) as NAMA_KAPAL
			FROM ORDER_WARTA_KAPAL
			WHERE UPPER(NAMA_KAPAL) LIKE '%".strtoupper($search)."%' 
			";
		if ($_GET['agent'] != null) {
			$query .= "AND NAMA_PERUSAHAAN = '".$_GET['agent']."' ";
		}
		if ($this->session->userdata('ROLL_ID') == 3) {
			$query .= "AND VENDOR_ID = ".$this->session->userdata('VENDOR_ID')." ORDER BY UPPER(NAMA_KAPAL) ASC";
		} else {
			$query .= "ORDER BY UPPER(NAMA_KAPAL) ASC";
		}

		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		// var_dump($arrdata);
		$lists = array();
		$key = 0;
		$temp_id = 1;
		foreach ($arrdata as $row) {
			$lists[$key]['id'] = $temp_id;
			$lists[$key]['text'] = $row['NAMA_KAPAL'];
			$key++;$temp_id++;
		}
		return $lists;
		// var_dump($lists);
		// var_dump($arrdata);
		// exit();
	}
}
?>