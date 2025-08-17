<?php

Class Loguserdetail extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('logadmin_model');
        $this->load->model('actionadmin_model');
        $this->load->library('paginationlib');
    }

    function listdata()
    {
        canMenu('loguserdetail/listdata');

        $this->data['temp'] = 'admin/loguserdetail/index';
        $this->load->view('admin/main', $this->data);
    }

    function indexajax()
    {
        $approvedName = $this->session->userdata('user_name_login');

        $nickName = urlencode($this->input->post("nickName"));
        $fromTime = urlencode($this->input->post("fromTime"));
        $endTime = urlencode($this->input->post("endTime"));
        $page = urlencode($this->input->post("pages"));
        $limit = urlencode($this->input->post("size"));

        $datainfo = $this->get_data_curl($this->config->item('api_backend')
            . "?c=8850&admin=$approvedName&nn=$nickName&ft=$fromTime&et=$endTime&pg=$page&mi=$limit");

        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

}