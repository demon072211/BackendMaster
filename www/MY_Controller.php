<?php

class MY_Controller extends CI_Controller
{
    //bien gui du lieu sang ben view
    public $data = array();

    function __construct()
    {
        //ke thua tu CI_Controller
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $controller = $this->uri->segment(1);
        // ini_set('max_execution_time', 0);

        switch ($controller) {
            case 'admin': {
                    $linkapi = $this->config->item('api_backend');
                    $this->data['linkapi'] = $linkapi;
                    $api = $this->config->item('api');
                    $this->data['api'] = $api;
                    $this->load->helper('language');
                    $this->lang->load('admin/common');
                    $admin_login = $this->session->userdata('user_id_login');
                    $accesstoken = $this->session->userdata('accessToken');
                    $this->data['access'] = $accesstoken;;
                    $this->data['login'] = $admin_login;
                    $this->load->model('menu_model');
                    $this->load->library('curl');
                    $this->load->helper('admin');
                    if ($admin_login) {

                        $this->load->model('admin_model');
                        $this->load->model('userrole_model');
                        $this->load->model('menurole_model');
                        $admin_info = $this->admin_model->get_info($admin_login);
                        $this->data['admin_info'] = $admin_info;
                        $link1 = $this->uri->rsegment('1');
                        $link2 = $this->uri->rsegment('2');
                        if ($link2 != "index") {
                            if ($this->menu_model->get_menu_id($link1 . '/' . $link2)) {
                                $menu_id = $this->menu_model->get_menu_id($link1 . '/' . $link2);
                                $this->data['role'] = $this->get_role_user($admin_login, $menu_id[0]->id);
                            } else {
                                $this->data['role'] = false;
                            }
                        } else {
                            if ($this->menu_model->get_menu_id($link1)) {
                                $menu_id = $this->menu_model->get_menu_id($link1);
                                $this->data['role'] = $this->get_role_user($admin_login, $menu_id[0]->id);
                            } else {
                                $this->data['role'] = false;
                            }
                        }
                        $list = $this->GetMenuLeftByUser($admin_info->ID);
                        $this->data['menu_list'] = $list;
                    }
                    $this->_check_login();
                    break;
                }
                /*case'tranfer':
            {
                $this->load->helper('language');
                $this->lang->load('tranfer/common');
                $this->load->helper('tranfer');
                $this->_check_login_tranfer();

                break;
            }
            default:
            {
                $this->load->helper('news_helper');
                $this->load->model('news_model');
                $this->load->model('tag_model');
                $this->load->model('catalog_model');
                $input = array();
                $input1 = array();
                $input1['order'] = array('sort_order', 'ASC');
                $catalog_list = $this->catalog_model->get_list($input1);
                $tag_list = $this->tag_model->get_list($input1);
                $this->data['catalog_list'] = $catalog_list;
                $this->data['tag_list'] = $tag_list;
                $input['limit'] = array(5, 0);
                $news_list = $this->news_model->get_list($input);
                $this->data['news_list'] = $news_list;

            }*/
        }
        $this->runMiddlewares();
    }

    protected function middleware()
    {
        return array('log_action');
    }

    protected function runMiddlewares()
    {
        $this->load->helper('inflector');
        $middlewares = $this->middleware();
        foreach ($middlewares as $middleware) {
            $middlewareArray = explode('|', str_replace(' ', '', $middleware));
            $middlewareName = $middlewareArray[0];
            $runMiddleware = true;
            if (isset($middlewareArray[1])) {
                $options = explode(':', $middlewareArray[1]);
                $type = $options[0];
                $methods = explode(',', $options[1]);
                if ($type == 'except') {
                    if (in_array($this->router->method, $methods)) {
                        $runMiddleware = false;
                    }
                } else if ($type == 'only') {
                    if (!in_array($this->router->method, $methods)) {
                        $runMiddleware = false;
                    }
                }
            }
            $filename = ucfirst(camelize($middlewareName)) . 'Middleware';
            if ($runMiddleware == true) {
                if (file_exists(APPPATH . 'middlewares/' . $filename . '.php')) {
                    require APPPATH . 'middlewares/' . $filename . '.php';
                    $ci = &get_instance();
                    $object = new $filename($this, $ci);
                    $object->run();
                    $this->middlewares[$middlewareName] = $object;
                } else {
                    if (ENVIRONMENT == 'development') {
                        show_error('Unable to load middleware: ' . $filename . '.php');
                    } else {
                        show_error('Sorry something went wrong.');
                    }
                }
            }
        }
    }

