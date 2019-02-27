<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
	
	public function __construct() {
		parent::__construct();
		$this->load->model('m_api');
    }

	public function index(){
		$dataPost = $this->input->post('data');
		
		header('Content-type: application/json');
		$rawJson = file_get_contents('php://input');
		$dataPost = json_decode($rawJson);
		
		
		$dataInsert =  array(
						'PKK_ID' => $dataPost->nomor_pkk,
						'NO_LAYANAN' => $dataPost->nomor_layanan,
						'KODE_PELABUHAN' => $dataPost->kode_pelabuhan,
						'NAMA_PERUSAHAAN' => $dataPost->nama_perusahaan,
						'PELABUHAN_BONGKAR_TERAKHIR' => $dataPost->pelabuhan_bongkar_terakhir,
						'TANGGAL_BONGKAR_TERAKHIR' => date('d-M-y',strtotime($dataPost->tanggal_bongkar_terakhir)),
						'NOMOR_DOKUMEN' => $dataPost->nomor_dokumen,
						'SUMBER_LIMBAH' => $dataPost->sumber_limbah
					);
		$orderListDetail = array();
		$counter = 0;

		foreach ($dataPost->waste as $dataWaste) {
			$orderListDetail[$counter]["PKK_ID"] = $dataPost->nomor_pkk;
			$orderListDetail[$counter]["name"] = strtoupper(trim($dataWaste->name));
			$orderListDetail[$counter]["type"] = strtoupper(trim($dataWaste->type));
			$orderListDetail[$counter]["unit"] = strtoupper(trim($dataWaste->unit));
			$orderListDetail[$counter]["kapasitas_tangki_penyimpanan"] = $dataWaste->kapasitas_tangki_penyimpanan;
			$orderListDetail[$counter]["jumlah_limbah_dibongkar"] = $dataWaste->jumlah_limbah_dibongkar;
			$orderListDetail[$counter]["jumlah_limbah_disimpan"] = $dataWaste->jumlah_limbah_disimpan;
			   
			$counter++;
		}

		$dataInsert["orderListDetail"] = $orderListDetail;	

		$return = $this->m_api->insertOrderList($dataInsert, $rawJson);
		
		header('Content-Type: application/json');
		$dataJson["status"] = 200;
		$dataJson["message"] = $return["message"];

		echo json_encode( $dataJson );
		
	}

	
}