<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_role extends CI_Model{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function getdata($roll_id, $data){
		$this->datatables->select("
			TAT.AUTH_TYPE_ID AS AUTH_TYPE_ID, 
			UPPER(AUTH_TYPE_NAME) AS AUTH_TYPE_NAME, 
			TABLE_NAME AS TABLE_NAME,
			");
		$this->datatables->from('PWMS_TR_AUTH_TYPE TAT');
		$this->datatables->add_column('CHECKBOX', '<input type="checkbox" class="flat dtable" value="$1">', 'AUTH_TYPE_ID');
		$this->datatables->where('TAT.AUTH_TYPE_ID >', 3);
		return $this->datatables->generate();
		
	}

	public function finddata($auth_type_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'TAT.AUTH_TYPE_ID IN ('.$auth_type_id.')';
		}else{
			$where = 'TAT.AUTH_TYPE_ID = '.$auth_type_id;
		}

		$query = "
			SELECT 
				TAT.AUTH_TYPE_ID AS AUTH_TYPE_ID,
				TAT.AUTH_TYPE_NAME AS AUTH_TYPE_NAME,
				TSM.TITLE_MENU AS TITLE_MENU,
				TAT.TABLE_NAME AS TABLE_NAME
			FROM 
				PWMS_TR_AUTH_TYPE TAT asdsadsa
			LEFT JOIN
				PWMS_TR_AUTH_TYPE_MENU TATM
				ON TATM.AUTH_TYPE_ID = TAT.AUTH_TYPE_ID
			LEFT JOIN
				PWMS_TR_SYSTEM_MENU TSM
				ON TSM.MENU_ID = TATM.MENU_ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function finddatadetail($id){
		$query = "
			SELECT A.MENU_ID, TITLE_MENU, AUTH_TYPE_ID, SORT_NUMBER
			FROM PWMS_TR_SYSTEM_MENU A
			LEFT JOIN PWMS_TR_AUTH_TYPE_MENU B ON A.MENU_ID=B.MENU_ID  
			AND AUTH_TYPE_ID = ".$id;
		$query .= " ORDER BY SORT_NUMBER ASC";
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function findlistmenu(){
		$query = "
			SELECT MENU_ID, TITLE_MENU, SORT_NUMBER
            FROM PWMS_TR_SYSTEM_MENU
            ORDER BY SORT_NUMBER ASC";
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function tools($roll_id, $get, $post){
		$action = $get['action'];
		if ($action == 'store'){
			$result = $this->store($get, $post);
		}else if ($action == 'delete') {
			$result = $this->delete($roll_id, $get['id']);
		}else if($action == 'deactived' or $action == 'actived'){
			$result = $this->activedeactive($roll_id, $get);
		}else if($action == 'reset_password'){
			$result = $this->resetPassword($roll_id, $get);
		}
		return $result;
	}

	private function store($get, $post){
		$auth_type_id = isset($get['id']) ? $get['id'] : null;
		$result = array();
		$result['response'] = true;
		
		if (isset($get['id'])) {
			$id = $get['id'];
			$get_auth_type_id = $this->finddata($auth_type_id,$id);
			if ($get_auth_type_id) {
				$this->db->where('AUTH_TYPE_ID', $auth_type_id);
				$del_auth_type_id = $this->db->delete('PWMS_TR_AUTH_TYPE_MENU');
			}
			$result['type'] = "update";
		}else{
			$this->load->model('m_sequences');
			$auth_type_id = $this->m_sequences->getNextVal("AUTH_TYPE_ID");
			$result['type'] = "add";
		}

		$result['msg'] = "Success, ".$result['type']." role ".$post['auth_type_name'];

		$this->db->set('AUTH_TYPE_ID',  $auth_type_id);
		$this->db->set('AUTH_TYPE_NAME',  $post['auth_type_name']);
		$this->db->set('TABLE_NAME',  'PWMS_TR_WASTE_USER');
		if (isset($get['id'])) { $this->db->where('AUTH_TYPE_ID',  $auth_type_id); $this->db->update('PWMS_TR_AUTH_TYPE'); }
		else{ $this->db->insert('PWMS_TR_AUTH_TYPE'); }
		$arr_post = array();
		if(!empty($_POST['menu_picked'])) {
			foreach($_POST['menu_picked'] as $check) {
	        		$arr_['AUTH_TYPE_ID'] = $auth_type_id;
	        		$arr_['MENU_ID'] = $check;
	        		array_push($arr_post, $arr_);
	    		}
		}
		if (!empty($arr_post)) {
			$this->db->insert_batch('PWMS_TR_AUTH_TYPE_MENU',$arr_post);
		}
		// record history
			// $json = json_encode($this->finddata($roll_id, $VENDOR_ID));
			// $this->recordhistory('PWMS_TR_WASTE_VENDOR', $result['type'], $result['msg'], $VENDOR_ID, $json);
		// record history
		return $result;
	}
	
	private function delete($roll_id, $id){
		$arrid = explode('^', $id);
		$result = array();
		$vendor = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$vendor .= $finddata['NAMA'].', ';
			if ($finddata['AUTH_ID'] != null) {
				$this->db->where('AUTH_ID', $finddata['AUTH_ID']);
				$this->db->delete('PWMS_TX_SYSTEM_AUTH');
			}
			// record history
				$json = json_encode($finddata);
				$this->recordhistory('PWMS_TR_WASTE_VENDOR', 'delete', 'Success delete vendor '.$finddata['NAMA'], $finddata['VENDOR_ID'], $json);
			// record history
			$this->db->where('VENDOR_ID', $idr);
			$this->db->delete('PWMS_TR_WASTE_VENDOR');
		}
		$result['response'] = true;
		$result['type'] = "delete";
		$result['msg'] = "Success, delete vendor ".substr($vendor, 0, -2);
		return $result;
	}

	private function recordhistory($tabname, $acttyp, $descrp, $tablid, $json){
		$this->load->model('m_history');
		$this->m_history->record($tabname, $acttyp, $descrp, $tablid, $json);
	}
}
?>