    /*
     * Kiem tra trang thai dang nhap cua admin
     */
    private function _check_login()
    {
        $controller = $this->uri->rsegment('1');
        $controller = strtolower($controller);

        $login = $this->session->userdata('user_id_login');
        //neu ma chua dang nhap,ma truy cap 1 controller khac login

        if (!$login && $controller != 'login') {
            redirect(admin_url('login'));
        }

        //neu ma admin da dang nhap thi khong cho phep vao trang login nua.
        if ($login && $controller == 'login') {
            redirect(admin_url('home'));
        }
    }

    function GetMenuLeftByUser($user_id)
    {
        $this->load->model('admin_model');
        $this->load->model('userrole_model');
        $this->load->model('menurole_model');
        $str = "";
        //lấy group_id theo userid
        $list_group_id = $this->userrole_model->get_list_role_by_userid($user_id);

        if (!empty($list_group_id)) {
            foreach ($list_group_id as $group_id_item) {
                //lấy danh sách các menu_id theo group id
                $menu_list = $this->menurole_model->get_list_menu_by_group($group_id_item->Group_ID);

                $elements_list = [];
                foreach ($menu_list as $item) {
                    $baseUri = '';
                    if ($this->uri->rsegment('1')) {
                        $baseUri .= $this->uri->rsegment('1');
                    }
                    if ($this->uri->rsegment('2')) {
                        $baseUri .= '/' . $this->uri->rsegment('2');
                    }
                    $baseUri = strtolower($baseUri);

                    if ($item->Parrent_ID == -1) {
                        // menu
                        if (strtolower($item->Link) == $baseUri) {
                            $elements_list[$item->id] = [
                                "parent" => "<a class='active'><i class='fa fa-gamepad'></i><span> $item->Name </span></a>",
                                "child" => [],
                            ];
                        } else {
                            $elements_list[$item->id] = [
                                "parent" => "<a><i class='fa fa-gamepad'></i><span> $item->Name </span></a>",
                                "child" => [],
                            ];
                        }
                    } else {
                        // sub menu
                        if (!empty($elements_list[$item->Parrent_ID])) {
                            if (strtolower($item->Link) == $baseUri) {
                                $elements_list[$item->Parrent_ID]["parent"] = str_replace("<a", "<a class='active'", $elements_list[$item->Parrent_ID]["parent"]);
                                $elements_list[$item->Parrent_ID]["child"][] = "<li class='active'><a class='active' href='" . admin_url($item->Link) . "'>$item->Name</a></li>";
                            } else {
                                $elements_list[$item->Parrent_ID]["child"][] = "<li><a href='" . admin_url($item->Link) . "'>$item->Name</a></li>";
                            }
                        } else {
                            echo "for error parent menu";
                            var_dump($item);
                        }
                    }
                }

                foreach ($elements_list as $element) {
                    $str .= "<li class='sidebar-dropdown'> "
                        . $element["parent"]
                        . "<div class='sidebar-submenu'><ul>"
                        . join("", $element["child"])
                        . "</ul></div>" .
                        "</li>";
                }
            }
        }
        return $str;
    }

    function Check_Url_Admin($current_url)
    {
        $this->load->model('accesslink_model');
        //lấy id của user đăng nhập
        $admin_login = $this->session->userdata('user_id_login');
        //lấy tất cả các link của user đó
        $list_link = $this->accesslink_model->get_list_linkacess_userid($admin_login);

        //lấy url hiện tại
        $stack = array();
        if (!empty($list_link)) {
            foreach ($list_link as $item) {
                array_push($stack, $item->Link);
            }
        }
        if (in_array($current_url, $stack)) {
            return true;
        } else {
            return false;
        }
    }

