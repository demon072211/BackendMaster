<?php

Class UserOnline extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Lay danh sach admin
     */
    function index()
    {
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        $this->data['temp'] = 'admin/useronline/index';
        $this->load->view('admin/main', $this->data);
    }

    function indexajax()
    {
        $params = [
            'pg' => $this->input->post("pg") ? $this->input->post("pg") : 1,
            'nn' => $this->input->post("nn"),
            'mi' => $this->input->post("size"),
        ];
        $data = $this->get_data_curl($this->config->item('admin-base') . 'list-useronline' . "?" . http_build_query($params));
        echo empty($data) ? "Bạn không được hack" : $data;
        return;
    }
}