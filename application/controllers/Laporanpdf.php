<?php
Class Laporanpdf extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->library('pdf');
    }
    
    function template(){
        $pdf = new FPDF();
        $pdf->AddPage('P', 'A4');
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTopMargin(10);
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);


        /* --- Ln --- */
        $pdf->SetY(10);
        $pdf->Ln(5);
        /* --- MultiCell --- */
        /* --- MultiCell --- */


        $pdf->Output('created_pdf.pdf','I');
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
        $this->kop($pdf);
        $this->header($pdf,1);
        $this->isi($pdf);
        $pdf->ln(100);
        // $x = $pdf->GetX();
        // $y = $pdf->GetY();

        // $col1="PILOT REMARKS\n\n";
        // $pdf->MultiCell(189, 10, $col1, 1, 1);

        // $pdf->SetXY($x + 189, $y);

        // $col2="Pilot's Name and Signature\n"."EDII";
        // $pdf->MultiCell(63, 10, $col2, 1);
        // $pdf->Ln(0);
        // $col3="Date Prepared\n"."tanggal";
        // $pdf->MultiCell(63, 10, $col3, 1);
        // $this->div($pdf);
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
        if ($status == 1) {
            $judul_bawah = "PENGAMBILAN LIMBAH B3";
        } else if ($status == 2) {
            $judul_bawah = "PENGELUARAN LIMBAH SLUDGE OIL";
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'SURAT PERINTAH KERJA (SPK)',0,1,'C');
        $pdf->Cell(190,7,'PENGAMBILAN LIMBAH B3',0,1,'C');
        $pdf->ln(5);
    }

    private function div($pdf) {
        $dash = '--------------------------------------------------------------------------------------------------------------------------------------------------------------';
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,10,$dash);
        
    }

    function addEcheance( $date )
    {
        $r1  = 80;
        $r2  = $r1 + 40;
        $y1  = 80;
        $y2  = $y1+10;
        $mid = $y1 + (($y2-$y1) / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
        $this->Line( $r1, $mid, $r2, $mid);
        $this->SetXY( $r1 + ($r2 - $r1)/2 - 5 , $y1+1 );
        $this->SetFont( "Arial", "B", 10);
        $this->Cell(10,4, "DATE D'ECHEANCE", 0, 0, "C");
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5 , $y1 + 5 );
        $this->SetFont( "Arial", "", 10);
        $this->Cell(10,5,$date, 0,0, "C");
    }

}