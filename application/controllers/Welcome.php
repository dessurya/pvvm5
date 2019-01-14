<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index(){
		if($this->session->userdata('LOGGED')) {
			redirect(base_url().'index.php/profile', 'refresh');
		}else{
			redirect(base_url().'index.php/login', 'refresh');
		}
	}
}
