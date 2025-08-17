<?php

class Usergame extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('usergame_model');
        $this->load->model('logadmin_model');
        $this->load->model('actionadmin_model');
        $this->load->library('paginationlib');

        //      fix error load library name
        $this->load->library('CSVReader');
    }

    /*
     * Lay danh sach admin
     */
    function index()
    {
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        $this->data['temp'] = 'admin/usergame/index';
        $this->load->view('admin/main', $this->data);
    }

    function indexajax()
    {
        $username = urlencode($this->input->post("username"));
        $nickname = urlencode($this->input->post("nickname"));
        $phone = urlencode($this->input->post("phone"));
        $fieldname = $this->input->post("fieldname");
        $timkiemtheo = $this->input->post("timkiemtheo");
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $typetaikhoan = $this->input->post("typetaikhoan");
        $pages = $this->input->post("pages");
        $record = $this->input->post("record");
        $taikhoanbot = $this->input->post("taikhoanbot");
        $typetk = $this->input->post("typetk");
        $email = $this->input->post("email");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=104&un=' . $username
            . '&nn=' . $nickname . '&m=' . $phone . '&fd=' . $fieldname . '&srt=' . $timkiemtheo
            . '&ts=' . urlencode($toDate) . '&te=' . urlencode($fromDate) . '&dl=' . $typetaikhoan
            . '&p=' . $pages . '&tr=' . $record . '&bt=' . $taikhoanbot . '&email=' . $email . '&lk=' . $typetk);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function  uservippoint()
    {
        canMenu('usergame/uservippoint');
        $this->data['temp'] = 'admin/usergame/uservippoint';
        $this->load->view('admin/main', $this->data);
    }
    function  uservip()
    {
        $this->data['temp'] = 'admin/usergame/uservip';
        $this->load->view('admin/main', $this->data);
    }
    function  userdaily1()
    {
        canMenu('usergame/userdaily1');
        $this->data['temp'] = 'admin/usergame/userdaily1';
        $this->load->view('admin/main', $this->data);
    }

    function userdaily1ajax()
    {
        $username = urlencode($this->input->post("username"));
        $nickname = urlencode($this->input->post("nickname"));
        $phone = urlencode($this->input->post("phone"));
        $fieldname = $this->input->post("fieldname");
        $timkiemtheo = $this->input->post("timkiemtheo");
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $typetaikhoan = 1;
        $pages = $this->input->post("pages");
        $record = $this->input->post("record");
        $typetk = $this->input->post("typetk");
        $email = $this->input->post("email");

        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=104&un=' . $username . '&nn='
            . $nickname . '&m=' . $phone . '&fd=' . $fieldname . '&srt=' . $timkiemtheo . '&ts=' . urlencode($toDate)
            . '&te=' . urlencode($fromDate) . '&dl=' . $typetaikhoan . '&p=' . $pages . '&tr=' . $record . '&bt=0' . '&email=' . $email . '&lk=' . $typetk);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    //    function  userdaily2()
    //    {
    //        $this->data['temp'] = 'admin/usergame/userdaily2';
    //        $this->load->view('admin/main', $this->data);
    //    }

    //    function  useradmin()
    //    {
    //        $this->data['temp'] = 'admin/usergame/useradmin';
    //        $this->load->view('admin/main', $this->data);
    //    }

    function  uservinplay()
    {
        canMenu('usergame/uservinplay');
        if (!empty($this->input->post("isEx"))) {
            $params = [
                'c' => 104,
                'un' => $this->input->post("username") ?? '',
                'nn' => $this->input->post("nickname") ?? '',
                'm' => $this->input->post("phone") ?? '',
                'fd' => $this->input->post("fieldname") ?? '',
                'ts' => $this->input->post("fromDate"),
                'te' => $this->input->post("toDate"),
                'dl' => 0,
                'bt' => 0,
                'p' => 1,
                'srt' => '',
                'tr' => 5000,
                'email' => $this->input->post("email") ?? '',
                'lk' => $this->input->post("typetk") ?? '',
                'rc' => $this->input->post("refcode") ?? '',
            ];
            $data = $this->getDataUser($params);
            $this->csv_download(['User name', 'Phone', 'Email', 'Ngày đăng ký'], $data, ['username', 'mobile', 'email', 'createTime'], date('Y-m-d') . '_export.csv');
        }
        $this->data['temp'] = 'admin/usergame/uservinplay';
        $this->load->view('admin/main', $this->data);
    }

    public function getDataUser($params)
    {
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $response = $this->get_data_curl($endPoint);
            if (empty($response)) {
                return;
            }
            $data = json_decode($response, true);
            if (empty($data['success']) || empty($data['totalRecord'])) {
                return;
            }
            return $data['transactions'];
        } catch (\Exception $e) {
            log_message('error', 'Caught exception getDataUser : ' . $e->getMessage());
            return;
        }
    }

    function uservinplayajax()
    {
        $username = urlencode($this->input->post("username"));
        $nickname = urlencode($this->input->post("nickname"));
        $phone = urlencode($this->input->post("phone"));
        $fieldname = $this->input->post("fieldname");
        $timkiemtheo = $this->input->post("timkiemtheo");
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $typetaikhoan = 0;
        $pages = $this->input->post("pages");
        $record = $this->input->post("record");
        $typetk = $this->input->post("typetk");
        $email = $this->input->post("email");
        $refcode = $this->input->post("refcode");


        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=104&un=' . $username . '&nn='
            . $nickname . '&m=' . $phone . '&fd=' . $fieldname . '&srt=' . $timkiemtheo . '&ts=' . urlencode($fromDate)
            . '&te=' . urlencode($toDate) . '&dl=' . $typetaikhoan . '&p=' . $pages . '&tr=' . $record . '&bt=0' .
            '&email=' . $email . '&lk=' . $typetk . '&rc=' . $refcode);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function alertUserAgentCodeAjax()
    {
        canMenu('usergame/uservinplay');
        $params = [
            'c' => 9430,
            'rc' => $this->input->post("cd"),
            'nn' => $this->input->post("nn"),
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception alertUserAgentCodeAjax : ' . $e->getMessage());
            return;
        }
    }

    function pwd_uservinplayajax()
    {
        $username = urlencode($this->input->post("reason"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=9101&nn=' . $username . '&r=true&b=0');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function  userbot()
    {
        canMenu('usergame/userbot');
        $this->data['temp'] = 'admin/usergame/userbot';
        $this->load->view('admin/main', $this->data);
    }

    function userbotajax()
    {
        $username = urlencode($this->input->post("username"));
        $nickname = urlencode($this->input->post("nickname"));
        $phone = urlencode($this->input->post("phone"));
        $fieldname = $this->input->post("fieldname");
        $timkiemtheo = $this->input->post("timkiemtheo");
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $typetaikhoan = $this->input->post("typetaikhoan");
        $pages = $this->input->post("pages");
        $record = $this->input->post("record");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=104&un=' . $username .
            '&nn=' . $nickname . '&m=' . $phone . '&fd=' . $fieldname . '&srt=' . $timkiemtheo .
            '&ts=' . urlencode($toDate) . '&te=' . urlencode($fromDate) . '&dl=' . $typetaikhoan .
            '&p=' . $pages . '&tr=' . $record . '&bt=1' . '&email=&lk=0');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function userlogin()
    {
        canMenu('usergame/userlogin');
        $this->data['temp'] = 'admin/usergame/userlogin';
        $this->load->view('admin/main', $this->data);
    }

    function userloginajax()
    {

        $nickname = urlencode($this->input->post("nickname"));
        $iplogin = urlencode($this->input->post("iplogin"));
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $status = $this->input->post("status");
        $pages = $this->input->post("pages");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=109&nn=' . $nickname . '&ip=' . $iplogin . '&ts=' . urlencode($toDate) . '&te=' . urlencode($fromDate) . '&type=' . $status . '&p=' . $pages);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    //    function topcaothu()
    //    {
    //
    //        $this->data['temp'] = 'admin/usergame/topcaothu';
    //        $this->load->view('admin/main', $this->data);
    //    }
    //
    //    function topcaothuajax()
    //    {
    //        $display = $this->input->post("display");
    //        $money = $this->input->post("money");
    //        $date = $this->input->post("date");
    //        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=13&n=' . $display . '&mt=' . $money . '&date=' . $date);
    //        if (isset($datainfo)) {
    //            echo $datainfo;
    //        } else {
    //            echo "Bạn không được hack";
    //        }
    //    }

    function topuserbot()
    {
        canMenu('usergame/topuserbot');
        $this->data['temp'] = 'admin/usergame/topuserbot';
        $this->load->view('admin/main', $this->data);
    }

    function topuserbotajax()
    {
        $display = $this->input->post("display");
        $gamename = $this->input->post("gamename");
        $toDate = $this->input->post("toDate");
        $fromDate = $this->input->post("fromDate");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=12&n=' . $display . '&ac=' . $gamename . '&ts=' . $toDate . '&te=' . $fromDate);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function sendmail()
    {

        $this->data['temp'] = 'admin/usergame/sendmail';
        $this->load->view('admin/main', $this->data);
    }


    function lockuser()
    {
        $nickname = $this->uri->rsegment('3');
        $status = $this->uri->rsegment('4');

        $allstatus = str_repeat('0', 40 - strlen(decbin($status))) . decbin($status);
        $dao = $this->mb_strrev($allstatus, $encoding = "utf-8");
        $this->data['daochuoi'] = $dao;
        $this->data['nickname'] = $nickname;
        $this->data['status'] = $status;
        $this->data['temp'] = 'admin/usergame/lockuser';
        $this->load->view('admin/main', $this->data);
    }

    function messlockuser()
    {
        $this->session->set_flashdata('message', 'Câp  nhật thành công');
    }

    function lockuserajax()
    {
        $nickname = $this->input->post("nickname");
        $action = $this->input->post("action");
        $type = $this->input->post("type");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=105&nn=' . $nickname . '&ac=' . $action . '&type=' . $type);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function loglockuser()
    {
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $lydo = $this->input->post("txtlydo");
        $nickname = $this->input->post("nickname");
        $txtaction = $this->input->post("txtaction");
        $statuslock = $this->input->post("statuslock");
        $data = array(
            'reason' => $lydo,
            'account_name' => $nickname,
            'username' => $admin_info->UserName,
            'action' => $txtaction,
            'status' => $statuslock,
        );
        $this->logadmin_model->create($data);
    }

    function upload()
    {
        if (file_exists(FCPATH . "public/admin/uploads/nickname.csv") != false) {
            $this->load->library('csvreader');
            $result = $this->csvreader->parse_file(public_url('admin/uploads/nickname.csv'));
            $listnn = array();
            foreach ($result as $row) {
                if ($row["Nickname"]) {
                    array_push($listnn, $row["Nickname"]);
                }
            }
            $this->data['listnn'] = implode(',', $listnn);
            echo json_encode(array(array("er" => 0), array("nn" => implode(',', $listnn))));
        } else {
            echo json_encode(array(array("er" => 1)));
        }
    }

    function search_usergame()
    {
        $query_array = array(
            'name' => $this->input->post('name'),
            'nickname' => $this->input->post('nickname'),
            'sdt' => $this->input->post('sdt')

        );
        $query_id = $this->input->save_query($query_array);
        redirect("admin/usergame/index/$query_id");
    }

    function detailgc()
    {
        $nickname = $this->uri->rsegment('3');
        $this->data['nickname'] = $nickname;
        $this->load->view('admin/usergame/detailgc', $this->data);
    }

    function detailgcajax()
    {
        $nickname = $this->input->post("nickname");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=135&nn=' . $nickname . '&p=1');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function resetpw()
    {
        $this->data['temp'] = 'admin/usergame/resetpw';
        $this->load->view('admin/main', $this->data);
    }

    function resetpwajax()
    {
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $nickname = $this->input->post("nickname");
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=14&nn=' . $nickname);
        if (isset($datainfo)) {
            $data = array(
                'account_name' => $nickname,
                'username' => $admin_info->UserName,
                'action' => "Reset password"
            );
            $this->logadmin_model->create($data);
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    //    function updateinfo()
    //    {
    //        $this->data['temp'] = 'admin/usergame/updateinfo';
    //        $this->load->view('admin/main', $this->data);
    //    }
    //
    //    function updateinfoajax()
    //    {
    //        $admin_login = $this->session->userdata('user_id_login');
    //        $admin_info = $this->admin_model->get_info($admin_login);
    //        $nickname = urlencode($this->input->post("nickname"));
    //        $birthday = $this->input->post("birthday");
    //        $gioitinh = $this->input->post("gioitinh");
    //        $address = urlencode($this->input->post("address"));
    //        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=15&nn=' . $nickname . '&bd=' . $birthday . '&gd=' . $gioitinh . '&address=' . $address);
    //        if (isset($datainfo)) {
    //            if ($datainfo == 0) {
    //                $data = array(
    //                    'account_name' => $nickname,
    //                    'username' => $admin_info->UserName,
    //                    'action' => "Cập nhập thông tin tài khoản",
    //                );
    //                $this->logadmin_model->create($data);
    //            }
    //            echo $datainfo;
    //        } else {
    //            echo "Bạn không được hack";
    //        }
    //    }

    //    function congxu()
    //    {
    //        $this->data['temp'] = 'admin/usergame/congxu';
    //        $this->load->view('admin/main', $this->data);
    //    }
    //
    //    function congxuajax()
    //    {
    //        $admin_login = $this->session->userdata('user_id_login');
    //        $admin_info = $this->admin_model->get_info($admin_login);
    //        $nickname = urlencode($this->input->post("nickname"));
    //        $money = $this->input->post("money");
    //        $reason = urlencode($this->input->post("reason"));
    //        $otp = urlencode($this->input->post("otp"));
    //        $typeotp = $this->input->post("typeotp");
    //        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=100&nn=' . $nickname . '&mn=' . $money . '&mt=' . "xu" . '&nns=' . $admin_info->FullName . '&rs=' . $reason . '&otp=' . $otp . '&type=' . $typeotp);
    //        $data = json_decode($datainfo);
    //        if (isset($data->success)) {
    //            if ($data->success == true) {
    //                if ($data->errorCode == 0) {
    //                    $data = array(
    //                        'account_name' => $nickname,
    //                        'username' => $admin_info->UserName,
    //                        'action' => "Cộng xu",
    //                        'money' => $money,
    //                        'money_type' => 'Xu'
    //                    );
    //                    $this->logadmin_model->create($data);
    //                    echo json_encode("1");
    //                }
    //            } else {
    //                if ($data->errorCode == 1001) {
    //                    echo json_encode("2");
    //                } elseif ($data->errorCode == 1002) {
    //                    echo json_encode("3");
    //                } elseif ($data->errorCode == 1008) {
    //                    echo json_encode("4");
    //                } elseif ($data->errorCode == 1021) {
    //                    echo json_encode("5");
    //                } elseif ($data->errorCode == 2001) {
    //                    echo json_encode("6");
    //                }
    //            }
    //
    //        } else {
    //            echo "Bạn không được hack";
    //        }
    //
    //    }

    //    function truxuajax()
    //    {
    //        $admin_login = $this->session->userdata('user_id_login');
    //        $admin_info = $this->admin_model->get_info($admin_login);
    //        $nickname = urlencode($this->input->post("nickname"));
    //        $money = $this->input->post("money");
    //        $reason = urlencode($this->input->post("reason"));
    //        $otp = urlencode($this->input->post("otp"));
    //        $typeotp = $this->input->post("typeotp");
    //        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=100&nn=' . $nickname . '&mn=' . $money . '&mt=' . "xu" . '&nns=' . $admin_info->FullName . '&rs=' . $reason . '&otp=' . $otp . '&type=' . $typeotp);
    //        $data = json_decode($datainfo);
    //        if (isset($data->success)) {
    //            if ($data->success == true) {
    //                if ($data->errorCode == 0) {
    //                    $data = array(
    //                        'account_name' => $nickname,
    //                        'username' => $admin_info->UserName,
    //                        'action' => "Trừ xu",
    //                        'money' => $money,
    //                        'money_type' => 'Xu'
    //                    );
    //                    $this->logadmin_model->create($data);
    //                    echo json_encode("1");
    //                }
    //            } else {
    //                if ($data->errorCode == 1001) {
    //                    echo json_encode("2");
    //                } elseif ($data->errorCode == 1002) {
    //                    echo json_encode("3");
    //                } elseif ($data->errorCode == 1008) {
    //                    echo json_encode("4");
    //                } elseif ($data->errorCode == 1021) {
    //                    echo json_encode("5");
    //                } elseif ($data->errorCode == 2001) {
    //                    echo json_encode("6");
    //                }
    //            }
    //
    //        } else {
    //            echo "Bạn không được hack";
    //        }
    //
    //    }


    function logchangemobile()
    {
        canMenu('usergame/logchangemobile');
        $this->data['temp'] = 'admin/usergame/logchangemobile';
        $this->load->view('admin/main', $this->data);
    }

    function logchangemobileajax()
    {
        $nickname = urlencode($this->input->post("nickname"));
        $mobilenew = urlencode($this->input->post("mobilenew"));
        $mobileold = urlencode($this->input->post("mobileold"));
        $pages = $this->input->post("pages");
        $datainfo = $this->get_data_curl($this->config->item('api_backend2') . '?c=509&nn=' . $nickname . '&m=' . $mobilenew . '&mo=' . $mobileold . '&p=' . $pages);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }
    //    function checkinfo()
    //    {
    //
    //        date_default_timezone_set('Asia/Ho_Chi_Minh');
    //        $start_time = null;
    //        $end_time = null;
    //        if ($this->input->post('toDate')) {
    //            $start_time = $this->input->post('toDate');
    //        }
    //
    //        if ($this->input->post('fromDate')) {
    //            $end_time = $this->input->post('fromDate');
    //        }
    //
    //        if ($start_time === null) {
    //            $start_time = date('d-m-Y');
    //        }
    //        if ($end_time === null) {
    //            $end_time = date('d-m-Y');
    //        }
    //        $this->data['start_time'] = $start_time;
    //        $this->data['end_time'] = $end_time;
    //        $this->data['error'] = "";
    //        if ($this->input->post("ok")) {
    //            if (file_exists('public/admin/uploads/checkinfo.csv')) {
    //                unlink('public/admin/uploads/checkinfo.csv');
    //            }
    //            $temp = explode(".", $_FILES["filexls"]["name"]);
    //            $extension = end($temp);
    //            if ($extension == "csv") {
    //                $config = array("");
    //                $config['upload_path'] = './public/admin/uploads';
    //                $config['allowed_types'] = '*';
    //                $config['max_size'] = 1024 * 8;
    //                $config['overwrite'] = TRUE;
    //                $config['file_name'] = 'checkinfo';
    //                $this->load->library('upload', $config);
    //                $this->upload->initialize($config);
    //
    //                if (!$this->upload->do_upload('filexls')) {
    //                    $error = array('error' => $this->upload->display_errors());
    //                    $this->data['error'] = "Bạn chưa chọn file hoặc không được phân quyền";
    //
    //                } else {
    //                    $this->data['error'] = "";
    //                    $data = array('upload_data' => $this->upload->data());
    //
    //                    $this->data['error'] = "Upload file thành công";
    //                    //
    //
    //                }
    //            } else {
    //                $this->data['error'] = "Bạn chưa chọn file hoặc không chọn đúng file csv";
    //            }
    //
    //        }
    //        if (file_exists(FCPATH . "public/admin/uploads/checkinfo.csv") != false) {
    //            $this->load->library('csvreader');
    //            $result = $this->csvreader->parse_file(public_url('admin/uploads/checkinfo.csv'));
    //            $listnn = array();
    //            foreach ($result as $row) {
    //                if (isset($row["Nickname"])) {
    //                    array_push($listnn, $row["Nickname"]);
    //                }
    //
    //            }
    //            $this->data['listnn'] = implode(',', $listnn);
    //        } else {
    //            $this->data['listnn'] = "";
    //        }
    //        $this->data['temp'] = 'admin/usergame/checkinfo';
    //        $this->load->view('admin/main', $this->data);
    //    }
    //
    //    function checkinfoajax()
    //    {
    //        $nickname = urlencode($this->input->post("nickname"));
    //        $todate = urlencode($this->input->post("todate"));
    //        $fromdate = urlencode($this->input->post("fromdate"));
    //        $datainfo = $this->get_data_curl($this->config->item('api_backend2') . '?c=606&nn=' . $nickname . '&ts=' . $todate . '&te=' .$fromdate);
    //
    //
    //        if (isset($datainfo)) {
    //            echo $datainfo;
    //        } else {
    //            echo "Bạn không được hack";
    //        }
    //
    //    }

    function setjackpot()
    {
        canMenu('usergame/setjackpot');
        $this->data['temp'] = 'admin/usergame/setjackpot';
        $this->load->view('admin/main', $this->data);
    }

    function setjackpotajax()
    {
        canMenu('usergame/setjackpot');
        $nickname = urlencode($this->input->post("nickname"));
        $gameid = urlencode($this->input->post("gameid"));
        $betvalue = urlencode($this->input->post("betvalue"));
        $action = 0;
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=730&nickName=' . $nickname . '&gameID=' . $gameid . '&betValue=' . $betvalue . '&action=' . $action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function deletejackpotajax()
    {
        $nickname = urlencode($this->input->post("nickname"));
        $gameid = urlencode($this->input->post("gameid"));
        $betvalue = urlencode($this->input->post("betvalue"));
        $action = 1;
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=730&nickName=' . $nickname . '&gameID=' . $gameid . '&betValue=' . $betvalue . '&action=' . $action);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function listjackpotajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=729');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function setuserwin()
    {
        canMenu('usergame/setuserwin');
        $this->data['temp'] = 'admin/usergame/setuserwin';
        $this->load->view('admin/main', $this->data);
    }

    function listuserwinajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=8904&action=0');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function setuserwinajax()
    {
        canMenu('usergame/setuserwin');
        $params = [
            'c' => 8904,
            'nick_name' => $this->input->post("nickname"),
            'action' => 1,
            'ut' => $this->input->post("ut"),
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        $result = $this->get_data_curl($endPoint);

        if (isset($result)) {
            echo $result;
            return;
        }
        echo "Bạn không được hack";
        return;
    }

    function deleteuserwinajax()
    {
        $nickname = urlencode($this->input->post("nickname"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=8904&nick_name=' . $nickname . '&action=2');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function setresulttaixiu()
    {
        canMenu('usergame/setresulttaixiu');
        $this->data['temp'] = 'admin/usergame/setresulttaixiu';
        $this->load->view('admin/main', $this->data);
    }

    function setresulttaixiumd5()
    {
        canMenu('usergame/setresulttaixiumd5');
        $this->data['temp'] = 'admin/usergame/setresulttaixiumd5';
        $this->load->view('admin/main', $this->data);
    }

    function setresultonlytaixiuajax()
    {
        canMenu('usergame/setresulttaixiu');
        $result = urlencode($this->input->post("result"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=8798&result=' . $result);
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function setresult()
    {
        canMenu('usergame/setresult');
        $this->data['temp'] = 'admin/usergame/setresult';
        $this->load->view('admin/main', $this->data);
    }

    function listresulttaixiuajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=732&action=0');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function listresulttaixiumd5ajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=732&action=2');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function listordertaixiu()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=507');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function listordertaixiumd5()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=507&md5=1');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function setresulttaixiuajax()
    {
        canMenu('usergame/setresult');
        $result = urlencode($this->input->post("result"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=731&result=' . $result . '&action=0');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function setresulttaixiumd5ajax()
    {
        canMenu('usergame/setresulttaixiumd5');
        $result = urlencode($this->input->post("result"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=731&result=' . $result . '&action=2');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function deleteresulttaixiuajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=733&action=0');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function deleteresulttaixiumd5ajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=733&action=2');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function listresultbaucuaajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=732&action=1');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function setresultbaucuaajax()
    {
        canMenu('usergame/setresult');
        $result = urlencode($this->input->post("result"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=731&result=' . $result . '&action=1');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function deleteresultbaucuaajax()
    {
        $datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=733&action=1');
        if (isset($datainfo)) {
            echo $datainfo;
        } else {
            echo "Bạn không được hack";
        }
    }

    function syncData()
    {
        canMenu('usergame/syncData');
        $this->data['temp'] = 'admin/usergame/syncData';
        $this->load->view('admin/main', $this->data);
    }

    function syncDataAjax()
    {
        canMenu('usergame/syncData');
        $params = [
            'c' => 76,
            'gn' => $this->input->post("gn"),
            'ft' => $this->input->post("ft"),
            'et' => $this->input->post("et"),
        ];
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo empty($data) ? "" : $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception syncDataAjax : ' . $e->getMessage());
            return;
        }
    }

    function jackpotCache()
    {
        canMenu('usergame/jackpotCache');
        $this->data['temp'] = 'admin/usergame/jackpotCache';
        $this->load->view('admin/main', $this->data);
    }

    function ajaxJackpotCache()
    {
        $action = $this->input->post("action");
        $params = [
            'c' => 1992,
            'delete' => $action,
            'cn' => $this->input->post("cn"), //'cacheSetUserJackpot',
            'k' => $this->input->post("k"),
        ];
        if ($action == 2) {
            $params['value'] = $this->input->post("value");
        }
        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception ajaxJackpotCache : ' . $e->getMessage());
        }
        return;
    }

    function resetpassword()
    {
        $username = $this->input->post("username");
        $params = [
            'c' => 16,
            'nn' => $username
        ];

        $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
        try {
            $data = $this->get_data_curl($endPoint);
            echo $data;
            return;
        } catch (\Exception $e) {
            log_message('error', 'Caught exception resetpassword : ' . $e->getMessage());
        }
        return;
    }
}
