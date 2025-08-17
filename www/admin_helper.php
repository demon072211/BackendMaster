<?php
require 'Zebra_cURL.php';
//tao ra cac link trong admin
function admin_url($url = '')
{
    return base_url('admin/'.$url);
}
function Check_Url_Admin($current_url)
{
    $this->load->model('accesslink_model');
    //lấy id của user đăng nhập
    $admin_login = $this->session->userdata('user_id_login');
    $this->data['login'] = $admin_login;
    //lấy tất cả các link của user đó
    $list_link = $this->accesslink_model->get_list_linkacess_userid($admin_login->ID);
    //lấy url hiện tại
    foreach($list_link as $item)
    {
        if($item !=$current_url)
        {
            return false;
        }
    }
}

function readURLAPI($url) {
    $curl = new Zebra_cURL();
// cache results 3600 seconds
    $curl->cache('path/to/cache', 3600);
// a simple way of scrapping a page
// (you can do more with the "get" method and callback functions)
    $data= $curl->scrap($url, true);
    return $data;
}

if (!function_exists('canMenu')) {
    function canMenu($linkMenu)
    {
        $ci =& get_instance();
        $ci->load->library('session');
        $userMenu = $ci->session->userdata('user_menu');
        if (empty($userMenu) || !is_array($userMenu)) {
            return redirect('admin/unPermission');
        }
        if (!in_array($linkMenu, $userMenu)) {
            return redirect('admin/unPermission');
        }
    }
}