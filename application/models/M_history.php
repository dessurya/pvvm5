<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_history extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id, $data){
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

		if($data != null){
			if ($this->uri->segment(5) == 'vendor') {
				$this->load->model('m_vendor');
				$ven = $this->m_vendor->finddata($roll_id,$data);
				$this->datatables->where_in('ATHL.AUTH_ID', $ven[0]['AUTH_ID']);
			}
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

	public function record($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_sequences');
		$history_id = $this->m_sequences->getNextVal("APWMS_TX_HISTORY_LOG_ID_SEQ");

		$this->db->set('HISTORY_ID', $history_id);
		$this->db->set('TABLE_NAME', $tabname);
		$this->db->set('TABLE_ID', $tablid);
		$this->db->set('ACTION_TYPE', $acttyp);
		$this->db->set('DESCRIPTION', $descrp);
		$this->db->set('JSON', $json);
		$this->db->set('AUTH_ID', $this->session->userdata('AUTH_ID'));
		$this->db->set('CREATED_BY', $this->session->userdata('AUTH_ID'));
		$this->db->set('CREATED_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);

	}
}
?>