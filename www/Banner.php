<?php

Class Banner extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index() {
        canMenu('banner');
        $this->data['temp'] = 'admin/banner/index';
        $this->load->view('admin/main', $this->data);
    }

    public function getListAjax()
    {
        canMenu('banner');
        $params = [
            'c' => 9403,
            'pg' => $this->input->post("pages"),
            'sts' => $this->input->post("sts"),
            'tt' => $this->input->post("tt"),
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

    public function create()
    {
        canMenu('banner');
        $this->data['temp'] = 'admin/banner/create';
        $this->load->view('admin/main', $this->data);
    }

    public function createAjax()
    {
        canMenu('banner');
        $sts = $this->input->post("sts");
        $params = [
            'c' => 9400,
            'pg' => $this->input->post("pages"),
            'sts' => empty($sts) ? 1 : 0,
            'tt' => $this->input->post("tt"),
            'ip' => $this->input->post("ip"),
            'url' => $this->input->post("url"),
            'ac' => $this->input->post("ac")
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

    public function edit()
    {
        canMenu('banner');
        $id = $this->input->get("id");
        $params = [
            'c' => 9404,
            'id' => $id,
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            if (empty($response)) {
                return redirect(admin_url('banner'));
            }
            $data = json_decode($response, true);
            if (empty($data['data'])) {
                return redirect(admin_url('banner'));
            }
            $this->data['temp'] = 'admin/banner/edit';
            $this->data['id'] = $id;
            $this->data['banner'] = $data['data'];
            $this->load->view('admin/main', $this->data);
        } catch (\Exception $e) {
            return redirect(admin_url('banner'));
        }
    }

    public function editAjax()
    {
        canMenu('banner');
        $params = [
            'c' => 9401,
            'id' => $this->input->post("id"),
            'tt' => $this->input->post("tt"),
            'ip' => $this->input->post("ip"),
            'sts' => $this->input->post("sts"),
            'url' => $this->input->post("url"),
            'ac' => $this->input->post("ac")
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception editAjax : ' . $e->getMessage());
            return;
        }
    }

    public function delete()
    {
        canMenu('banner');
        $params = [
            'c' => 9402,
            'id' => $this->input->get("id"),
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        $this->get_data_curl($endPoint);
        return redirect(admin_url('banner'));
    }
}