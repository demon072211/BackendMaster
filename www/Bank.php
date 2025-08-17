<?php

class Bank extends MY_Controller {
    function __construct()
    {
        parent::__construct();
    }

    function index() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            echo '{"success":true,"errorCode":"0","message":null,"data":"{\"total\":0,\"data\":[ {\n  \"id\" : 10,\n  \"userId\" : 6540117,\n  \"nickName\" : \"TestLan001\",\n  \"bankName\" : \"VCB\",\n  \"customerName\" : \"Test 01\",\n  \"bankNumber\" : \"19008198\",\n  \"status\" : 1,\n  \"createDate\" : 1617770860000,\n  \"branch\" : \"VN\",\n  \"updateDate\" : 1617770860000\n} ]}"}
';
            return;
            $page = $this->input->post('page');
            if(!$page) {
                $page = 1;
            }

            $limit = $this->input->post('limit');
            if(!$limit) {
                $limit = 30;
            }

            $bankName = $this->input->post('bankName');
            $bankNumber = $this->input->post('bankNumber');
            $displayName = $this->input->post('displayName');
            $params = [
                'pn' => $page,
                'l' => $limit,
                'bn' => $bankName,
                'bnum' => $bankNumber,
                'nn' => $displayName,
                'c' => 8802
            ];
            $response = $this->doRequest($params);

            if(gettype($response) == 'string') {
                echo $response;
            } else {
                echo json_encode($response);
            }

            return;
        }
        $this->data['temp'] = 'admin/bank/index';
        $this->data['role'] = true; // fix menu sau
        $this->load->view('admin/main', $this->data);
    }

    function deleteBank() {
        $id = $this->input->post('id');
        if(!$id) {
            $response = [
                'success' => false,
                'msg' => 'Bank không hợp lệ'
            ];
            echo json_encode($response);
            return;
        }

        $params = [
            'id' => $id,
            'c' => 8803
        ];

        echo $this->doRequest($params);
    }

    function createBank() {
        echo $this->upsertBank();
    }

    function updateBank() {
        echo $this->upsertBank(1);
    }

    private function doRequest($params) {
        $url = $this->config->item('api_backend') . '?' . http_build_query($params);
        return $this->file_get_contents($url);
    }

    private function upsertBank($type = 0) {
        $displayName = $this->input->post('displayName');
        $bankName = $this->input->post('bankName');
        $customerName = $this->input->post('customerName');
        $bankNumber = $this->input->post('bankNumber');
        $branch = $this->input->post('branch');
        $status = $this->input->post('status');
        $params = [
            'cn' => $customerName,
            'br' => $branch,
            't' => $type,
            'st' => $status,
            'bn' => $bankName,
            'bnum' => $bankNumber,
            'nn' => $displayName,
            'c' => 8801
        ];

        $url = $this->config->item('api_backend') . '?' . http_build_query($params);
        return $this->file_get_contents($url);
    }
}
