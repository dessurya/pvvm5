<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_sequences extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getNextVal($seqname){
		$query = "SELECT ".$seqname.".NEXTVAL FROM DUAL";
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
        return $arrdata[0]['NEXTVAL'];
	}

}
?>