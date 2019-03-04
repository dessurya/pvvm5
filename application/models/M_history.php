<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_history extends CI_Model{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
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
			BATCH_ID,
			TO_CHAR(CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS') AS CREATED_DATE,
			DESCRIPTION,
			STATUS
		");
        $this->datatables->from('PWMS_TX_API_LOG');

        if (count($newpost) >= 1) {
        	foreach ($newpost as $list) {
        		$search = $list['val'];
        		if ($list['key'] == 'CREATED_DATE') { $field = 'CREATED_DATE'; }
        		else if ($list['key'] == 'DESCRIPTION') { $field = 'DESCRIPTION'; }
        		else if ($list['key'] == 'STATUS') { $field = 'STATUS'; }
        		$this->datatables->like('UPPER('.$field.')', strtoupper($search));
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
				ATHL.ACTION_TYPE AS ACTION_TYPE,
				ATHL.DESCRIPTION AS DESCRIPTION,
				ATHL.JSON AS JSON,
				CASE ATHL.TABLE_NAME WHEN 'PWMS_TX_AUTH' THEN 'USER' WHEN 'PWMS_TX_VENDOR' THEN 'VENDOR' WHEN 'PWMS_TX_ORDER_LIST' THEN 'ORDER' END AS TABLE_NAME
			FROM 
				PWMS_TX_HISTORY_LOG ATHL
			LEFT JOIN
				PWMS_TX_AUTH ATA
				ON ATHL.AUTH_ID = ATA.ID
			LEFT JOIN
				PWMS_TR_AUTH_TYPE ATAT
				ON ATA.TYPE = ATAT.ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function record($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_sequences');
		// $history_id = $this->m_sequences->getNextVal("HISTORY_ID");

		// $this->db->set('HISTORY_ID', $history_id);
		$this->db->set('TABLE_NAME', $tabname);
		$this->db->set('TABLE_ID', $tablid);
		$this->db->set('ACTION_TYPE', $acttyp);
		$this->db->set('DESCRIPTION', $descrp);
		$this->db->set('JSON', $json);
		$this->db->set('AUTH_ID', $this->session->userdata('AUTH_ID'));
		$this->db->set('CREATED_BY', $this->session->userdata('AUTH_ID'));
		$this->db->set('CREATED_DATE', "TO_DATE('".date("d/m/Y H:i:s")."','DD/MM/YYYY HH24:MI:SS')", false);
		$this->db->insert('PWMS_TX_HISTORY_LOG');
	}
}
?>