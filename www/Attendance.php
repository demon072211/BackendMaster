<?php

Class Attendance extends MY_Controller
{
    function index()
    {
        canMenu('attendance');
        $this->data['temp'] = 'admin/attendance/index';
        $this->load->view('admin/main', $this->data);
    }

    public function getListAjax()
    {
        canMenu('attendance');
        $params = [
            'c' => 9439,
            'pg' => $this->input->post("pages") ?? 1,
            'nn' => $this->input->post("nn"),
            'mi' => $this->input->post("size") ?? 10,
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception getListAjax : ' . $e->getMessage());
            return;
        }
    }
}