    function create_slug($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    public function init_pagination($base_url, $total_rows, $per_page = 100, $segment)
    {
        $ci = &get_instance();
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = $segment;
        $config['next_link'] = 'Trang kế tiếp';
        $config['prev_link'] = 'Trang trước';
        $ci->pagination->initialize($config);
        return $config;
    }

    function dateDiff($start, $end)
    {
        date_default_timezone_set('Asia/Bangkok');
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }


    function rand_string($length)
    {
        $str = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

    function mb_strrev($str, $encoding = "utf-8")
    {
        $ret = "";
        for ($i = mb_strlen($str, $encoding) - 1; $i >= 0; $i--) {
            $ret .= mb_substr($str, $i, 1, $encoding);
        }
        return $ret;
    }

    function get_role_user($user_id, $menu_id)
    {
        $this->load->model('userrole_model');
        $role = $this->userrole_model->get_list_role_menu($user_id, $menu_id);
        return $role;
    }

    function get_data_curl($url)
    {
        $ch = curl_init();

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        // execute post
        $result = curl_exec($ch);

        // close connection
        curl_close($ch);

        return $result;
    }

    function get_client_ip()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    function get_web_page($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING => "",       // handle all encodings
            CURLOPT_USERAGENT => "spider", // who am i
            CURLOPT_AUTOREFERER => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT => 120,      // timeout on response
            CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $header;
    }

    function logadmingiftcode($ac, $nn, $us, $q, $mo, $ty)
    {
        $data = array(
            'action' => $this->actionadmin($ac),
            'account_name' => $nn,
            'username' => $us,
            'quantity' => $q,
            'money' => $mo,
            'money_type' => $ty
        );
        return $data;
    }

    function actionadmin($count)
    {
        switch ($count) {
            case 1:
                $strresult = "Thêm mới tài khoản đại lý";
                break;
            case 2:
                $strresult = "Sửa thông tin tài khoản đại lý";
                break;
            case 3:
                $strresult = "Xóa tài khoản đại lý";
                break;
            case 4:
                $strresult = "Đổi mật khẩu tài khoản đại lý";
                break;
            case 5:
                $strresult = "Đổi mật khẩu admin đại lý";
                break;
            case 6:
                $strresult = "Tạo kho gift code";
                break;
            case 7:
                $strresult = "Chuyển giftcode cho đại lý";
                break;
            case 8:
                $strresult = "Thêm cầu tài xỉu";
                break;
            case 9:
                $strresult = "Sửa cầu tài xỉu";
                break;
            case 10:
                $strresult = "Xóa cầu tài xỉu";
                break;
            case 11:
                $strresult = "Cộng tiền marketing";
                break;
            case 12:
                $strresult = "Cộng trừ tiền admin";
                break;
            case 13:
                $strresult = "Tạo kho gift code marketing";
                break;
            case 14:
                $strresult = "Chuyển gift code marketing";
                break;
            case 15:
                $strresult = "Tạo kho giftcode minigame";
                break;
            case 16:
                $strresult = "Chuyển giftcode minigame";
                break;
            case 17:
                $strresult = "Tạo kho giftcode vận hành";
                break;
            case 18:
                $strresult = "Chuyển giftcode cho vận hành";
                break;
            case 19:
                $strresult = "Trả thưởng vippoint event";
                break;

            case 20:
                $strresult = "Cộng tiền  cho nhiều tài khoản";
                break;
            case 23:
                $strresult = "Bán Win cho bot";
                break;
            case 24:
                $strresult = "Mua Win cho bot";
                break;
        }
        return $strresult;
    }

    function getEventConfig()
    {
        $params = [
            'c' => '9413',
            'mi' => '-1',
        ];
        try {
            $eventData = $this->get_data_curl($this->config->item('api_backend') . '?' . http_build_query($params));
            if (empty($eventData)) {
                return;
            }
            $eventData = json_decode($eventData, true);
            if (empty($eventData['data'])) {
                return;
            }
            return $eventData['data'];
        } catch (\Exception $e) {
            log_message('error', 'Caught exception getEventConfig : ' . $e->getMessage());
            return;
        }
    }
    function csv_download($header, $data, $arrayMap = [], $filename = "export.csv", $delimiter = ";")
    {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        ob_end_clean();
        $handle = fopen('php://output', 'w');
        fputcsv($handle, $header, $delimiter);
        if (count($arrayMap)) {
            foreach ($data as $value) {
                $row = [];
                foreach ($arrayMap as $item) {
                    $row[] = empty($value[$item]) ? '-' : $value[$item];
                }
                fputcsv($handle, $row, $delimiter);
            }
            fclose($handle);
            exit();
        }

        foreach ($data as $value) {
            fputcsv($handle, $value, $delimiter);
        }
        fclose($handle);
        exit();
    }
}
