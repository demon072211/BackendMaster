<?php

Class Confignew extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
       $this->load->model('gameconfig_model');
        //$this->load->model('logadmin_model');
    }

    function index()
    {

        $this->data['temp'] = 'admin/config/index';
        $this->load->view('admin/main', $this->data);
    }

    function add()
    {
        canMenu('confignew/add');
        $this->data['temp'] = 'admin/config/add';
        $this->load->view('admin/main', $this->data);
    }

    function edit()
    {
        $namecf = $this->uri->rsegment('3');
        $this->data['namecf'] = $namecf;
        $plat = $this->uri->rsegment('4');
        $this->data['plat'] = $plat;
        $id = $this->uri->rsegment('5');
        $this->data['id'] = $id;
        $this->data['temp'] = 'admin/config/testconfig';
        $this->load->view('admin/main', $this->data);
    }



    function listconfig()
    {
        canMenu('confignew/listconfig');
       // $list = $this->gameconfig_model->get_list_game_config();
      //  $this->data['list'] = $list;
        $this->data['temp'] = 'admin/config/listconfignew';
        $this->load->view('admin/main', $this->data);
    }

    function listconfigajax()
    {
        canMenu('confignew/listconfig');
        $datainfo = file_get_contents($this->config->item('api_backend') . '?c=601&pf=' . "" . '&nm=' . "");
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function successeditslotajax()
    {
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $actions = $action + 1;
        $datainfo =  $this->get_data_curl($this->config->item('change-config') . '?action=' .$actions. '&data='.$message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function editslot()
    {
        $this->data['temp'] = 'admin/config/detailconfigslot';
        $this->load->view('admin/main', $this->data);
    }

    function editslotajax()
    {
        $action = $this->input->post('t');
        $datainfo = file_get_contents($this->config->item('change-config') . '?action=' .$action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function successeditslothandleajax()
    {
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $actions = $action + 1;
        $datainfo =  $this->get_data_curl($this->config->item('admin-handle') . '?action=' .$actions. '&data='.$message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function editslothandle()
    {
        $this->data['temp'] = 'admin/config/detailconfigslothandle';
        $this->load->view('admin/main', $this->data);
    }

    function editslothandleajax()
    {
        $action = $this->input->post('t');
        $datainfo = file_get_contents($this->config->item('admin-handle') . '?action=' .$action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function successedittlmnajax()
    {
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $actions = $action + 1;
        $datainfo =  $this->get_data_curl($this->config->item('admin-handle1') . '?action=' .$actions. '&data='.$message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function edittlmn()
    {
        $this->data['temp'] = 'admin/config/detailconfigtlmn';
        $this->load->view('admin/main', $this->data);
    }

    function edittlmnajax()
    {
        $action = $this->input->post('t');
        $datainfo = file_get_contents($this->config->item('admin-handle1') . '?action=' .$action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function editxdajax()
    {
        $action = $this->input->post('t');
        $datainfo = file_get_contents($this->config->item('admin-handle3') . '?action=' .$action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function successedittlmnhandleajax()
    {
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $actions = $action + 1;
        $datainfo =  $this->get_data_curl($this->config->item('change-config1') . '?action=' .$actions. '&data='.$message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function edittlmnhandle()
    {
        $this->data['temp'] = 'admin/config/detailconfigtlmnhandle';
        $this->load->view('admin/main', $this->data);
    }

    function edittlmnhandleajax()
    {
        $action = $this->input->post('t');
        $datainfo = file_get_contents($this->config->item('change-config1') . '?action=' .$action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function configgame()
    {
        canMenu('confignew/configgame');
        $this->data['temp'] = 'admin/config/listconfiggame';
        $this->load->view('admin/main', $this->data);
    }

    function successeditminigameajax()
    {
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $actions = $action + 1;
        $datainfo =  $this->get_data_curl($this->config->item('change-config2') . '?action=' .$actions. '&data='.$message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function editminigame()
    {
        $this->data['temp'] = 'admin/config/detailconfigminigame';
        $this->load->view('admin/main', $this->data);
    }

    function editminigameajax()
    {
        $action = $this->input->post('t');
        $datainfo = file_get_contents($this->config->item('change-config2') . '?action=' .$action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function successeditminigamehandleajax()
    {
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $actions = $action + 1;
        $datainfo =  $this->get_data_curl($this->config->item('admin-handle2') . '?action=' .$actions. '&data='.$message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function successEditTaiXiuHandleAjax()
    {
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $datainfo = $this->get_data_curl($this->config->item('admin-handle2') . '?action=' . $action . '&data=' . $message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function editminigamehandle()
    {
        $this->data['temp'] = 'admin/config/detailconfigminigamehandle';
        $this->load->view('admin/main', $this->data);
    }

    function edittaixiuhandle()
    {
        $this->data['temp'] = 'admin/config/detailconfigtaixiuhandle';
        $this->load->view('admin/main', $this->data);
    }

    function editnohutaixiu()
    {
        $this->data['temp'] = 'admin/config/detailconfignohutaixiu';
        $this->load->view('admin/main', $this->data);
    }

    function editminigamehandleajax()
    {
        $action = $this->input->post('t');
        $datainfo = file_get_contents($this->config->item('admin-handle2') . '?action=' .$action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function editajax()
    {
        $configpf = $this->input->post('configpf');
        $nmconfig = $this->input->post('nmconfig');

        $datainfo = file_get_contents($this->config->item('api_backend') . '?c=601&pf=' . $configpf . '&nm=' . $nmconfig);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function successeditajax()
    {
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $idconfig = $this->input->post('idconfig');
        $valueconfig = urlencode($this->input->post('valueconfig'));
        $versionconfig = $this->input->post('versionconfig');
        $configpf = $this->input->post('configpf');

        $datainfo = file_get_contents($this->config->item('api_backend') . '?c=603&gid=' . $idconfig . '&gv=' . $valueconfig . '&v=' . $versionconfig . '&pf=' . $configpf);
        if (isset($datainfo)) {
            $data = array(
                'account_name' => $configpf,
                'username' => $admin_info->UserName,
                'action' => "Sửa config",
            );
            $this->logadmin_model->create($data);
            echo $datainfo;

        } else {
            echo "Bạn không được hack";
        }
    }

    function configajax()
    {
        $datainfo = file_get_contents($this->config->item('api_url') . '?c=7');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function editxdhandle()
    {
        canMenu("confignew/configgame");
        $this->data['temp'] = 'admin/config/detailconfigxd';
        $this->load->view('admin/main', $this->data);
    }

    function successeditxdajax()
    {
        canMenu("confignew/configgame");
        $action = $this->input->post('t');
        $message = urlencode($this->input->post('message'));
        $actions = $action + 1;
        $datainfo =  $this->get_data_curl($this->config->item('admin-handle3') . '?action=' .$actions. '&data='.$message);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }
//    function config1ajax()
//    {
//        $datainfo = file_get_contents($this->config->item('api_url2') . '?c=7');
//        if (isset($datainfo)) {
//            echo $datainfo;
//        } else {
//            echo "Bạn không được hack";
//        }
//    }
//    function config2ajax()
//    {
//        $datainfo = file_get_contents($this->config->item('api_url3') . '?c=7');
//        if (isset($datainfo)) {
//            echo $datainfo;
//        } else {
//            echo "Bạn không được hack";
//        }
//    }
//    function config3ajax()
//    {
//        $datainfo = file_get_contents($this->config->item('api_url4') . '?c=7');
//        if (isset($datainfo)) {
//            echo $datainfo;
//        } else {
//            echo "Bạn không được hack";
//        }
//    }
}