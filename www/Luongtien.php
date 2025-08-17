<?php

Class Luongtien extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('logadmin_model');
        $this->load->model('actionadmin_model');
        $this->load->library('paginationlib');
    }

    function loghoantra()
    {
//        canMenu('report/logbonus');

        $this->data['temp'] = 'admin/luongtien/loghoantra';
        $this->load->view('admin/main', $this->data);
    }

    function loghoantraajax()
    {
        $params = [
            'c' => '8902',
            'nn' => $this->input->post("nickName"),
            'tm' => $this->input->post("time"),
            'pg' => $this->input->post("pages"),
        ];
        $endPoint = $this->config->item('api_backend') . '?' . http_build_query($params);

        try {
            $data = $this->get_data_curl($endPoint);
            if (isset($data)) {
                echo $data;
                return;
            }
            echo "Bạn không được hack";
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception loghoantraajax : ' . $e->getMessage());
            echo "Bạn không được hack";
            return;
        }
    }

    function hoantrahistories()
    {
//        canMenu('report/logbonus');

        $this->data['temp'] = 'admin/luongtien/loghoantrahistories';
        $this->load->view('admin/main', $this->data);
    }

    function hoantrahistoriesajax()
    {
        $approvedName = $this->session->userdata('user_name_login');
        $nickName = urlencode($this->input->post("nickName"));
        $time = urlencode($this->input->post("time"));
        $pages = urlencode($this->input->post("pages"));
        $size = urlencode($this->input->post("size"));

        $datainfo = $this->get_data_curl($this->config->item('api_backend')
            . "?c=8903&admin=$approvedName&nn=$nickName&tm=$time&pg=$pages&mi=$size");

        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function createhoantraajax()
    {
        $approvedName = $this->session->userdata('user_name_login');
        $nickName = urlencode($this->input->post("nickName"));
        $date = urlencode($this->input->post("date"));

        $datainfo = $this->get_data_curl($this->config->item('api_backend')
            . "?c=8900&admin=$approvedName&nn=$nickName&action=0&tm=$date");

        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function sendhoantraajax()
    {
        $approvedName = $this->session->userdata('user_name_login');
        $nickName = urlencode($this->input->post("nickName"));
        $date = urlencode($this->input->post("date"));
        $all = urlencode($this->input->post("all"));

        $datainfo = $this->get_data_curl($this->config->item('api_backend')
            . "?c=8900&admin=$approvedName&nn=$nickName&action=1&tm=$date&all=$all");

        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }
}