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
		$this->load->model('m_admin');
		if ($this->m_admin->checkAcces($this->session->userdata('ROLL_ID')) == false) {
			redirect(base_url().'index.php/profile', 'refresh');
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
			$send['attachment_tongkang'] = $this->m_order->getAttachment($roll_id, $data, 'TONGKANG');
			$send['attachment_trucking'] = $this->m_order->getAttachment($roll_id, $data, 'TRUCKING');
			$send['history'] = $this->m_order->history($roll_id, $data);
			$send['all_status'] = $this->m_order->getallstatus();
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
		$response['msg'] = 'Success...';
		$response['type'] = 'orderrecalldetail';
		$response['reload'] = true;
		$send = array();
		$send['post'] = $_POST;
		$send['get'] = $_GET;
		$roll_id = $this->session->userdata('ROLL_ID');
		$this->load->model('m_order');
		if ($data == 'store') {
			$response['url'] = site_url().'/order/show/'.$_GET['warta_kapal_in_id'];
			$this->m_order->store($roll_id, $send);
		}else if($data == 'pickupordersubmit') {
			$response['url'] = site_url().'/order/show/'.$_GET['warta_kapal_in_id'];
			$this->m_order->pickupordersubmit($roll_id, $send);
		}else if($data == 'upload_dokumen'){
			$response['type'] = '';
			$response['reload'] = false;
			$response['status'] = $_POST['status'];
			$response['url'] = site_url().'/order/show/'.$_POST['id'];

			$orig_name = preg_replace('/-+/', "-", preg_replace('/[^a-z0-9-]/', '-', strtolower($_FILES['file']['name'])));
			$file_type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$change_name = $orig_name.date("His").".".$file_type;
			$uploads_dir = './upload/order_attachment/'.$_POST['id'];
            if (!is_dir($uploads_dir)){
                $old = umask(0);
                mkdir($uploads_dir,0777);
                umask($old);
            }
            $uploads_dir .= "/";
            $path = 'upload/order_attachment/'.$_POST['id']."/".$change_name;
            $response['file_location'] = $path;
            $response['file_type'] = $file_type;
            $response['file_name'] = $orig_name;

            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['remove_spaces'] = TRUE;
            $config['upload_path'] = $uploads_dir;
            $config['file_name'] = $change_name;
            $this->load->library('upload', $config);
            if(!$this->upload->do_upload("file")){
                $response['response'] = false;
                $response['msg'] = 'Fail...'.$this->upload->display_errors();
            }else{
                $myfile = fopen($uploads_dir . "/index.php", "w");
                fwrite($myfile, null);
                fclose($myfile);
	            $send['file_location'] = $path;
	            $send['file_type'] = $file_type;
	            $send['file_name'] = $orig_name;
	            $response['append'] = $this->m_order->upload_dokumen($roll_id, $send);
            }
		}else{
			$response['response'] = true;
			$response['msg'] = 'Fail...';
		}

		header('Content-Type: application/json');
		echo json_encode( $response );
	}

}