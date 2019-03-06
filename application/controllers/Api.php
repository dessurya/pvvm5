<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
	
	public function __construct() {
		parent::__construct();
		$this->load->model('m_api');
		date_default_timezone_set('Asia/Jakarta');
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

	public function sendapi(){
		$send = $this->session->flashdata('send');
		$curl = curl_init();
		$data = array();
		$data[CURLOPT_URL] = "http://10.88.48.102/pwms/index.php/api";
		$data[CURLOPT_RETURNTRANSFER] = true;
		$data[CURLOPT_ENCODING] = "";
		$data[CURLOPT_MAXREDIRS] = 10;
		$data[CURLOPT_TIMEOUT] = 30;
		$data[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
		$data[CURLOPT_CUSTOMREQUEST] = "POST";

		$senddata = array();

		$this->load->model('m_order');
		$heaer = $this->m_order->finddata($this->session->userdata('ROLL_ID'), $send['id'], 'detailapisubmitforsend');
		$heaer = $heaer[0];
		$senddata['nomor_pkk'] = 'PKK.DN.IDBPN.0'.rand(100,999).'.0'.rand(10000,99999);
		$senddata['nama_kapal'] = '-';
		$senddata['nomor_layanan'] = $heaer['LAYANAN_NO'];
		$senddata['kode_pelabuhan'] = $heaer['PELABUHAN_KODE'];
		$senddata['nama_perusahaan'] = $heaer['PERUSAHAAN_NAMA'];

		$senddata['pelabuhan_bongkar_terakhir'] = '-';
		$senddata['tanggal_bongkar_terakhir'] = $heaer['ORDER_DATE'];
		$senddata['nomor_dokumen'] = '-';
		$senddata['sumber_limbah'] = '-';

		$senddata['waste'] = $this->m_order->finddatadetail($this->session->userdata('ROLL_ID'), $send['id'], 'detailapisubmitforsend');
		$senddata['waste'] = strtolower(json_encode($senddata['waste']));
		$senddata['waste'] = json_decode($senddata['waste']);
		
		$data[CURLOPT_POSTFIELDS] = json_encode($senddata);

		curl_setopt_array($curl,$data);
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$send['apires'] = "cURL Error #:" . $err;
		} else {
			$send['apires'] = $response;
		}

		header('Content-Type: application/json');
		echo json_encode( $send );
	}
}