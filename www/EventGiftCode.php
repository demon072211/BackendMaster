<?php

Class EventGiftCode extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        canMenu('eventGiftCode');
        $this->data['temp'] = 'admin/eventGiftCode/index';
        $this->load->view('admin/main', $this->data);
    }

    public function getListAjax()
    {
        canMenu('eventGiftCode');
        $params = [
            'c' => 9413,
            'pg' => $this->input->post("pages"),
            'n' => $this->input->post("name"),
            'am' => $this->input->post("amount"),
            'fg' => $this->input->post("flag"),
            'st' => $this->input->post("fromDate"),
            'et' => $this->input->post("toDate"),
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception getList event gift code : ' . $e->getMessage());
            return;
        }
    }

    public function create()
    {
        canMenu('eventGiftCode');
        $this->data['temp'] = 'admin/eventGiftCode/create';
        $this->load->view('admin/main', $this->data);
    }

    public function createAjax()
    {
        canMenu('eventGiftCode');
        $params = [
            'c' => 9410,
            'ed' => $this->input->post("ed"),
            'am' => $this->input->post("am"),
            'n' => $this->input->post("n"),
            'cd' => $this->input->post("cd"),
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
        canMenu('eventGiftCode');
        $id = $this->input->get("id");
        $params = [
            'c' => 9414,
            'id' => $id,
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            if (empty($response)) {
                return redirect(admin_url('eventGiftCode'));
            }

            $data = json_decode($response, true);
            if (empty($data['data'])) {
                return redirect(admin_url('eventGiftCode'));
            }

            $this->data['eventGiftCode'] = $data['data'];
            $this->data['temp'] = 'admin/eventGiftCode/edit';
            $this->data['id'] = $id;
            $this->load->view('admin/main', $this->data);
        } catch (\Exception $e) {
            return redirect(admin_url('banner'));
        }
    }

    public function storeAjax()
    {
        canMenu('eventGiftCode');
        $params = [
            'c' => 9411,
            'id' => $this->input->post("id"),
            'am' => $this->input->post("am"),
            'fg' => 2,
            'et' => $this->input->post("et"),
            'n' => $this->input->post("n")
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            log_message('error', 'data : ' . $endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception store ajax : ' . $e->getMessage());
            return;
        }
    }
}