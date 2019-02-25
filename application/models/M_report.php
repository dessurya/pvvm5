<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_report extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function drWType(){
		$query = "
			SELECT
				A.TYPE_ID AS TYPE_ID,
				A.TYPE_NAME AS TYPE_NAME,
				COUNT(A.TYPE_ID) AS MARGE
			FROM AAPWMS_TR_WASTE_TYPE A
			LEFT JOIN AAPWMS_TR_WASTE_LIST B ON A.TYPE_ID = B.TYPE_ID
			GROUP BY A.TYPE_ID, A.TYPE_NAME";
		$runQuery = $this->db->query($query);
		return $arrdata = $runQuery->result_array();
	}

}
?>