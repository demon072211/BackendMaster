<?php

Class Agency extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('usergame_model');
        $this->load->model('logadmin_model');
        $this->load->model('tranfermoney_model');
        $this->load->model('useragent_model');

    }

    function index()
    {
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        $this->data['status'] = $admin_info->Status;
        $input = array();
        $input['where'] = array("ParentID" => -1,"Status"=>"A");
        $list = $this->admin_model->get_list($input);
        $this->data['list1'] = $list;
        $this->data['temp'] = 'admin/agency/index';
        $this->load->view('admin/main', $this->data);
    }

    function add()
    {
        canMenu('agency/add');
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        $this->data['temp'] = 'admin/agency/add';
        $this->load->view('admin/main', $this->data);
    }

    function addadmin()
    {
        $nn = $this->input->post('nickname');
        $ac = $this->input->post('agency_code');
        $info = $this->useragent_model->get_info_admin($nn);
//        $admin_login = $this->session->userdata('user_id_login');
//        $admin_info = $this->useragent_model->get_info($admin_login);
        // insert vao db
        if(isset($info)) {
            $datainfo = $this->get_data_curl($this->config->item('api_backend'). "?c=31&nn=$nn&ac=$ac");
            echo $datainfo; die();

            if (isset($datainfo) && $datainfo->success) {
                $data = array(
                    'nickname' => $this->input->post('nickname'),
                    'key' => $this->input->post('agency_code'),
                    'status' => 'D'
                );

                if ($info != false) {
                    $this->session->set_flashdata('message', 'Tài khoản đã tồn tại');
                    echo json_encode("0");
                    die();
                } else {
                    // $this->logadmin_model->create($this->logadmindata(1, $this->input->post('nickname'), $admin_info->username));
                    $this->useragent_model->create($data);
                    $this->session->set_flashdata('message', ' Bạn thêm người dùng thành công');
                    echo json_encode("2");
                }
            } else {
                echo $datainfo;
            }
        }
    }
    function getinfoajax(){
        $nickname = urlencode($this->input->post('nickname'));
        $datainfo = file_get_contents($this->config->item('api_backend').'?c=102&nn='.$nickname);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
    function daily1()
    {
        $info = $this->admin_model->get_info_admin($this->input->post('username'));
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        if ($info != false) {
            $data = array(
                'dai_ly' => 0
            );
            $this->usergame_model->update($this->input->post('id'), $data);
            foreach ($info as $row) {
                $this->admin_model->delete($row->ID);
                $data1 = array(
                    'action' => "Xóa tài khoản admin đại lý cấp 1",
                    'account_name' => $row->FullName,
                    'username' => $admin_info->UserName
                );
                $this->logadmin_model->create($data1);
            }
            echo json_encode("Bạn trở thành tài khoản thường");
        } else {
            // insert vao db
            $data = array(
                'UserName' => $this->input->post('username'),
                'FullName' => $this->input->post('nickname'),
                'Password' => $this->input->post('password'),
                'Email' => $this->input->post('email'),
                'Phone' => $this->input->post('phonedaily'),
                'Status' => "D",
                'ParentID' => $admin_login,
                'Key'=> $this->rand_string(2),
                'NameAgent'=> $this->input->post('namedaily'),
                'Address' => $this->input->post('addressdaily'),
                'Facebook'=> $this->input->post('facebookdaily')

            );
            $data1 = array(
                'dai_ly' => 1
            );
            $data2 = array(
                'action' => "Thêm tài khoản admin đại lý cấp 1",
                'account_name' => $this->input->post('nickname'),
                'username' => $admin_info->UserName
            );
            $this->logadmin_model->create($data2);
            $this->usergame_model->update($this->input->post('id'), $data1);
            $this->admin_model->create($data);
            echo json_encode("Bạn thêm mới đại lý thành công");
        }
    }

    function daily2()
    {
        $info = $this->admin_model->get_info_admin($this->input->post('username'));
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $input = array();
        $input['where'] = array("ParentID" => $admin_info->ID);
        $total = $this->admin_model->get_total($input);
        if ($info != false) {
            $data = array(
                'dai_ly' => 0
            );
            $this->usergame_model->update($this->input->post('id'), $data);
            foreach ($info as $row) {
                $this->admin_model->delete($row->ID);
                $data1 = array(
                    'action' => "Xóa tài khoản admin đại lý cấp 2",
                    'account_name' => $row->FullName,
                    'username' => $admin_info->UserName
                );
                $this->logadmin_model->create($data1);
            }
            echo json_encode("Bạn trở thành tài khoản thường");
        } else {
            // insert vao db
            $data = array(
                'UserName' => $this->input->post('username'),
                'FullName' => $this->input->post('nickname'),
                'Email' => $this->input->post('email'),
                'Phone' => $this->input->post('mobile'),
                'Status' => "D",
                'ParentID' => $admin_login
            );
            $data1 = array(
                'dai_ly' => 2
            );
            $data2 = array(
                'action' => "Thêm tài khoản admin đại lý cấp 2",
                'account_name' => $this->input->post('nickname'),
                'username' => $admin_info->UserName
            );
            if($total > 4 ){
                echo json_encode("Bạn đã thêm quá 5 đại lý");die();
            }else if($total < 5){
                $this->logadmin_model->create($data2);
                $this->usergame_model->update($this->input->post('id'), $data1);
                $this->admin_model->create($data);
                echo json_encode("Bạn thêm mới đại lý thành công");
            }
        }
    }

    function delete()
    {
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        //lay thong tin cua quan tri vien
        $info = $this->admin_model->get_info($id);
        // var_dump($info->UserName);die();
        if (!$info) {
            $this->session->set_flashdata('message', 'Không tồn tại quản trị viên');
            redirect(admin_url('agency'));
        }
        $infous = $this->usergame_model->get_info_daily($info->UserName);
        foreach ($infous as $us) {
            $data = array(
                'dai_ly' => 0
            );
            $this->usergame_model->update($us->id, $data);
        }
        //thuc hiện xóa

        $data2 = array(
            'action' => "Xóa tài khoản admin đại lý",
            'account_name' => $info->FullName,
            'username' => $admin_info->UserName
        );
        $this->logadmin_model->create($data2);
        $this->admin_model->delete($id);
        $this->session->set_flashdata('message', 'Xóa dữ liệu thành công');
        redirect(admin_url('agency'));
    }
    function listtranfer(){
        $admin_login = $this->session->userdata('user_id_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $this->data['status'] = $admin_info->Status;
        if($admin_info->Status == "A"){
            $listmoney = $this->tranfermoney_model->get_list_tranfer_money();
            $this->data['list'] = $listmoney['rows'];
            $this->data['temp'] = 'admin/agency/listtranfer';
            $this->load->view('admin/main', $this->data);
        }

    }
    function  listtranferdaily(){
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        $this->data['status'] = $admininfo->Status;
        $username = $this->uri->rsegment('3');
        $this->data['username'] = $username;

        $inputban['where']  = array("nick_name_tranfer" => $username);
        $totalban = $this->tranfermoney_model->get_total($inputban);
        $this->data['totalban'] = $totalban;
        $inputmua['where']  = array("nick_name_receive" => $username);
        $totalmua = $this->tranfermoney_model->get_total($inputmua);
        $this->data['totalmua'] = $totalmua;
        $where = array('nick_name_tranfer'=> $username);
        $where1 = array('nick_name_receive'=> $username);
        $totalmuamoney = $this->tranfermoney_model->get_sum('money',$where1);
        $this->data['totalmuamoney'] = $totalmuamoney;
        $totalbanmoney = $this->tranfermoney_model->get_sum('money',$where);
        $this->data['totalbanmoney'] = $totalbanmoney;

        if($admininfo->Status == "A") {
            $admin_info = $this->admin_model->get_info_admin_nickname($username);
            foreach ($admin_info as $row) {
                $input['where'] = array("ParentID" => $row->ID);
                $list1 = $this->admin_model->get_list($input);
                $this->data['list1'] = $list1;
            }
        }else{
                $input['where'] = array("ParentID" => $admininfo->ID);
                $list1 = $this->admin_model->get_list($input);
                $this->data['list2'] = $list1;

        }



        $listmoney = $this->tranfermoney_model->get_list_tranfer_money_daily($username);
        $this->data['list'] = $listmoney['rows'];
        $this->data['numtran'] = $listmoney['num_row_tr'];
        $this->data['numrece'] = $listmoney['num_row_re'];
        $this->data['temp'] = 'admin/agency/listtranferdaily';
        $this->load->view('admin/main', $this->data);

    }
    function  listransacdaily(){
        $username = $this->uri->rsegment('3');
        $this->data['username'] = $username;
        $this->data['temp'] = 'admin/agency/listransacdaily';
        $this->load->view('admin/main', $this->data);
    }
    function  doanhso(){
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        if( $admininfo->Status == "D"){
            $username = $admininfo->FullName;
            $this->data['username'] = $username;
        }else{
            $username = $this->uri->rsegment('3');
            $this->data['username'] = $username;
        }

        $created_to = $this->input->get('created_to');
        $created    = $this->input->get('created');
        if($created && $created_to)
        {
            $time = get_time_between_day($created,$created_to);
            if(is_array($time))
            {
                $where["DATE_FORMAT(`timestamp`, '%Y-%m-%d') >="] = $time['start'];
                $where["DATE_FORMAT(`timestamp`, '%Y-%m-%d')<="] = $time['end'];
            }
        }
        $where['nick_name_tranfer'] = $username;
        $input['where'] = $where;
        $totalban = $this->tranfermoney_model->get_total($input);
        $this->data['totalban'] = $totalban;
        $totalbanmoney = $this->tranfermoney_model->get_sum('money',$where);
        $this->data['totalbanmoney'] = $totalbanmoney;
        $totalmoneyrece = $this->tranfermoney_model->get_sum('money_receive',$where);
        $this->data['totalmoneyrece'] = $totalmoneyrece;
        if($created && $created_to)
        {
            $time = get_time_between_day($created,$created_to);
            if(is_array($time))
            {
                $where1["DATE_FORMAT(`timestamp`, '%Y-%m-%d') >="] = $time['start'];
                $where1["DATE_FORMAT(`timestamp`, '%Y-%m-%d')<="] = $time['end'];
            }
        }
        $where1['nick_name_receive'] = $username;
        $input1['where'] = $where1;
        $totalmua = $this->tranfermoney_model->get_total($input1);
        $this->data['totalmua'] = $totalmua;
        $totalmuamoney = $this->tranfermoney_model->get_sum('money',$where1);
        $this->data['totalmuamoney'] = $totalmuamoney;
        $totalmoneyrecemua = $this->tranfermoney_model->get_sum('money_receive',$where1);
        $this->data['totalmoneyrecemua'] = $totalmoneyrecemua;
        $this->data['temp'] = 'admin/agency/doanhso';
        $this->load->view('admin/main', $this->data);

    }
    function tranfermoney(){

        $this->data['temp'] = 'admin/agency/tranfermoney';
        $this->load->view('admin/main', $this->data);
    }
    function  resetpass(){


        $this->data['temp'] = 'admin/agency/resetpass';
        $this->load->view('admin/main', $this->data);
    }
    function  resetpassajax(){
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        $oldpass = $this->input->post('oldpass');
        $newpass = $this->input->post('newpass');

        if($oldpass == ""){
            echo "1";
        }
      else  if (strcasecmp( md5($oldpass),$admininfo->Password) != 0){
            echo "2";
        }
        if($newpass =""){
            echo "3";
        }
    }
    function editinfo(){
        $this->load->library('form_validation');
        $this->load->helper('form');
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        if($admininfo->Status == "A"){
            $info = $this->admin_model->get_info($id);

            $this->data['info'] = $info;
            if ($this->input->post()) {


                    echo "22222";
                    //them vao csdl;
                    $data = array(
                        'NameAgent' => $this->input->post("nameagentdl"),
                        'Facebook' =>  $this->input->post("facebookdl"),
                        'Address' =>  $this->input->post("addressdl"),
                        'Phone' =>  $this->input->post("phonedl")
                    );
                    //neu ma thay doi mat khau thi moi gan du lieu

                    if ($this->admin_model->update($id, $data)) {
                        //tạo ra nội dung thông báo
                        $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                    } else {
                        $this->session->set_flashdata('message', 'Không cập nhật được');
                    }
                    //chuyen tới trang danh sách quản trị viên
                    redirect(admin_url('agency'));

            }
        } elseif($admininfo->Status == "D"){
            $info = $this->admin_model->get_info($admininfo->ID);
            $this->data['info'] = $info;
            if ($this->input->post()) {
                if ($this->form_validation->run()) {
                    //them vao csdl;
                    $data = array(
                        'NameAgent' => $this->input->post("nameagentdl"),
                        'Facebook' =>  $this->input->post("facebookdl"),
                        'Address' =>  $this->input->post("addressdl"),
                        'Phone' =>  $this->input->post("phonedl")
                    );
                    //neu ma thay doi mat khau thi moi gan du lieu

                    if ($this->admin_model->update($admininfo->ID, $data)) {
                        //tạo ra nội dung thông báo
                        $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                    } else {
                        $this->session->set_flashdata('message', 'Không cập nhật được');
                    }
                    //chuyen tới trang danh sách quản trị viên
                    redirect(admin_url('agency'));
                }
            }
        }
        $this->data['temp'] = 'admin/agency/editinfo';
        $this->load->view('admin/main', $this->data);
    }

    function giftcode(){
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        $source = $admininfo->Key;
        $this->data['source'] = $source;
        $this->data['temp'] = 'admin/agency/giftcode';
        $this->load->view('admin/main', $this->data);
    }
    function giftcodeuse(){
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        $source = $admininfo->Key;
        $this->data['source'] = $source;
        $this->data['temp'] = 'admin/agency/giftcodeuse';
        $this->load->view('admin/main', $this->data);
    }
    function usergiftcode(){
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        $source = $admininfo->Key;
        $this->data['source'] = $source;
        $this->data['temp'] = 'admin/agency/usergiftcode';
        $this->load->view('admin/main', $this->data);
    }
    function nicknameusegiftcode(){
        $admin_login = $this->session->userdata('user_id_login');
        $admininfo = $this->admin_model->get_info($admin_login);
        $source = $admininfo->Key;
        $this->data['source'] = $source;
        $this->data['temp'] = 'admin/agency/nicknameusegiftcode';
        $this->load->view('admin/main', $this->data);
    }

    function listAgency()
    {
        canMenu('agency/listAgency');
        $this->data['temp'] = 'admin/agency/listAgency';
        $this->load->view('admin/main', $this->data);
    }

    function listAgencyajax()
    {
        canMenu('agency/listAgency');
        $nick_name = urlencode($this->input->post("nick_name"));
				$toDate = urlencode($this->input->post("toDate"));
				$fromDate = urlencode($this->input->post("fromDate"));
				$page = urlencode($this->input->post("page"));
				$maxItem = urlencode($this->input->post("maxItem"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=8826&nn='.$nick_name. '&ft='.$fromDate
            . '&et='.$toDate. '&pg='.$page.'&mi='.$maxItem);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function listAgencyWithCount()
    {
        canMenu('agency/listAgencyWithCount');
        $this->data['temp'] = 'admin/agency/listAgencyWithCount';
        $this->load->view('admin/main', $this->data);
    }

    function listAgencyWithCountajax()
    {
        canMenu('agency/listAgencyWithCount');
        $nick_name = urlencode($this->input->post("nick_name"));
        $toDate = urlencode($this->input->post("toDate"));
        $fromDate = urlencode($this->input->post("fromDate"));
        $page = urlencode($this->input->post("page"));
        $maxItem = urlencode($this->input->post("maxItem"));
        $datainfo = $this->get_data_curl($this->config->item('api_agent').'?c=8840&nn='.$nick_name. '&ft='.$fromDate
            . '&et='.$toDate. '&pg='.$page.'&mi='.$maxItem);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function listUserOfAgency()
    {
        $this->data['temp'] = 'admin/agency/listUserOfAgency';
        $agency = $this->config->item('agent_uri_return');
        $parent = $this->input->get('parent');
        $referenceCode = $this->input->get('referral_code');
        $this->data['returnUrl'] = isset($agency[$parent]) ? $agency[$parent] : null;
        $uri = [
            'referral_code' => $referenceCode,
            'parent' => $parent,
        ];
        $this->data['redirectUri'] = http_build_query($uri);
        $this->load->view('admin/main', $this->data);
    }

    function listUserOfAgencyajax()
    {
        $nick_name = urlencode($this->input->post("nick_name"));
				$toDate = urlencode($this->input->post("toDate"));
				$fromDate = urlencode($this->input->post("fromDate"));
        $referral_code = urlencode($this->input->post("referral_code"));
        $doanh_thu = urlencode($this->input->post("doanh_thu"));
        $page = urlencode($this->input->post("page"));
        $maxItem = urlencode($this->input->post("maxItem"));
        $datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=8827&rc='.$referral_code. '&nn='.$nick_name. '&ft='.$fromDate
            . '&et='.$toDate. '&dt='.$doanh_thu. '&pg='.$page. '&mi='.$maxItem);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

		function detailUserOfAgency()
		{
			$this->data['temp'] = 'admin/agency/detailUserOfAgency';
            $uri = [
                'parent' => $this->input->get('parent'),
                'referral_code' => $this->input->get('referral_code'),
            ];
            $query = http_build_query($uri);
            $this->data['uri'] = $query;
			$this->load->view('admin/main', $this->data);
		}

		function detailUserOfAgencyajax()
		{
			$nn = urlencode($this->input->post("nn"));
			$datainfo = $this->get_data_curl($this->config->item('api_backend') . '?c=8828&nn=' . $nn);
			if (isset($datainfo)) {
				echo $datainfo;
			} else {
				echo "Bạn không được hack";
			}
		}

}