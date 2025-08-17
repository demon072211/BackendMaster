<?php

Class Giftcodes extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('logadmin_model');
        $this->load->model('actionadmin_model');
        $this->load->library('paginationlib');
    }

    function giftcodeslist()
    {
//        canMenu('giftcodes/giftcodeslist');
        $this->data['temp'] = 'admin/giftcodes/giftcodeslist';
        $eventConfig = $this->getEventConfig();
        $this->data['eventConfig'] = $eventConfig ? $eventConfig : [['name' => 'Không lấy được giá trị. Liên hệ với admin', 'id' => 0]];
        $this->load->view('admin/main', $this->data);
    }

    function giftcodeslistajax()
    {
        $params = [
            'c' => 9001,
            'gc' => $this->input->post("giftCode"),
            'un' => $this->input->post("userName"),
            'an' => $this->session->userdata('user_name_login'),
            'pg' => $this->input->post("pages"),
            'mi' => $this->input->post("size"),
            'mi' => $this->input->post("size"),
            'cb' => $this->input->post("createdBy"),
            'ev' => $this->input->post("bonusType"),
        ];
        $startDate = $this->input->post("fromTime");
        $endDate = $this->input->post("endTime");
        if (!empty($startDate) && !empty($endDate)) {
            $date = DateTime::createFromFormat('Y-m-d h:i:s', $startDate);
            $st = $date->format('Y-m-d') . ' 00:00:00';
            $date = DateTime::createFromFormat('Y-m-d h:i:s', $endDate);
            $et = $date->format('Y-m-d') . ' 23:59:59';
            $params = $params + ['st' => $st, 'et' => $et];
        }

        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        $datainfo = $this->get_data_curl($endPoint);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function giftcodesused()
    {
//        canMenu('giftcodes/giftcodesused');
        $this->data['temp'] = 'admin/giftcodes/giftcodesused';
        $eventConfig = $this->getEventConfig();
        $this->data['eventConfig'] = $eventConfig ? $eventConfig : [['name' => 'Không lấy được giá trị. Liên hệ với admin', 'id' => 0]];
        $this->load->view('admin/main', $this->data);
    }

    function giftcodesusedajax()
    {
        $params = [
            'c' => 9002,
            'nn' => urlencode($this->input->post("nickName")),
            'gid' => urlencode($this->input->post("giftCodeId")),
            'an' => $this->session->userdata('user_name_login'),
            'pg' => urlencode($this->input->post("pages")),
            'mi' => urlencode($this->input->post("size")),
            'ev' => urlencode($this->input->post("bonusType")),
            'ft' => urlencode($this->input->post("flagtime")),
        ];
        $startDate = $this->input->post("fromTime");
        $endDate = $this->input->post("endTime");
        if (!empty($startDate) && !empty($endDate)) {
            $date = DateTime::createFromFormat('Y-m-d h:i:s', $startDate);
            $st = $date->format('Y-m-d') . ' 00:00:00';
            $date = DateTime::createFromFormat('Y-m-d h:i:s', $endDate);
            $et = $date->format('Y-m-d') . ' 23:59:59';
            $params = $params + ['st' => $st, 'et' => $et];
        }

        $datainfo = $this->get_data_curl($this->config->item('api_backend') . "?" . http_build_query($params));
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function addgiftcode()
    {
        $this->data['temp'] = 'admin/giftcodes/addgiftcode';
        $eventConfig = $this->getEventConfig();
        $this->data['eventConfig'] = $eventConfig ? $eventConfig : [['name' => 'Không lấy được giá trị. Liên hệ với admin', 'id' => 0]];
        $this->load->view('admin/main', $this->data);
    }

    function addgiftcodeajax()
    {
        $approvedName = $this->session->userdata('user_name_login');
        $giftCode = urlencode($this->input->post("inputGiftCode"));
        $type = urlencode($this->input->post("inputType"));
        $mount = urlencode($this->input->post("inputAmount"));
        $nick_name = urlencode($this->input->post("inputNickName"));
        $numberUsed = urlencode($this->input->post("inputNumberUsed"));
        $inputEvent = urlencode($this->input->post("inputEvent"));
        $startTime = urlencode($this->input->post("fromTime"));
        $endTime = urlencode($this->input->post("endTime"));


        $datainfo = $this->get_data_curl($this->config->item('api_backend')
            . "?c=9000&cb=$approvedName&gc=$giftCode&type=$type&am=$mount&nn=$nick_name&nu=$numberUsed&ev=$inputEvent&st=$startTime&et=$endTime");

        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function addgiftcodecskh()
    {
        $this->data['temp'] = 'admin/giftcodes/addgiftcodecskh';
        $this->load->view('admin/main', $this->data);
    }

    function addgiftcodecskhajax()
    {
        $approvedName = $this->session->userdata('user_name_login');
        $giftCode = urlencode($this->input->post("inputGiftCode"));
        $type = urlencode($this->input->post("inputType"));
        $mount = urlencode($this->input->post("inputAmount"));
        $nick_name = urlencode($this->input->post("inputNickName"));
        $numberUsed = urlencode($this->input->post("inputNumberUsed"));
        $inputEvent = urlencode($this->input->post("inputEvent"));
        $startTime = urlencode($this->input->post("fromTime"));
        $endTime = urlencode($this->input->post("endTime"));


        $datainfo = $this->get_data_curl($this->config->item('api_backend')
            . "?c=9000&cb=$approvedName&gc=$giftCode&type=$type&am=$mount&nn=$nick_name&nu=$numberUsed&ev=$inputEvent&st=$startTime&et=$endTime");

        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

}