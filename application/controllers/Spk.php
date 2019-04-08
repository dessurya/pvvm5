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
		$detail = $this->m_spk->finddatadetail($roll_id, $wki_id);

    	$this->load->library('pdf');

        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $this->kop($pdf);
        $this->header($pdf,$status,$find);
        $this->isi($pdf,$status,$find,$detail);
        $this->footer($pdf);
        $this->div($pdf);
        $this->kop2($pdf);
        $this->header2($pdf,$status);
        $this->isi2($pdf,$status,$find,$detail);
        $this->footer2($pdf,$status);

        $pdf->Output();
    }

    // KOP SURAT
    private function kop($pdf) {
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(40,8,'PT. PELABUHAN INDONESIA II (PERSERO)');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(250,8,'FM.01/04/04/06',0,10,'C');
        $pdf->ln(-5);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(30,10,'Cabang Pelabuhan Tanjung Priok');
        $pdf->ln(15);
    }
    private function kop2($pdf) {
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(55,8,'PT. PELABUHAN INDONESIA II (PERSERO)',0,0,'C');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(150,8,'Tanggal : '.date("d-m-Y"),0,10,'C');
        $pdf->ln(-5);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(37,10,'Cabang Pelabuhan Tanjung Priok',0,1,'C');
        $pdf->ln(5);
    }


    // Isi
    private function isi($pdf,$status,$find,$detail) {
    	foreach ($detail as $key => $value) {
    		if ($value['WASTE_NAME'] == 'OILY SLUDGE' and $value['UM_NAME'] == 'M3') {
    			// convert m3 to ton
    			$volume = $value['REQUEST_QTY'] * 0.3531466672;
    		} else if ($value['WASTE_NAME'] == 'OILY SLUDGE' and $value['UM_NAME'] == 'KG') {
    			// connvert kg to ton
    			$volume = $value['REQUEST_QTY'] / 1000;
    		}
    	}
    	if ($status == 1) {
    		$tab = '                                                       ';
        	$pdf->setX(25);
    		$pdf->SetMargins(25, 5);
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,10,'Surat Permohonan',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,10,''.$tab.': '.' ',0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,0.5,'SPK',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,0.5,''.$tab.': '.' ',0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,10,'Nama petugas',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,10,''.$tab.': '.' ',0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,0.5,'Perusahaan',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,0.5,''.$tab.': '.$find['PERUSAHAAN_NAMA'],0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,10,'Kapal',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,10,''.$tab.': '.$find['KAPAL_NAMA'],0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,0.5,'Kade',0,0);
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,0.5,''.$tab.': '.'',0,1,'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,10,'Rencana Kerja',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,10,''.$tab.': '.$find['TONGKANG_PICKUP_DATE'],0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,0.5,'Estimasi Volume Pengeluaran Minyak',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,0.5,''.$tab.': '.$volume.' TON',0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,10,'Truk yang Digunakan',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,10,''.$tab.': '.'- ',0,1, 'L');

        } else if ($status == 2) {
        	$tab = '                                ';
        	$pdf->SetMargins(25, 5);

        	$pdf->setFont('Arial','',10);
    		$pdf->Cell(52,10,'No Surat Permohonan',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(-18,10,''.$tab.': '.' ',0,0, 'C');
    		$pdf->setFont('Arial','',10);
        	$pdf->Cell(105,10,'Tgl Surat Permohonan : ',0,0,'R');
        	$pdf->setFont('Arial','',10);
        	$pdf->Cell(6,10,$find['TGL_SPK'],0,1,'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,0.5,'No SPK',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,0.5,''.$tab.': '.' ',0,0, 'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(83,0.5,'Tgl SPK',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,0.5,'                      :   '.$find['TGL_SPK'],0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,10,'Nama petugas Tugboat',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,10,''.$tab.': '.' ',0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,0.5,'Alat yang digunakan',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,0.5,''.$tab.': ',0,1, 'L');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(10,10,'',0,0,'L');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(6,10,''.$tab.': ',0,1, 'L');
        }
        $pdf->ln(5);

    }

    private function isi2($pdf,$status,$find,$detail){
    	foreach ($detail as $key => $value) {
        		if ($value['WASTE_NAME'] == 'OILY SLUDGE' and $value['UM_NAME'] == 'M3') {
    			// convert m3 to ton
        			$v_sludgeoil = $value['REQUEST_QTY'] * 0.3531466672;
        		} else if ($value['WASTE_NAME'] == 'OILY SLUDGE' and $value['UM_NAME'] == 'KG') {
    			// connvert kg to ton
        			$v_sludgeoil = $value['REQUEST_QTY'] / 1000;
        		}
        	}
    	$tab = '                                                       ';
    	if ($status == 1) {
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(37,5,'ID Truk :',0,1,'R');
    		$pdf->setFont('Arial','B',10);
    		$pdf->Cell(42,3,'B9232FYW',0,1,'R');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(46,5,'Pelaksanaan :',0,1,'R');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(38,5,'1. Mulai :',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(38,5,'Hari.....................',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(40,5,'Tgl.....................',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(45,5,'JAM.....................WIB',0,1,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(41,5,'2. Selesai :',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(35,5,'Hari.....................',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(40,5,'Tgl.....................',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(45,5,'JAM.....................WIB',0,1,'R');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(46,5,'Pelaksanaan :',0,1,'R');

    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(45,5,'1. Sludge Oil :',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(35,5,$v_sludgeoil.' TON',0,0,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(60,5,'(......................................................)',0,0,'R');
    		$pdf->ln(15);

        } else if ($status == 2) {
        	
        	$tab = '                                          ';

        	$pdf->setX(25);
        	$pdf->SetMargins(25, 5);
			
			$pdf->setFont('Arial','',9);
    		$pdf->Cell(10,5,'Kapal Keagenan',0,0,'L');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(6,5,''.$tab.': '.$find['PERUSAHAAN_NAMA'],0,1, 'L');

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(10,5,'Kapal',0,0,'L');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(6,5,''.$tab.': '.$find['KAPAL_NAMA'],0,1, 'L');

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(10,5,'Kade',0,0,'L');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(6,5,''.$tab.': '.' ',0,1, 'L');

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(10,5,'Rencana Kerja',0,0,'L');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(6,5,''.$tab.': '.$find['TONGKANG_PICKUP_DATE'],0,1, 'L');

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(10,5,'Estimasi Volume Pengambilan',0,0,'L');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(6,5,''.$tab.': '.$v_sludgeoil.' TON',0,1, 'L');
        	$pdf->setFont('Arial','',9);

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(22,5,'Pelaksanaan :',0,1,'R');

    		$tab = '     ';

        	$pdf->setX(25);
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(20,5,'1. Berangkat',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(31,5,'Hari.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(40,5,'Tgl.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(45,5,'JAM.....................WIB',0,1,'R');

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(13,5,'2. Mulai',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(38,5,'Hari.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(40,5,'Tgl.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(45,5,'JAM.....................WIB',0,1,'R');

    		$pdf->Cell(16,5,'3. Selesai',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(35,5,'Hari.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(40,5,'Tgl.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(45,5,'JAM.....................WIB',0,1,'R');

    		$pdf->Cell(17,5,'4. Kembali',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(34,5,'Hari.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(40,5,'Tgl.....................',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(45,5,'JAM.....................WIB',0,1,'R');

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(22,5,'Pelaksanaan :',0,1,'R');

    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(21,5,'1. Sludge Oil :',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(25,5,'..............TON',0,0,'R');
    		$pdf->setFont('Arial','',9);
    		$pdf->Cell(60,5,'(......................................................)',0,0,'R');
    		$pdf->ln(10);

        }
    }

    // Judul
    private function header($pdf,$status,$find) {
        if ($status == 1) {
            $judul_bawah = "PENGELUARAN LIMBAH SLUDGE OIL";
            $pdf->SetTitle('SPK PENGELUARAN LIMBAH - '.$find['PERUSAHAAN_NAMA'].'_'.date("d-m-Y"));
        } else if ($status == 2) {
            $judul_bawah = "PENGAMBILAN LIMBAH B3";
            $pdf->SetTitle('SPK PENGAMBILAN LIMBAH - '.$find['PERUSAHAAN_NAMA'].'_'.date("d-m-Y"));
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'SURAT PERINTAH KERJA (SPK)',0,1,'C');
        $pdf->Cell(190,3,$judul_bawah,0,1,'C');
        $pdf->ln(5);
    }

    private function header2($pdf,$status) {
        if ($status == 1) {
            $judul_bawah = "(PENGELUARAN)";
        } else if ($status == 2) {
            $judul_bawah = "(PENGAMBILAN)";
        }
        $pdf->SetMargins(5, 5);        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(160,7,'INPUT BUKTI PEMAKAIAN JASA ALAT',0,1,'C');
        $pdf->Cell(200,3,$judul_bawah,0,1,'C');
        $pdf->ln(5);
    }

    // ttd
    private function footer($pdf){
    	$image1 = base_url()."/upload/spk/ttd_wahyusunandar.png";
    	$pdf->setFont('Arial','',11);
    	$pdf->Cell(155,10,'Tanjung Priok, '.date("d-m-Y"),0,1,'R');
    	$pdf->setFont('Arial','B',11);
    	$pdf->Cell(160,0.5,'SUPERVISOR ANEKA USAHA',0,1,'R');
        $pdf->Cell(160, 0.5, $pdf->Image($image1, $pdf->GetX()+123, $pdf->GetY()+3, 15), 0, 1, 'R');
        $pdf->ln(25);
    	$pdf->setFont('Arial','BU',11);
    	$pdf->Cell(150,0.5,'WAHYU SUNANDAR',0,1,'R');
    	$pdf->setFont('Arial','',10);
    	$pdf->Cell(145,10,'NIPP 269035722',0,1,'R');
    }

    // ttd
    private function footer2($pdf,$status){
    	$image1 = base_url()."/upload/spk/ttd_wahyusunandar.png";
    	if ($status == 1) {
    		$pdf->setFont('Arial','',11);
    		$pdf->Cell(175,10,'Tanjung Priok, '.date("d-m-Y"),0,1,'R');
    		$pdf->setFont('Arial','B',11);
    		$pdf->Cell(180,0.5,'SUPERVISOR ANEKA USAHA',0,1,'R');
    		$pdf->Cell(160, 0.5, $pdf->Image($image1, $pdf->GetX()+143, $pdf->GetY()+3, 15), 0, 1, 'R');
    		$pdf->ln(25);
    		$pdf->setFont('Arial','BU',11);
    		$pdf->Cell(170,0.5,'WAHYU SUNANDAR',0,1,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(165,10,'NIPP 269035722',0,1,'R');
    	} else if ($status == 2) {
    		$pdf->setFont('Arial','',11);
    		$pdf->Cell(155,10,'Tanjung Priok, '.date("d-m-Y"),0,1,'R');
    		$pdf->setFont('Arial','B',11);
    		$pdf->Cell(160,0.5,'SUPERVISOR ANEKA USAHA',0,1,'R');
    		$pdf->Cell(160, 0.5, $pdf->Image($image1, $pdf->GetX()+123, $pdf->GetY()+3, 15), 0, 1, 'R');
    		$pdf->ln(25);
    		$pdf->setFont('Arial','BU',11);
    		$pdf->Cell(150,0.5,'WAHYU SUNANDAR',0,1,'R');
    		$pdf->setFont('Arial','',10);
    		$pdf->Cell(145,10,'NIPP 269035722',0,1,'R');
    	}
    }

    private function div($pdf) {

        $dash = '--------------------------------------------------------------------------------------------------------------------------------------------------------------';
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(160,5,$dash,0,1,'C');
        
    }

}