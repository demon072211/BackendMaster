<?php
Class UnPermission extends MY_Controller
{
    function index()
    {
        $this->data['temp'] = 'admin/403';
        $this->load->view('admin/main', $this->data);
    }
}