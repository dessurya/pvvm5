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
}