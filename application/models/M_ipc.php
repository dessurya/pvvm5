<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ipc extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id){
		$this->datatables->select("
			ATE.PERSON_ID AS ID, 
			UPPER(NAME) AS NAME, 
			UPPER(NIPP) AS NIPP, 
			UPPER(EMAIL) AS EMAIL, 
			POSISI,
			ATA.LAST_LOGIN AS LAST_LOGIN,
			CASE FLAG_ACTIVE WHEN 'N' THEN 'DEACTIVE' WHEN 'Y' THEN 'ACTIVED' END AS FLAG_ACTIVE
		");
        $this->datatables->from('APWMS_TX_EMPLOYE ATE');
        $this->datatables->join('APWMS_TX_AUTH ATA', 'ATA.ID = ATE.AUTH_ID', 'left');
        $this->datatables->add_column('CHECKBOX', '<input type="checkbox" class="flat dtable" value="$1">', 'ID');
        return $this->datatables->generate();
	}

	public function finddata($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'TE.PERSON_ID IN ('.$id.')';
		}else{
			$where = 'TE.PERSON_ID = '.$id;
		}

		$query = "
			SELECT 
				NIPP, EMAIL, POSISI, NAME, AUTH_ID, TE.PERSON_ID AS EMPLOYE_ID
			FROM 
				APWMS_TX_EMPLOYE TE
			LEFT JOIN
				APWMS_TX_AUTH TA
				ON TA.ID = TE.AUTH_ID
			WHERE ".$where;
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
			// $result = array('response' => false, 'type' => 'actived/deactived', 'msg' => 'not finished function');
		}
		return $result;
	}

	private function store($roll_id, $get, $post){
		$result = array();
		if (isset($get['id'])) {
			$EMPLOYE_ID = $get['id'];
			$AUTH_ID = $this->finddata($roll_id,$EMPLOYE_ID);
			$AUTH_ID = $AUTH_ID[0]['AUTH_ID'];
		}else{
			$this->load->model('m_sequences');
			$AUTH_ID = $this->m_sequences->getNextVal("APWMS_TX_AUTH_ID_SEQ");
			$EMPLOYE_ID = $this->m_sequences->getNextVal("APWMS_TX_EMPLOYE_ID_SEQ");
		}
		$this->db->set('ID',  $AUTH_ID);
		$this->db->set('TYPE',  1);
		$this->db->set('PASSWORD',  md5("123"));
		// $this->db->set('USERNAME',  $post['username']);
		if (isset($get['id'])) { $this->db->where('ID',  $AUTH_ID); $this->db->update('APWMS_TX_AUTH'); }
		else{ $this->db->insert('APWMS_TX_AUTH'); }
		$this->db->set('PERSON_ID',  $EMPLOYE_ID);
		$this->db->set('AUTH_ID',  $AUTH_ID);
		$this->db->set('NAME',  $post['name']);
		$this->db->set('EMAIL',  $post['email']);
		$this->db->set('NIPP',  $post['nipp']);
		$this->db->set('POSISI',  $post['posisi']);
		if (isset($get['id'])) { $this->db->where('PERSON_ID',  $EMPLOYE_ID); $this->db->update('APWMS_TX_EMPLOYE'); }
		else{ $this->db->insert('APWMS_TX_EMPLOYE'); }

		$result['response'] = true;
		if (isset($get['id'])) { 
			$result['msg'] = "Success, update user ".$post['name'];
			$result['type'] = "update";
		}
		else{ 
			$result['msg'] = "Success, add new user ".$post['name'];
			$result['type'] = "add";
		}
		return $result;
	}
	
	private function delete($roll_id, $id){
		$arrid = explode('^', $id);
		$result = array();
		$employe = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$employe .= $finddata['NAME'].', ';
			if ($finddata['AUTH_ID'] != null) {
				$this->db->where('ID', $finddata['AUTH_ID']);
				$this->db->delete('APWMS_TX_AUTH');
			}
			$this->db->where('ID', $idr);
			$this->db->delete('APWMS_TX_EMPLOYE');
		}
		$result['response'] = true;
		$result['type'] = "delete";
		$result['msg'] = "Success, delete employee ".substr($employe, 0, -2);
		return $result;
	}

	private function activedeactive($roll_id, $get){
		$arrid = explode('^', $get['id']);
		$result = array();
		$employe = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$employe .= $finddata['NAME'].', ';
			$this->db->set('FLAG_ACTIVE',  $get['action'] == 'actived' ? 'Y' : 'N');
			$this->db->where('ID', $finddata['AUTH_ID']);
			$this->db->update('APWMS_TX_AUTH');
		}
		$result['response'] = true;
		$result['type'] = $get['action'];
		$result['msg'] = "Success, ".$get['action']." vendor ".substr($employe, 0, -2);
		return $result;
	}
}
?>