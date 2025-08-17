<?php
Class Ccu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

    }
    /*
     * Lay ra danh sach danh muc san pham
     */
    function index()
    {
        canMenu('ccu');
        $this->data['temp'] = 'admin/ccu/index';
        $this->load->view('admin/main', $this->data);
    }
    function indexajax()
    {
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $datainfo = $this->get_data_curl($this->config->item('api_backend2').'?c=108&ts='.urlencode($toDate).'&te='.urlencode($fromDate));
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
}