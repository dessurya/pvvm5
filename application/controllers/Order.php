<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		if(!$this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/login', 'refresh');
		}
    }

	public function index($data, $show = null){
		$urlview = '_main/_order/index.php';
		if ($data == 'list') {
			$tittle = 'Order List';
		}else if ($data == 'pickup') {
			$tittle = 'Pick Up Order';
		}
		$send['tittle'] = $tittle;
		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | ".$tittle;
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
		$this->load->model('m_order');
		header('Content-Type: application/json');
		echo $this->m_order->getdata($this->session->userdata('ROLL_ID'), $data);
	}

	public function show($data = null){
		$response = array();
		$urlview = '_main/_order/show.php';

		if ($data == null) {
			$response['response'] = false;
		}else{
			$roll_id = $this->session->userdata('ROLL_ID');
			$send = array();
			$this->load->model('m_order');
			$find = $this->m_order->finddata($roll_id, $data);
			$find = $find[0];
			$send['head'] = $find;
			$send['detail'] = $this->m_order->finddatadetail($roll_id, $data);
			$send['history'] = $this->m_order->history($roll_id, $data);
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
		$this->load->model('m_order');
		if ($data == 'store') {
			$this->m_order->store($this->session->userdata('ROLL_ID'), $send);
		}else if($data == 'pickupordersubmit') {
			$this->m_order->pickupordersubmit($this->session->userdata('ROLL_ID'), $send);
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function testReport(){
		$this->load->library('PHPExcel');
		$fileName = 'report_pwms';
		$cellArray = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P',
            'Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP',
            'AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
            'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP',
            'BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
            'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP',
            'CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
            'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP',
            'DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
            'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP',
            'EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
            'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP',
            'FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
            'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP',
            'GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
            'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP',
            'HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
            'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ','IK','IL','IM','IN','IO','IP',
            'IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ',
            'JA','JB','JC','JD','JE','JF','JG','JH','JI','JJ','JK','JL','JM','JN','JO','JP',
            'JQ','JR','JS','JT','JU','JV','JW','JX','JY','JZ',
            'KA','KB','KC','KD','KE','KF','KG','KH','KI','KJ','KK','KL','KM','KN','KO','KP',
            'KQ','KR','KS','KT','KU','KV','KW','KX','KY','KZ',
            'LA','LB','LC','LD','LE','LF','LG','LH','LI','LJ','LK','LL','LM','LN','LO','LP',
            'LQ','LR','LS','LT','LU','LV','LW','LX','LY','LZ',
            'MA','MB','MC','MD','ME','MF','MG','MH','MI','MJ','MK','ML','MM','MN','MO','MP',
            'MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ'
        );

        $this->load->model('m_report');
		$wastelist = $this->m_report->wastelist();

		$new = new PHPExcel();
        $new->createSheet(0)
	        ->setTitle('Report')
	        ->setCellValue('A1', 'Order Date')
	        ->mergeCells('A1:A3')
	        ->setCellValue('B1', 'Pick Up Date')
	        ->mergeCells('B1:B3')
	        ->setCellValue('C1', 'PKK NO')
	        ->mergeCells('C1:C3')
	        ->setCellValue('D1', 'NO Layanan')
	        ->mergeCells('D1:D3')
	        ->setCellValue('E1', 'Agent')
	        ->mergeCells('E1:E3')
	        ->setCellValue('F1', 'Pelabuhan')
	        ->mergeCells('F1:F3')
	        ->setCellValue('G1', 'Vendor')
	        ->mergeCells('G1:G3')
	        ->setCellValue('H1', 'Status')
	        ->mergeCells('H1:H3')
	        ->setCellValue('I1', 'Order Waste Detail')
	        ->mergeCells('I1:'.$cellArray[(COUNT($wastelist)*3)+7].'1' );

	    $startcell = 8;
	    $addcell = 0;
	    foreach($wastelist as $list){
	    	$oncell = $startcell+$addcell;
	    	$margecell2 = $oncell+2;
	    	$margecell1 = $oncell+1;
	    	$new->setActiveSheetIndex(0)
	    		->setCellValue($cellArray[$oncell].'2', $list['WASTE_NAME'])
	    		->mergeCells($cellArray[$oncell].'2:'.$cellArray[$margecell2].'2')
	    		->setCellValue($cellArray[$oncell].'3', 'Request')
	    		->setCellValue($cellArray[$margecell1].'3', 'Tongkang')
	    		->setCellValue($cellArray[$margecell2].'3', 'Trucking');
	    	$addcell += 3;
	    }

	    $lists = $this->m_report->lists();
	    $row = 4;

	    foreach ($lists as $list) {
	    	$new->setActiveSheetIndex(0)
	    		->setCellValue('A'.$row, $list['WARTA_KAPAL_DATE'])
	    		->setCellValue('B'.$row, $list['ORDER_DATE'])
	    		->setCellValue('C'.$row, $list['PKK_NO'])
	    		->setCellValue('D'.$row, $list['LAYANAN_NO'])
	    		->setCellValue('E'.$row, $list['PERUSAHAAN_NAMA'])
	    		->setCellValue('F'.$row, $list['PELABUHAN_KODE'])
	    		->setCellValue('G'.$row, $list['VENDOR_NAMA'])
	    		->setCellValue('H'.$row, $list['STATUS_NAMA']);

		    $startcell = 8;
		    $addcell = 0;
			foreach ($wastelist as $slist) {
				$oncell = $startcell+$addcell;
		    	$margecell2 = $oncell+2;
		    	$margecell1 = $oncell+1;
				$qty = $this->m_report->qty($list['WARTA_KAPAL_IN_ID'], $slist['WASTE_ID']);
				if ($qty == false) {
					$new->setActiveSheetIndex(0)
			    		->setCellValue($cellArray[$oncell].$row, '-')
			    		->setCellValue($cellArray[$margecell1].$row, '-')
			    		->setCellValue($cellArray[$margecell2].$row, '-');
				}else{
					$new->setActiveSheetIndex(0)
			    		->setCellValue($cellArray[$oncell].$row, $qty['REQUEST'])
			    		->setCellValue($cellArray[$margecell1].$row, $qty['TONGKANG'])
			    		->setCellValue($cellArray[$margecell2].$row, $qty['TRUCKING']);
				}
				$addcell += 3;
			}
	    	$row++;
	    }

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'.xlsx"');
        header('Cache-Control: max-age=0');

        $newWriter = PHPExcel_IOFactory::createWriter($new, 'Excel2007');
        $newWriter->save('php://output');
        exit;
	}

	public function maketable(){
		$this->load->model('m_report');
		$wastelist = $this->m_report->wastelist();
		$html = '<table border ="2">
			<tr>
				<td rowspan="3">Order Date</td>
				<td rowspan="3">Pick Up Date</td>
				<td rowspan="3">PKK NO</td>
				<td rowspan="3">NO Layanan</td>
				<td rowspan="3">Agent</td>
				<td rowspan="3">Pelabuhan</td>
				<td rowspan="3">Vendor</td>
				<td rowspan="3">Status</td>
				<td colspan="'.(COUNT($wastelist)*3).'">Order Waste Detail</td>
		</tr>';
		$html .= '<tr>';
		foreach ($wastelist as $list) {
			$html .='<td colspan="3">'.$list['WASTE_NAME'].'</td>';
		}
		$html .= '</tr>';
		$html .= '<tr>';
		foreach ($wastelist as $list) {
			$html .='<td>Request</td>';
			$html .='<td>Tongkang</td>';
			$html .='<td>Trucking</td>';
		}
		$html .= '</tr>';

		$lists = $this->m_report->lists();
		foreach ($lists as $list) {
			$html .= '<tr>';
			$html .='<td>'.$list['WARTA_KAPAL_DATE'].'</td>';
			$html .='<td>'.$list['ORDER_DATE'].'</td>';
			$html .='<td>'.$list['PKK_NO'].'</td>';
			$html .='<td>'.$list['LAYANAN_NO'].'</td>';
			$html .='<td>'.$list['PERUSAHAAN_NAMA'].'</td>';
			$html .='<td>'.$list['PELABUHAN_KODE'].'</td>';
			$html .='<td>'.$list['VENDOR_NAMA'].'</td>';
			$html .='<td>'.$list['STATUS_NAMA'].'</td>';
			foreach ($wastelist as $slist) {
				$qty = $this->m_report->qty($list['WARTA_KAPAL_IN_ID'], $slist['WASTE_ID']);
				if ($qty == false) {
					$html .='<td>-</td>';
					$html .='<td>-</td>';
					$html .='<td>-</td>';
				}else{
					$html .='<td>'.$qty['REQUEST'].'</td>';
					$html .='<td>'.$qty['TONGKANG'].'</td>';
					$html .='<td>'.$qty['TRUCKING'].'</td>';
				}
			}
			$html .= '</tr>';
		}	

		$html .= '</table>';

		echo $html;
	}
}