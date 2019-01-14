<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_vendor extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id){
		$this->datatables->select('
			ATV.ID AS ID, 
			UPPER(NAME) AS NAME, 
			UPPER(USERNAME) AS USERNAME, 
			UPPER(EMAIL) AS EMAIL, 
			PHONE
		');
        $this->datatables->from('APWMS_TX_VENDOR ATV');
        $this->datatables->join('APWMS_TX_AUTH ATA', 'ATA.ID = ATV.AUTH_ID', 'left');
        $this->datatables->add_column('CHECKBOX', '<input type="checkbox" class="flat dtable" value="$1">', 'ID');
        return $this->datatables->generate();
	}

	public function finddata($roll_id, $id){
		if (is_array($id)) {
			$id = implode(',', $id);
			$where = 'TV.ID IN ('.$id.')';
		}else{
			$where = 'TV.ID = '.$id;
		}

		$query = "
			SELECT 
				NAME, EMAIL, PHONE, USERNAME, AUTH_ID, TV.ID AS VENDOR_ID
			FROM 
				APWMS_TX_VENDOR TV
			LEFT JOIN
				APWMS_TX_AUTH TA
				ON TA.ID = TV.AUTH_ID
			WHERE ".$where;
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

	public function storeForm($roll_id, $get, $post){
		$result = array();
		if ($get == null) {
			$this->load->model('m_sequences');
			$AUTH_ID = $this->m_sequences->getNextVal("APWMS_TX_AUTH_ID_SEQ");
			$VENDOR_ID = $this->m_sequences->getNextVal("APWMS_TX_VENDOR_ID_SEQ");
		}else{
			$VENDOR_ID = $get['id'];
			$AUTH_ID = $this->finddata($roll_id,$VENDOR_ID);
			$AUTH_ID = $AUTH_ID[0]['AUTH_ID'];
		}
		$this->db->set('ID',  $AUTH_ID);
		$this->db->set('TYPE',  3);
		$this->db->set('PASSWORD',  md5("123"));
		// $this->db->set('USERNAME',  $post['username']);
		if ($get == null) { $this->db->insert('APWMS_TX_AUTH'); }
		else{ $this->db->where('ID',  $AUTH_ID); $this->db->update('APWMS_TX_AUTH'); }
		$this->db->set('ID',  $VENDOR_ID);
		$this->db->set('AUTH_ID',  $AUTH_ID);
		$this->db->set('NAME',  $post['name']);
		$this->db->set('EMAIL',  $post['email']);
		$this->db->set('PHONE',  $post['phone']);
		if ($get == null) { $this->db->insert('APWMS_TX_VENDOR'); }
		else{ $this->db->where('ID',  $VENDOR_ID); $this->db->update('APWMS_TX_VENDOR'); }

		$result['response'] = true;
		if ($get == null) { 
			$result['msg'] = "Success, add new vendor ".$post['name'];
			$result['type'] = "add";
		}
		else{ 
			$result['msg'] = "Success, update vendor ".$post['name'];
			$result['type'] = "update";
		}
		return $result;
	}

	public function delete($roll_id, $id){
		$result = array();
		$arrid = explode('^', $id);
		$vendor = "";
		foreach ($arrid as $idr) {
			$finddata = $this->finddata($roll_id,$idr);
			$finddata = $finddata[0];
			$vendor .= $finddata['NAME'].', ';
			if ($finddata['AUTH_ID'] != null) {
				$this->db->where('ID', $finddata['AUTH_ID']);
				$this->db->delete('APWMS_TX_AUTH');
			}
			$this->db->where('ID', $idr);
			$this->db->delete('APWMS_TX_VENDOR');
		}
		$result['response'] = true;
		$result['type'] = "delete";
		$result['msg'] = "Success, delete vendor ".substr($vendor, 0, -2);
		return $result;
	}
	
}
?>