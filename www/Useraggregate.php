<?php

Class Useraggregate extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . "?c=8820&l=100&pn=0");
        if (isset($datainfo)) {
            $data_decode = json_decode($datainfo);
            $this->data['banklist'] = array_map(function ($x) {
                return ($x->bank_name);
            }, $data_decode->data);
        } else {
            echo "Không có danh sách ngân hàng";
        }

        $this->data['temp'] = 'admin/useraggregate/index';
        $this->data['nn'] = $this->input->get('nn');
        $this->data['us'] = $this->input->get('us');
        $this->data['uri'] = http_build_query([
            'nickname' => $this->input->get('nickname'),
            'refcode' => $this->input->get('refcode'),
            'typetaikhoan' => $this->input->get('typetaikhoan'),
            'record' => $this->input->get('record'),
            'phone' => $this->input->get('phone'),
            'txtemail' => $this->input->get('txtemail'),
            'fromDate' => $this->input->get('fromDate'),
            'toDate' => $this->input->get('toDate'),
        ]);
        $this->data['status'] = $this->input->get('st');
        $allStatus = str_repeat('0', 40 - strlen(decbin($this->data['status']))) . decbin($this->data['status']);
        $dao = $this->mb_strrev($allStatus, $encoding = "utf-8");

        $this->data['daochuoi'] = $dao;
        $this->data['gameName'] = $this->config->item('game_name');
        $this->data['dataGameUser'] = $this->getBetWinGames($this->data['nn']);
        $this->data['dataInfoUser'] = $this->getInfoUser($this->data['nn']);
        $this->load->view('admin/main', $this->data);
    }

    function historyajax()
    {
        $nickname = urlencode($this->input->post("nickname"));
        $iplogin = urlencode($this->input->post("iplogin"));
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $status = $this->input->post("status");
        $pages = $this->input->post("pages");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=109&nn=' . $nickname . '&ip=' . $iplogin . '&ts=' . urlencode($fromDate) . '&te=' . urlencode($toDate) . '&type=' . $status . '&p=' . $pages);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    private function getBetWinGames($nn)
    {
        if (empty($nn)) {
            return;
        }
        $params = [
            'c' => 8828,
            'nn' => $nn,
        ];
        $endPoint = $this->config->item('api_backend') . '?' . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            $data = json_decode($response, true);
            if (empty($data) || empty($data['totalRecords'])) {
                return;
            }
            if (empty($data['data'][0])) {
                return;
            }
            return $data['data'][0];
        } catch (\Exception $e) {
            log_message('error', 'Caught exception : ' . $e->getMessage());
            return;
        }
    }

    private function getInfoUser($nn) {
        if (empty($nn)) {
            return;
        }
        $params = [
            'c' => 9100,
            'nn' => $nn,
        ];
        $endPoint = $this->config->item('api_backend') . '?' . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            $data = json_decode($response, true);
            if (empty($data) || empty($data['data']) || empty($data['data']['user'])) {
                return;
            }
            return $data['data']['user'];
        } catch (\Exception $e) {
            log_message('error', 'Caught exception : ' . $e->getMessage());
            return;
        }
    }

    public function getBalanceUserThird() {
        $params = [
            't' => $this->input->post("type"),
            'nn' => $this->input->post("nickname"),
        ];
        $apiThreeRd = $this->config->item('api_three_rd');
        $endPoint = $apiThreeRd . '/3rd/balance?' . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            $data = json_decode($response, true);
            if (empty($data) || empty($data['data']) || !isset($data['data']['balance'])) {
                $balance = isset($data['message']) ? $data['message'] : 'Không trả về kết quả';
                echo json_encode(['balance' => $balance, 'message' => $response, 'userThirdParty' => '']);
                return;
            }
            $balance = (float)$data['data']['balance'];
            if (is_numeric($balance) && floor($balance) != $balance) {
                $result = ['balance' => number_format($balance, 2, '.', ',')];
            } else {
                $result = ['balance' => number_format($balance, 0, '.', ',')];
            }
            $result['userThirdParty'] = $data['data']['vendor_member_id'];
            echo json_encode($result);
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception getBalanceUserThird : ' . $e->getMessage());
            return;
        }
    }

    public function getBalanceFishThird()
    {
        $params = [
            'c' => '9436',
            'nn' => $this->input->post("nn"),
        ];
        $endPoint = $this->config->item('api_backend') . '?' . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            if (empty($response)) {
                $result = ['success' => false, 'message' => 'Không lấy dữ liệu.'];
                echo json_encode($result);
                return;
            }
            $data = json_decode($response, true);
            if (empty($data['success']) || !isset($data['data'])) {
                $result = ['success' => false, 'message' => ($data['message'] ?? '')];
                echo json_encode($result);
                return;
            }
            $balance = (float)$data['data'];
            if (is_numeric($balance) && floor($balance) != $balance) {
                $result = ['success' => true, 'balance' => number_format($balance, 2, '.', ',')];
            } else {
                $result = ['success' => true, 'balance' => number_format($balance, 0, '.', ',')];
            }
            echo json_encode($result);
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception getBalanceUserThird : ' . $e->getMessage());
            return;
        }
    }
}
