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
		$this->load->model('m_admin');
		if ($this->m_admin->checkAcces($this->session->userdata('ROLL_ID')) == false) {
			redirect(base_url().'index.php/profile', 'refresh');
		}
    }

	public function index($data = null){
		$roll_id = $this->session->userdata('ROLL_ID');
		$vendor_id = $this->session->userdata('VENDOR_ID');
		$urlview = '_main/_report/index.php';

		$viewComp = array();
		$viewComp['_tittle_'] = "PWMS | Report";
		$viewComp['_link_css_'] = "";
		$viewComp['_link_js_'] = "";

		$list_agent = $this->m_report->get_agent();
		$list_kapal = $this->m_report->get_kapal($vendor_id);
        $arrdata = array();
        $arrdata['list_agent'] = $list_agent;
        $arrdata['list_kapal'] = $list_kapal;
		$viewComp['_contents_'] = $this->load->view($urlview, $arrdata, true);
		$this->parser->parse('_main/index', $viewComp);
	}

	public function test(){
		$search = $_GET['search'];

		$list_test = $this->m_report->get_test($search);

		// $result['response'] = true;
		// $result['msg'] = "Success get Report...";
  //       $result['list_test'] = $list_test;

		header('Content-Type: application/json');
		echo json_encode($list_test);
	}

	public function getReport(){
		$result = array();
		if ($_POST) {
			$sdate = $_POST['sdate'];
			$edate = $_POST['edate'];
		}

		if(!$this->session->userdata('LOGGED')) {
			$result['response'] = false;
			$result['msg'] = "You Log Out...";
		}
		$result['response'] = true;
		$result['msg'] = "Success get Report...";
		$roll_id = $this->session->userdata('ROLL_ID');
		$self_id = $this->session->userdata('DETAIL_ID');
		$result['total_order'] = $this->m_report->getTotalOrder($roll_id, $self_id);
		$result['new_order'] = $this->m_report->getOrderNew($roll_id, $self_id);
		$result['order_on_progress'] = $this->m_report->getOrderOnProgress($roll_id, $self_id);
		$result['done_order'] = $this->m_report->getOrderDone($roll_id, $self_id);
		$wr = $this->m_report->getWasteReport($roll_id, $self_id);
		// var_dump($wr);
		// exit();
		$view = '<table class="table table-bordered">
					<thead>
						<tr>
							<th style="text-align:center;">WASTE TYPE</th>
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
				//format value if null and so
				if (is_null($list['TONGKANG_QTY'])) {
					$tong_val = " - ";
				} else {
					$tong_val = $list['TONGKANG_QTY'].' '.$list['UM_NAME'];
				}
				if (is_null($list['REQUEST_QTY'])) {
					$req_val = " - ";
				} else {
					$req_val = $list['REQUEST_QTY'].' '.$list['UM_NAME'];
				}
				if (is_null($list['TRUCKING_QTY'])) {
					$truk_val = " - ";
				} else {
					$truk_val = $list['TRUCKING_QTY'].' '.$list['UM_NAME'];
				}

				$view .= 
						'<tr>
							<td align="left">'.$list['TYPE_NAME'].'</td>
							<td align="left">'.$list['WASTE_NAME'].'</td>
							<td align="center">'.$req_val.'</td>
							<td align="center">'.$tong_val.'</td>
							<td align="center">'.$truk_val.'</td>
						</tr>';
			}
		} else {
			//no data
			$view .= 
					'<tr>
						<td align="center" colspan="5">no data</td>
					</tr>';
		}
		$view .= '
					</tbody>
				</table>';

		$result['waste_report'] = $view;
		$result['btn_export'] = '<a class="btn btn-info" href="'.site_url().'/report/exportRawDataReport/'.str_replace('/','_',$_POST['sdate']).'/'.str_replace('/','_',$_POST['edate']).'"><i class="fa fa-file-excel-o"></i> Export Row Data</a>';
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function exportRawDataReport($start, $end){
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
	        ->setCellValue('B1', 'Pick Up Date')
	        ->setCellValue('C1', 'PKK NO')
	        ->setCellValue('D1', 'NO Layanan')
	        ->setCellValue('E1', 'Agent')
	        ->setCellValue('F1', 'Pelabuhan')
	        ->setCellValue('G1', 'Vendor')
	        ->setCellValue('H1', 'Status');

	    $startcell = 8;
	    $addcell = 0;
	    foreach($wastelist as $list){
	    	$oncell = $startcell+$addcell;
	    	$margecell2 = $oncell+2;
	    	$margecell1 = $oncell+1;
	    	$new->setActiveSheetIndex(0)
	    		->setCellValue($cellArray[$oncell].'1', $list['WASTE_NAME'].' Request')
	    		->setCellValue($cellArray[$margecell1].'1', $list['WASTE_NAME'].' Tongkang')
	    		->setCellValue($cellArray[$margecell2].'1', $list['WASTE_NAME'].' Trucking');
	    	$addcell += 3;
	    }

	    $roll_id = $this->session->userdata('ROLL_ID');
		$fileName = 'report_raw_data_pwms__'.$start.'-'.$end;
		if ($roll_id == 3) {
			$fileName .= '_'.$this->session->userdata('NAME');
		}
	    $lists = $this->m_report->lists($roll_id, str_replace('_','/',$start), str_replace('_','/',$end));
	    $row = 2;

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
        header('Content-Disposition: attachment; filename="'.$fileName.'.xls"');
        header('Cache-Control: max-age=0');

        $newWriter = PHPExcel_IOFactory::createWriter($new, 'Excel5');
        // ob_clean();
        $newWriter->save('php://output');
        exit;
	}
}