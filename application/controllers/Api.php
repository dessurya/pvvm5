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

	public function testsend($id){
		// $this->load->model('m_order');
		// $test = $this->m_order->

		$curl = curl_init();

		$data = array();
		$data[CURLOPT_URL] = "http://localhost/pvvm5_reb/index.php/api";
		$data[CURLOPT_RETURNTRANSFER] = true;
		$data[CURLOPT_ENCODING] = "";
		$data[CURLOPT_MAXREDIRS] = 10;
		$data[CURLOPT_TIMEOUT] = 30;
		$data[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
		$data[CURLOPT_CUSTOMREQUEST] = "POST";

		// $senddata = {};
		$senddata = '{
				    "nomor_pkk": "PKK.DN.IDBPN.1812.000604",
				    "nama_kapal": "FERY XII",
				    "nomor_layanan": "BDN.IDBPN.1812.000608",
				    "kode_pelabuhan": null,
				    "nama_perusahaan": "PT. PERTAMINA TRANS KONTINENTAL",
				    "pelabuhan_bongkar_terakhir": "-",
				    "tanggal_bongkar_terakhir": "2018-12-14",
				    "nomor_dokumen": "-",
				    "sumber_limbah": "-",
				    "waste": [
				        {
				            "name": "BILGE WATER",
				            "type": "OILY WASTE",
				            "unit": "m3",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        },
				        {
				            "name": "OILY SLUDGE",
				            "type": "OILY WASTE",
				            "unit": "m3",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        },
				        {
				            "name": "SEWAGE",
				            "type": "SEWAGE",
				            "unit": "m3",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        },
				        {
				            "name": "PLASTIC",
				            "type": "GARBAGE",
				            "unit": "kg",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        },
				        {
				            "name": "FLOATING DUNNAGE",
				            "type": "GARBAGE",
				            "unit": "kg",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        },
				        {
				            "name": "PAPER PRODUCTS",
				            "type": "GARBAGE",
				            "unit": "kg",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        },
				        {
				            "name": "INCINERATOR ASH",
				            "type": "GARBAGE",
				            "unit": "kg",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        },
				        {
				            "name": "FOOD WASTE",
				            "type": "GARBAGE",
				            "unit": "kg",
				            "kapasitas_tangki_penyimpanan": 0,
				            "jumlah_limbah_dibongkar": 0,
				            "jumlah_limbah_disimpan": 0
				        }
				    ]
				}';
		$data[CURLOPT_POSTFIELDS] = $senddata;

		curl_setopt_array($curl,$data);
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}

	public function sendpostman(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://localhost/pvvm5_reb/index.php/api",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\n    \"nomor_pkk\": \"PKK.DN.IDBPN.1812.000604\",\n    \"nama_kapal\": \"FERY XII\",\n    \"nomor_layanan\": \"BDN.IDBPN.1812.000608\",\n    \"kode_pelabuhan\": null,\n    \"nama_perusahaan\": \"PT. PERTAMINA TRANS KONTINENTAL\",\n    \"pelabuhan_bongkar_terakhir\": \"-\",\n    \"tanggal_bongkar_terakhir\": \"2018-12-14\",\n    \"nomor_dokumen\": \"-\",\n    \"sumber_limbah\": \"-\",\n    \"waste\": [\n        {\n            \"name\": \"BILGE WATER\",\n            \"type\": \"OILY WASTE\",\n            \"unit\": \"m3\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        },\n        {\n            \"name\": \"OILY SLUDGE\",\n            \"type\": \"OILY WASTE\",\n            \"unit\": \"m3\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        },\n        {\n            \"name\": \"SEWAGE\",\n            \"type\": \"SEWAGE\",\n            \"unit\": \"m3\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        },\n        {\n            \"name\": \"PLASTIC\",\n            \"type\": \"GARBAGE\",\n            \"unit\": \"kg\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        },\n        {\n            \"name\": \"FLOATING DUNNAGE\",\n            \"type\": \"GARBAGE\",\n            \"unit\": \"kg\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        },\n        {\n            \"name\": \"PAPER PRODUCTS\",\n            \"type\": \"GARBAGE\",\n            \"unit\": \"kg\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        },\n        {\n            \"name\": \"INCINERATOR ASH\",\n            \"type\": \"GARBAGE\",\n            \"unit\": \"kg\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        },\n        {\n            \"name\": \"FOOD WASTE\",\n            \"type\": \"GARBAGE\",\n            \"unit\": \"kg\",\n            \"kapasitas_tangki_penyimpanan\": 0,\n            \"jumlah_limbah_dibongkar\": 0,\n            \"jumlah_limbah_disimpan\": 0\n        }\n    ]\n} ",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "Postman-Token: 4c1b50db-85de-4451-add0-0706993a2e9d",
		    "cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
}