<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profile extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id, $data, $auth_id){
		$this->datatables->select("
			ATHL.HISTORY_ID AS ID,
			ATHL.HISTORY_ID AS HISTORY_ID,
			TO_CHAR(ATHL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS ') AS CREATED_DATE,
			ATHL.AUTH_ID AS AUTH_ID,
			ATA.USERNAME AS USERNAME,
			ATAT.NAME AS ROLL,
			ATHL.TABLE_NAME AS TABLE_NAME,
			ATHL.ACTION_TYPE AS ACTION_TYPE
		");
        $this->datatables->from('APWMS_TX_HISTORY_LOG ATHL');
        $this->datatables->join('APWMS_TX_AUTH ATA', 'ATHL.AUTH_ID = ATA.ID', 'left');
        $this->datatables->join('APWMS_TR_AUTH_TYPE ATAT', 'ATA.TYPE = ATAT.ID', 'left');
        $this->datatables->where_in('ATHL.AUTH_ID', $auth_id);
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
				WHERE VENDOR_ID = ".$venid;
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
			$where = 'ATHL.HISTORY_ID IN ('.$id.')';
		}else{
			$where = 'ATHL.HISTORY_ID = '.$id;
		}

		$query = "
			SELECT 
				ATHL.HISTORY_ID AS ID,
				ATHL.HISTORY_ID AS HISTORY_ID,
				TO_CHAR(ATHL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS ') AS CREATED_DATE,
				ATHL.AUTH_ID AS AUTH_ID,
				ATA.USERNAME AS USERNAME,
				ATAT.ID AS ROLL_ID,
				ATAT.NAME AS ROLL,
				ATHL.TABLE_NAME AS TABLE_NAME,
				ATHL.ACTION_TYPE AS ACTION_TYPE,
				ATHL.DESCRIPTION AS DESCRIPTION,
				ATHL.JSON AS JSON
			FROM 
				APWMS_TX_HISTORY_LOG ATHL
			LEFT JOIN
				APWMS_TX_AUTH ATA
				ON ATHL.AUTH_ID = ATA.ID
			LEFT JOIN
				APWMS_TR_AUTH_TYPE ATAT
				ON ATA.TYPE = ATAT.ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}
}
?>