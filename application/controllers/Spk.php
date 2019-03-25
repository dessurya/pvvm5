<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		if(!$this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/login', 'refresh');
		}
		$this->load->model('m_admin');
		if ($this->m_admin->checkAcces($this->session->userdata('ROLL_ID')) == false) {
			redirect(base_url().'index.php/profile', 'refresh');
		}
    }

	public function index($data, $show = null){
		$urlview = '_main/_spk/index.php';
		if ($data == 'list') {
			$tittle = 'SPK';
		}else if ($data == 'pickup') {
			$tittle = 'Pick Up Order';
		}
		$send['tittle'] = $tittle;
		$viewComp = array();
		$viewComp['_tittle_'] = "PWMS | ".$tittle;
		if ($show == 'for') {
			$this->load->model('m_vendor');
			$result = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $this->uri->segment(5));
			if ($result == null and $result[0]['VENDOR_ID'] != $this->uri->segment(5)) {
				redirect(base_url().'index.php/order', 'refresh');
			}
			$viewComp['_tittle_'] .= " : ".strtoupper($result[0]['NAMA']);
			$send['showNama'] = strtoupper($result[0]['NAMA']);
		}
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, $send, true);
		$this->parser->parse('_main/index', $viewComp);
	}

	public function getdata($data){
		$this->load->model('m_spk');
		header('Content-Type: application/json');
		echo $this->m_spk->getdata($this->session->userdata('ROLL_ID'), $data);
	}

	public function show($data = null){
		$response = array();
		$urlview = '_main/_spk/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$roll_id = $this->session->userdata('ROLL_ID');
			$send = array();
			$this->load->model('m_spk');
			$find = $this->m_spk->finddata($roll_id, $data);
			$find = $find[0];
			$send['head'] = $find;
			$send['detail'] = $this->m_spk->finddatadetail($roll_id, $data);
			$send['history'] = $this->m_spk->history($roll_id, $data);
			$send['all_status'] = $this->m_spk->getallstatus();
			$response['response'] = true;
			$response['name'] = 'Order Waste : '.$find['PKK_NO'];
			$response['result'] = $this->load->view($urlview, $send, true);
			$response['reload'] = true;
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function tools($data = null){
		$response = array();
		$response['response'] = true;
		$response['url'] = site_url().'/order/show/'.$_GET['warta_kapal_in_id'];
		$response['msg'] = 'Success...';
		$response['type'] = 'orderrecalldetail';
		$response['reload'] = true;
		$send = array();
		$send['post'] = $_POST;
		$send['get'] = $_GET;
		$this->load->model('m_spk');
		if ($data == 'store') {
			$fbck = $this->m_spk->store($this->session->userdata('ROLL_ID'), $send);
		}else if($data == 'pickupordersubmit') {
			$fbck = $this->m_spk->pickupordersubmit($this->session->userdata('ROLL_ID'), $send);
		}

		if ($fbck == null) {
			header('Content-Type: application/json');
			echo json_encode( $response );
		}else if ($fbck == 'sendapi') {
			$response['id'] = $_GET['warta_kapal_in_id'];
			$this->session->set_flashdata('send',$response);
			redirect(base_url().'index.php/api/sendapi');
		}
	}

	//PDF
	function cetak(){
		$wki_id = $_GET['wki_id'];
		$status = $_GET['type'];

		$roll_id = $this->session->userdata('ROLL_ID');
		$send = array();
		$this->load->model('m_spk');
		$find = $this->m_spk->finddata($roll_id, $wki_id);
		$find = $find[0];
		$send['head'] = $find;
		// $send['detail'] = $this->m_spk->finddatadetail($roll_id, $wki_id);
		// $send['history'] = $this->m_spk->history($roll_id, $wki_id);
		// $send['all_status'] = $this->m_spk->getallstatus();
		// $response['response'] = true;
		// $response['name'] = 'Order Waste : '.$find['PKK_NO'];
		// echo "<pre>";
		// var_dump($send['head']);
		// echo "</pre>";
		// exit();


    	$this->load->library('pdf');
    	$this->load->library('html_pdf');

        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $this->kop($pdf);
        $this->header($pdf,$status);
        $this->isi($pdf);

        $pdf->ln(100);
        $pdf->Output();
    }

    // KOP SURAT
    private function kop($pdf) {
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,8,'PT. PELABUHAN INDONESIA II (PERSERO)');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(250,8,'FM.01/04/04/06',0,10,'C');
        $pdf->ln(-5);
        $pdf->Cell(30,10,'Cabang Pelabuhan Tanjung Priok');
        $pdf->ln(15);
    }

    // Isi
    private function isi($pdf) {
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(60,5,'No. Surat Permohonan      : ',0,5);
        $pdf->Cell(60,5,'No. SPK                   : ',0,5);
        $pdf->Cell(60,5,'Nama Petugas Tugboat      : ',0,5);
        $pdf->Cell(60,5,'Alat yang digunakan       : ',0,5);


        // $pdf->Cell(100,10,'No. Surat Permohonan');
        // $pdf->Cell(190,7,'SURAT PERINTAH KERJA (SPK)',0,1,'C');
        // $pdf->Cell(190,7,'PENGAMBILAN LIMBAH B3',0,1,'C');
    }

    // Judul
    private function header($pdf,$status) {
    	// echo $status;
    	// exit();

        if ($status == 1) {
            $judul_bawah = "PENGAMBILAN LIMBAH B3";
        } else if ($status == 2) {
            $judul_bawah = "PENGELUARAN LIMBAH SLUDGE OIL";
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'SURAT PERINTAH KERJA (SPK)',0,1,'C');
        $pdf->Cell(190,7,$judul_bawah,0,1,'C');
        $pdf->ln(5);


    }

    private function div($pdf) {
        $dash = '--------------------------------------------------------------------------------------------------------------------------------------------------------------';
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,10,$dash);
        
    }

}