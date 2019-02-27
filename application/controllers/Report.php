<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public $content;
	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('m_report');
		if(!$this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/login', 'refresh');
		}
    }

	public function index($data = null){
		$roll_id = $this->session->userdata('ROLL_ID');
		if($roll_id == 1) {
			$urlview = '_main/_report/user.php';
		}else if($roll_id == 2) {
			$urlview = '_main/_report/shipping_agent.php';
		}else if($roll_id == 3) {
			$urlview = '_main/_report/vendor.php';
		}

		$viewComp = array();
		$viewComp['_tittle_'] = "IPWMS | Vendor";
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";
		$viewComp['_contents_'] = $this->load->view($urlview, '', true);

		$viewComp['_link_css_'] .= '<link href="'.base_url().'/_asset/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">';
	    $viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>';

	    $viewComp['_link_css_'] .= '<link href="'.base_url().'/_asset/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/gentelella/vendors/iCheck/icheck.js"></script>';

	    $viewComp['_link_css_'] .= '<link href="'.base_url().'/_asset/jQuery-autoComplete-master/jquery.auto-complete.css" rel="stylesheet">';
		$viewComp['_link_js_'] .= '<script src="'.base_url().'/_asset/jQuery-autoComplete-master/jquery.auto-complete.js"></script>';


		$this->parser->parse('_main/index', $viewComp);
	}

	public function getReport(){
		$result = array();
		if ($_POST) {
			$sdate = $_POST['sdate'];
			$edate = $_POST['edate'];
		}
		// echo json_encode($_POST);
		// die;
		if(!$this->session->userdata('LOGGED')) {
			$result['response'] = false;
			$result['msg'] = "You Log Out...";
		}
		$result['response'] = true;
		$result['msg'] = "Success get Report...";
		$result['total_order'] = $this->m_report->getTotalOrder();
		$result['new_order'] = $this->m_report->getOrderNew();
		$result['order_on_progress'] = $this->m_report->getOrderOnProgress();
		$result['done_order'] = $this->m_report->getOrderDone();
		$wr = $this->m_report->getWasteReport();
		$view = '<table class="table table-striped jambo_table bulk_action">
					<thead>
						<tr>
							<th style="text-align:center;">WASTE NAME</th>
							<th style="text-align:center;"">REQUEST QUANTITY</th>
							<th style="text-align:center;"">TONGKANG QUANTITY</th>
							<th style="text-align:center;"">TRUCKING QUANTITY</th>
						</tr>
					</thead>
					<tbody>';
				
		if (!empty($wr)) {
			//ada data
			foreach ($wr as $list) {
				$view .= 
						'<tr>
							<td align="left">'.$list['WASTE_NAME'].'</td>
							<td align="center">'.$list['REQUEST_QTY'].'</td>
							<td align="center">'.$list['TONGKANG_QTY'].'</td>
							<td align="center">'.$list['TRUCKING_QTY'].'</td>
						</tr>';
			}
		} else {
			//no data
			$view .= 
					'<tr>
						<td align="center" colspan="4">no data</td>
					</tr>';
		}
		$view .= '
					</tbody>
				</table>';

		$result['waste_report'] = $view;
		
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function wasteReport(){
		$result['response'] = true;
		$result['msg'] = "Success get Report...";
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function getdata($data = null){
		$this->load->model('m_vendor');
		header('Content-Type: application/json');
		echo $this->m_vendor->getdata($this->session->userdata('ROLL_ID'));
	}

	public function callForm($data = null){
		$data = null;
		$html = '';
		if (isset($_GET['id'])) {
			$this->load->model('m_vendor');
			$id = explode('^', $_GET['id']);
			$data = $this->m_vendor->finddata($this->session->userdata('ROLL_ID'), $id);
			foreach ($data as $list) {
				$arrdata = array();
				$arrdata['data'] = $list;
				$arrdata['route'] = site_url().'/vendor/tools?action=store&id='.$list['VENDOR_ID'];
				$html .= $this->load->view('_main/_vendor/ipc_cabang-form.php', $arrdata, true);
			}
		}else{
			$arrdata = array();
			$arrdata['route'] = site_url().'/vendor/tools?action=store';
			$html .= $this->load->view('_main/_vendor/ipc_cabang-form.php', $arrdata, true);
		}
		header('Content-Type: application/json');
		echo json_encode(
			array(
				"response"=>true,
				"result"=>$html
			)
		);
	}

	public function tools($data = null){
		$this->load->model('m_vendor');
		$response = $this->m_vendor->tools($this->session->userdata('ROLL_ID'), $_GET, $_POST);
		header('Content-Type: application/json');
		echo json_encode( $response );
	}

	public function exportRawDataReport(){
		$this->load->library('PHPExcel');
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

	    $roll_id = $this->session->userdata('ROLL_ID');
	    $start = '21/2/2019';
	    $end = '27/2/2019';
		$fileName = 'report_raw_data_pwms__'.$start.'-'.$end;
		if ($roll_id == 3) {
			$fileName .= '_'.$this->session->userdata('NAME');
		}
	    $lists = $this->m_report->lists($roll_id, $start, $end);
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
}