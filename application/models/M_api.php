<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_api extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function insertOrderList($dataInsert, $rawJson){
		
		$dataReturn["message"] = "Success";
		$dataReturn["failed"]  = 0;

		$this->db->select('PKK_NO');
		$this->db->where('PKK_NO',$dataInsert['PKK_ID']);
		$query = $this->db->get('PWMS_TR_WARTA_KAPAL_IN');
		$raw_json = $rawJson;
		if(count($query->result()) < 1 ){
			$this->db->trans_begin();

			$warta_type = "IN";
			
			$stid = oci_parse($this->db->conn_id, 'BEGIN PROD_INSERT_WARTA(
				:PKK_NO_VAR,
			   	:NO_LAYANAN_VAR, 
			   	:KODE_PELABUHAN_VAR, 
			   	:NAMA_PERUSAHAAN_VAR, 
			   	:PELABUHAN_BONGKAR_TERAKHIR_VAR, 
			   	:TANGGAL_BONGKAR_TERAKHIR_VAR, 
			   	:NO_DOKUMEN_VAR, 
			   	:SUMBER_LIMBAH_VAR, 
			   	:WARTA_TYPE,
			   	:JSON_VAR,
			   	:WARTA_KAPAL_ID_RETURN); END;');

			oci_bind_by_name($stid, ':PKK_NO_VAR',  $dataInsert["PKK_ID"],-1);
			oci_bind_by_name($stid, ':NO_LAYANAN_VAR',  $dataInsert["NO_LAYANAN"],-1);
			oci_bind_by_name($stid, ':KODE_PELABUHAN_VAR',  $dataInsert["KODE_PELABUHAN"],-1);
			oci_bind_by_name($stid, ':NAMA_PERUSAHAAN_VAR',  $dataInsert["NAMA_PERUSAHAAN"],-1);
			oci_bind_by_name($stid, ':PELABUHAN_BONGKAR_TERAKHIR_VAR',  $dataInsert["PELABUHAN_BONGKAR_TERAKHIR"],-1);
			oci_bind_by_name($stid, ':TANGGAL_BONGKAR_TERAKHIR_VAR',  $dataInsert["TANGGAL_BONGKAR_TERAKHIR"],-1);
			oci_bind_by_name($stid, ':NO_DOKUMEN_VAR',  $dataInsert["NOMOR_DOKUMEN"],-1);
			oci_bind_by_name($stid, ':SUMBER_LIMBAH_VAR',  $dataInsert["SUMBER_LIMBAH"],-1);
			oci_bind_by_name($stid, ':WARTA_TYPE', $warta_type,-1);
			oci_bind_by_name($stid, ':JSON_VAR', $raw_json,-1);
			oci_bind_by_name($stid, ':WARTA_KAPAL_ID_RETURN',  $OUT_MESSAGE, 1000);
			

			if(oci_execute($stid)){
			  $WARTA_KAPAL_ID_RETURN = $OUT_MESSAGE;
			}
			oci_free_statement($stid);
			
			$dataInsertOrderListDetail = array();
			
			foreach ($dataInsert["orderListDetail"] as $dataWaste) {
				
				$stid = oci_parse($this->db->conn_id, 'BEGIN PROD_CHECK_WASTE(:WASTE_TYPE_NAME_IN,:WASTE_NAME_IN,:WASTE_UM_IN,:WASTE_ID); END;');

				oci_bind_by_name($stid, ':WASTE_TYPE_NAME_IN',  $dataWaste["type"],-1);
				oci_bind_by_name($stid, ':WASTE_NAME_IN',  $dataWaste["name"],-1);
				oci_bind_by_name($stid, ':WASTE_UM_IN',  $dataWaste["unit"],-1);
				oci_bind_by_name($stid, ':WASTE_ID',  $OUT_MESSAGE ,100, SQLT_CHR);

				if(oci_execute($stid)){
				  $WASTE_ID = $OUT_MESSAGE;
				}
				oci_free_statement($stid);
							
				
				$dataInsertOrderListDetail["WARTA_KAPAL_IN_ID"] = $WARTA_KAPAL_ID_RETURN;
				
				$dataInsertOrderListDetail["WASTE_ID"] = $WASTE_ID;
				$dataInsertOrderListDetail["MAX_LOAD_QTY"] = $dataWaste["kapasitas_tangki_penyimpanan"];
				$dataInsertOrderListDetail["KEEP_QTY"] = $dataWaste["jumlah_limbah_disimpan"];
				$dataInsertOrderListDetail["REQUEST_QTY"] = $dataWaste["jumlah_limbah_dibongkar"];
				
				$dataInsertOrderListDetail["TOTAL_QTY"] = $dataWaste["jumlah_limbah_disimpan"] + $dataWaste["jumlah_limbah_dibongkar"];
				
				
				
				$sqlInsert = "INSERT INTO PWMS_TX_SHIP_WASTE_IN (
						WARTA_KAPAL_IN_ID, 
						WASTE_ID, 
						MAX_LOAD_QTY, 
						KEEP_QTY, 
						REQUEST_QTY, 
						TOTAL_QTY,
						CREATED_DATE) 
					VALUES (?, ?, ?, ?, ?, ?,SYSDATE)";

				$this->db->query($sqlInsert, $dataInsertOrderListDetail);
				

			}			

			

			if ($this->db->trans_status() === FALSE)
			{
				$dataReturn["message"] = log_message();
				$dataReturn["failed"]  = 1;

			    $this->db->trans_rollback();
			}
			else
			{
			    $this->db->trans_commit();
			    oci_commit($this->db->conn_id);
			}

			
		}
		else{
			$this->db->trans_begin();

			$warta_type = "OUT";
			
			$stid = oci_parse($this->db->conn_id, 'BEGIN PROD_INSERT_WARTA(
				:PKK_NO_VAR,
			   	:NO_LAYANAN_VAR, 
			   	:KODE_PELABUHAN_VAR, 
			   	:NAMA_PERUSAHAAN_VAR, 
			   	:PELABUHAN_BONGKAR_TERAKHIR_VAR, 
			   	:TANGGAL_BONGKAR_TERAKHIR_VAR, 
			   	:NO_DOKUMEN_VAR, 
			   	:SUMBER_LIMBAH_VAR, 
			   	:WARTA_TYPE,
			   	:JSON_VAR,
			   	:WARTA_KAPAL_ID_RETURN); END;');

			oci_bind_by_name($stid, ':PKK_NO_VAR',  $dataInsert["PKK_ID"],-1);
			oci_bind_by_name($stid, ':NO_LAYANAN_VAR',  $dataInsert["NO_LAYANAN"],-1);
			oci_bind_by_name($stid, ':KODE_PELABUHAN_VAR',  $dataInsert["KODE_PELABUHAN"],-1);
			oci_bind_by_name($stid, ':NAMA_PERUSAHAAN_VAR',  $dataInsert["NAMA_PERUSAHAAN"],-1);
			oci_bind_by_name($stid, ':PELABUHAN_BONGKAR_TERAKHIR_VAR',  $dataInsert["PELABUHAN_BONGKAR_TERAKHIR"],-1);
			oci_bind_by_name($stid, ':TANGGAL_BONGKAR_TERAKHIR_VAR',  $dataInsert["TANGGAL_BONGKAR_TERAKHIR"],-1);
			oci_bind_by_name($stid, ':NO_DOKUMEN_VAR',  $dataInsert["NOMOR_DOKUMEN"],-1);
			oci_bind_by_name($stid, ':SUMBER_LIMBAH_VAR',  $dataInsert["SUMBER_LIMBAH"],-1);
			oci_bind_by_name($stid, ':WARTA_TYPE', $warta_type,-1);
			oci_bind_by_name($stid, ':JSON_VAR', $raw_json,-1);
			oci_bind_by_name($stid, ':WARTA_KAPAL_ID_RETURN',  $OUT_MESSAGE, 1000);
			

			if(oci_execute($stid)){
			  $WARTA_KAPAL_ID_RETURN = $OUT_MESSAGE;
			}
			oci_free_statement($stid);
			
			$dataInsertOrderListDetail = array();
			
			foreach ($dataInsert["orderListDetail"] as $dataWaste) {
				
				$stid = oci_parse($this->db->conn_id, 'BEGIN PROD_CHECK_WASTE(:WASTE_TYPE_NAME_IN,:WASTE_NAME_IN,:WASTE_UM_IN,:WASTE_ID); END;');

				oci_bind_by_name($stid, ':WASTE_TYPE_NAME_IN',  $dataWaste["type"],-1);
				oci_bind_by_name($stid, ':WASTE_NAME_IN',  $dataWaste["name"],-1);
				oci_bind_by_name($stid, ':WASTE_UM_IN',  $dataWaste["unit"],-1);
				oci_bind_by_name($stid, ':WASTE_ID',  $OUT_MESSAGE ,100, SQLT_CHR);

				if(oci_execute($stid)){
				  $WASTE_ID = $OUT_MESSAGE;
				}
				oci_free_statement($stid);
							
				
				$dataInsertOrderListDetail["WARTA_KAPAL_OUT_ID"] = $WARTA_KAPAL_ID_RETURN;
				
				$dataInsertOrderListDetail["WASTE_ID"] = $WASTE_ID;
				$dataInsertOrderListDetail["MAX_LOAD_QTY"] = $dataWaste["kapasitas_tangki_penyimpanan"];
				$dataInsertOrderListDetail["KEEP_QTY"] = $dataWaste["jumlah_limbah_disimpan"];
				$dataInsertOrderListDetail["REQUEST_QTY"] = $dataWaste["jumlah_limbah_dibongkar"];
				
				$dataInsertOrderListDetail["TOTAL_QTY"] = $dataWaste["jumlah_limbah_disimpan"] + $dataWaste["jumlah_limbah_dibongkar"];
				
				
				
				$sqlInsert = "INSERT INTO PWMS_TX_SHIP_WASTE_OUT (
						WARTA_KAPAL_OUT_ID, 
						WASTE_ID, 
						MAX_LOAD_QTY, 
						KEEP_QTY, 
						REQUEST_QTY, 
						TOTAL_QTY,
						CREATED_DATE) 
					VALUES (?, ?, ?, ?, ?, ?,SYSDATE)";

				$this->db->query($sqlInsert, $dataInsertOrderListDetail);
				

			}			

			

			if ($this->db->trans_status() === FALSE)
			{
				$dataReturn["message"] = log_message();
				$dataReturn["failed"]  = 1;

			    $this->db->trans_rollback();
			}
			else
			{
			    $this->db->trans_commit();
			}

		}

		return $dataReturn;	
	}
}