<?php
Class Test extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $roll_id = $this->session->userdata('ROLL_ID');
        $urlview = '_main/_report/tr.php';

        $viewComp = array();
        $viewComp['_tittle_'] = "PWMS | Report";
        $viewComp['_link_css_'] = "";
        $viewComp['_link_js_'] = "";
        // $viewComp['_contents_'] = $this->load->view($urlview, '', true);
        $viewComp['_contents_'] = $this->getIndex();
        $this->parser->parse('_main/index', $viewComp);
    }

    private function getIndex(){
        $this->load->model('m_report');
        $list_agent = $this->m_report->get_agent();
        // var_dump($list_agent);
        // // exit();
        $arrdata = array();
        $arrdata['list_agent'] = $list_agent;
        return $this->load->view('_main/_report/tr.php', $arrdata, true);
    }

}