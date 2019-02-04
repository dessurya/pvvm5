<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_history extends CI_Model{

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
			ATV.NAME AS ATVNAME,
			ATE.NAME AS ATENAME,
			ATA.USERNAME AS USERNAME,
			ATHL.HISTORY_ID AS ID,
			ATHL.HISTORY_ID AS HISTORY_ID,
			TO_CHAR(ATHL.CREATED_DATE, 'YYYY/MM/DD HH24:MI:SS ') AS CREATED_DATE,
			ATHL.AUTH_ID AS AUTH_ID,
			ATAT.NAME AS ROLL,
			ATHL.ACTION_TYPE AS ACTION_TYPE,
			CASE ATHL.TABLE_NAME WHEN 'APWMS_TX_AUTH' THEN 'USER' WHEN 'APWMS_TX_VENDOR' THEN 'VENDOR' WHEN 'APWMS_TX_ORDER_LIST' THEN 'ORDER' END AS TABLE_NAME
		");
        $this->datatables->from('APWMS_TX_HISTORY_LOG ATHL');
        $this->datatables->join('APWMS_TX_AUTH ATA', 'ATHL.AUTH_ID = ATA.ID', 'left');
        $this->datatables->join('APWMS_TR_AUTH_TYPE ATAT', 'ATA.TYPE = ATAT.ID', 'left');
        $this->datatables->join('APWMS_TX_EMPLOYE ATE', 'ATHL.AUTH_ID = ATE.AUTH_ID', 'left');
        $this->datatables->join('APWMS_TX_VENDOR ATV', 'ATHL.AUTH_ID = ATV.AUTH_ID', 'left');

        if (count($newpost) >= 1) {
        	foreach ($newpost as $list) {
        		$search = $list['val'];
        		if ($list['key'] == 'CREATED_DATE') { $field = 'ATHL.CREATED_DATE'; }
        		else if ($list['key'] == 'USERNAME') { $field = 'ATA.USERNAME'; }
        		else if ($list['key'] == 'ACTION_TYPE') { $field = 'ATHL.ACTION_TYPE'; }
        		else if ($list['key'] == 'ROLL') { $field = 'ATAT.NAME'; }
        		else if ($list['key'] == 'TABLE_NAME') { 
        			$field = 'ATHL.TABLE_NAME';
        			if ($search == 'USER' ) { $search = 'APWMS_TX_AUTH'; }
        			else if ($search == 'VENDOR' ) { $search = 'APWMS_TX_VENDOR'; }
        			else if ($search == 'ORDER' ) { $search = 'APWMS_TX_ORDER_LIST'; }
        		}
        		else if ($list['key'] == 'NAME') {
        			$this->datatables->or_like('UPPER(ATV.NAME)', strtoupper($search));
        			$this->datatables->or_like('UPPER(ATE.NAME)', strtoupper($search));
        		}

        		if ($list['key'] != 'NAME') {
	        		$this->datatables->like('UPPER('.$field.')', strtoupper($search));
        		}
        	}
        }

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
				ATHL.ACTION_TYPE AS ACTION_TYPE,
				ATHL.DESCRIPTION AS DESCRIPTION,
				ATHL.JSON AS JSON,
				CASE ATHL.TABLE_NAME WHEN 'APWMS_TX_AUTH' THEN 'USER' WHEN 'APWMS_TX_VENDOR' THEN 'VENDOR' WHEN 'APWMS_TX_ORDER_LIST' THEN 'ORDER' END AS TABLE_NAME
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
		$this->db->insert('APWMS_TX_HISTORY_LOG');
	}
}
?>