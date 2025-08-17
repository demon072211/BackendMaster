<?php

Class UserAgency extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        canMenu('userAgency');
        $this->data['temp'] = 'admin/useragent/index';
        $this->load->view('admin/main', $this->data);
    }

    public function create()
    {
        canMenu('userAgency/create');
        $this->data['temp'] = 'admin/useragent/create';
        $this->load->view('admin/main', $this->data);
    }

    public function createAjax()
    {
        canMenu('userAgency/create');
        $params = [
            'c' => 9422,
            'un' => $this->input->post("un"),
            'nn' => $this->input->post("nn"),
            'na' => $this->input->post("na"),
            'adr' => $this->input->post("ad"),
            'ph' => $this->input->post("ph"),
            'em' => $this->input->post("em"),
            'lv' => $this->input->post("lv"),
            'ac' => $this->input->post("ac"),
            'ps' => md5($this->input->post("ps")),
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception getListAjax : ' . $e->getMessage());
            return;
        }
    }

    public function getListAjax()
    {
        canMenu('userAgency');
        $params = [
            'c' => 9420,
            'pg' => $this->input->post("pages"),
            'code' => $this->input->post("code"),
            'key' => $this->input->post("key"),
            'lv' => $this->input->post("level"),
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
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
        canMenu('userAgency/create');
        $id = $this->uri->rsegment(3);
        $params = [
            'c' => 9424,
            'id' => $id,
        ];
        $endPoint = $this->config->item('api_agent') . "?" . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            if (empty($response)) {
                return redirect(admin_url('useragent'));
            }
            $data = json_decode($response, true);
            if (empty($data['data'])) {
                return redirect(admin_url('useragent'));
            }
            $this->data['temp'] = 'admin/useragent/edit';
            $this->data['id'] = $id;
            $this->data['agent'] = $data['data'];
            $this->load->view('admin/main', $this->data);
        } catch (\Exception $e) {
            return redirect(admin_url('useragent'));
        }
    }

    public function editAjax()
    {
        canMenu('userAgency/create');
        $params = [
            'c' => 9423,
            'id' => $this->input->post("id"),
            'adr' => $this->input->post("ad"),
            'ph' => $this->input->post("ph"),
            'ac' => $this->input->post("ac"),
            'em' => $this->input->post("em"),
            'lv' => $this->input->post("le")
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception editAjax : ' . $e->getMessage());
            return;
        }
    }

    public function player()
    {
        canMenu('userAgency/player');
        $this->data['temp'] = 'admin/useragent/player';
        $this->data['cd'] = empty($this->input->post("cd")) ? $this->input->get("cd") : $this->input->post("cd");
        $this->load->view('admin/main', $this->data);
    }

    public function playerAjax()
    {
        canMenu('userAgency/player');
        $params = [
            'c' => 9425,
            'cd' => empty($this->input->post("cd")) ? $this->config->item('default_code') : $this->input->post("cd"),
            'nn' => $this->input->post("nn"),
            'ft' => $this->input->post("ft"),
            'et' => $this->input->post("et"),
            'pg' => $this->input->post("pages")
        ];
        $endPoint = $this->config->item('api_agent') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception playerAjax : ' . $e->getMessage());
            return;
        }
    }

    public function profit()
    {
        canMenu('userAgency/profit');
        $this->data['temp'] = 'admin/useragent/profit';
        $this->load->view('admin/main', $this->data);
    }

    public function profitAjax()
    {
        canMenu('userAgency/profit');
        $params = [
            'c' => 77,
            'code' => $this->input->post("code"),
            'm' => $this->input->post("month"),
            'y' => $this->input->post("year"),
            'pg' => $this->input->post("pages"),
            'mi' => $this->input->post("size"),
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception playerAjax : ' . $e->getMessage());
            return;
        }
    }

    public function export()
    {
        canMenu('userAgency/export');
        $ref = $this->input->post("ref");
        $this->data['temp'] = 'admin/useragent/export';
        if (empty($ref)) {
            return $this->load->view('admin/main', $this->data);
        }
        $data = $this->getDataExport($ref);
        if (!$data) {
            return $this->load->view('admin/main', $this->data);
        }
        $csv = [];
        foreach ($data['data'] as $item) {
            $createTime = empty($item['createTime']) ? '' : date('m/d/Y H:i:s', $item['createTime']/1000);
            $csv[] = [$item['nickname'], $item['mobile'], $item['email'], $createTime];
        }
        unset($data);
        $this->array_csv_download($csv, date('Y-m-d') . '-' . $ref . '.csv');
        return $this->load->view('admin/main', $this->data);
    }

    public function getDataExport($ref)
    {
        canMenu('userAgency/export');
        $params = [
            'c' => 9429,
            'rc' => $ref,
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            $parse = json_decode($data, true);
            if(empty($parse['total']) || empty($parse['data'])) {
                return;
            }
            return $parse;
        } catch (\Exception $e) {
            return;
        }
    }

    function array_csv_download($array, $filename = "export.csv", $delimiter = ";")
    {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        ob_end_clean();
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Nickname', 'Phone', 'Email', 'Ngày đăng ký'], $delimiter);
        foreach ($array as $value) {
            fputcsv($handle, $value, $delimiter);
        }
        fclose($handle);
        exit();
    }

    function transaction()
    {
        canMenu('userAgency/transaction');
        $this->data['temp'] = 'admin/useragent/transaction';
        $this->load->view('admin/main', $this->data);
    }

    function transactionAjax()
    {
        canMenu('userAgency/transaction');
        $params = [
            'c' => 9453,
            'key' => $this->input->post("key"),
            'm' => $this->input->post("m"),
            'fbn' => $this->input->post("fbn"),
            'tbn' => $this->input->post("tbn"),
            'mi' => $this->input->post("size") ?? 10,
            'pn' => $this->input->post("pages") ?? 1,
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception playerAjax : ' . $e->getMessage());
            return;
        }
    }

    function rejectTransaction()
    {
        canMenu('userAgency/transaction');
        $params = [
            'c' => 9452,
            'id' => $this->input->post("id"),
            'code' => $this->input->post("code"),
            'uap' => $this->session->userdata('nick_name_login')
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            $result = json_decode($data, true);
            if ($result['success']) {
                echo json_encode(['success' => true]);
                return;
            }
            echo json_encode(['success' => false]);
            return;
        } catch (\Exception $e) {
            echo json_encode(['success' => false]);
            log_message('error', 'Caught exception rejectTransaction : ' . $e->getMessage());
            return;
        }
    }

    function approveTransaction()
    {
        canMenu('userAgency/transaction');
        $params = [
            'c' => 9451,
            'id' => $this->input->post("id"),
            'code' => $this->input->post("code"),
            'uap' => $this->session->userdata('nick_name_login')
        ];
        $endPoint = $this->config->item('api_backendy') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            $result = json_decode($data, true);
            if ($result['success']) {
                echo json_encode(['success' => true]);
                return;
            }
            echo json_encode(['success' => false, 'data' => $data]);
            return;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'data' => 'asdas']);
            log_message('error', 'Caught exception approveTransaction : ' . $e->getMessage());
            return;
        }
    }
}