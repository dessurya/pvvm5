<?php
Class Laporanpdf extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->library('pdf');
    }
    

    function index(){
        $pdf = new FPDF('P','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        // $pdf->Cell(190,7,'PT. PELABUHAN INDONESIA II (PERSERO)',0,1,'C');
        // $pdf->SetFont('Arial','B',12);
        $this->header($pdf);
        $pdf->ln(130);
        $this->div($pdf);

        // $pdf->SetFont('Arial','B',10);
        // $pdf->Cell(40,10,'PT. PELABUHAN INDONESIA II (PERSERO)');
        // $pdf->Cell(190,7,'Cabang Pelabuhan Tanjung Priok',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        // $pdf->Cell(10,7,'',0,1);
        // $pdf->SetFont('Arial','B',10);
        // $pdf->Cell(20,6,'NIM',1,0);
        // $pdf->Cell(85,6,'NAMA MAHASISWA',1,0);
        // $pdf->Cell(27,6,'NO HP',1,0);
        // $pdf->Cell(25,6,'TANGGAL LHR',1,1);
        // $pdf->SetFont('Arial','',10);
        // $mahasiswa = $this->db->get('mahasiswa')->result();
        // foreach ($mahasiswa as $row){
        //     $pdf->Cell(20,6,$row->nim,1,0);
        //     $pdf->Cell(85,6,$row->nama_lengkap,1,0);
        //     $pdf->Cell(27,6,$row->no_hp,1,0);
        //     $pdf->Cell(25,6,$row->tanggal_lahir,1,1); 
        // }
        $pdf->Output();
    }

    // Page header
    private function header($pdf)
    {
    // Logo
        // $this->Image('logo.png',10,6,30);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,10,'PT. PELABUHAN INDONESIA II (PERSERO)');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,10,'FM.01/04/04/06',0,10,'C');
        $pdf->ln(-5);
        $pdf->Cell(40,10,'Cabang Pelabuhan Tanjung Priok');
    // Line break
        // $this->Ln(20);
    }

    private function div($pdf)
    {
    // Logo
        // $this->Image('logo.png',10,6,30);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,10,'--------------------------------------------------------------------------------------------------------------------------------------------------------------');
        
    // Line break
        // $this->Ln(20);
    }

}