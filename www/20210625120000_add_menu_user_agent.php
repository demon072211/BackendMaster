<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_menu_user_agent extends CI_Migration
{
    public function up()
    {
        $data = array(
            'Name' => 'Quản lý Đại lý',
            'Param' => '1',
            'Link' => 'useragency',
            'Status' => 'A',
            'Parrent_ID' => -1,
            'isThuong' => '1',
            'isDaily' => '0',
            'isSuper' => '0',
        );
        $this->db->insert('menu', $data);
        $data = $this->db->select('id')->where('link', 'useragency')->where('Parrent_ID', -1)->get('menu')->row();
        if (!$data) {
            return;
        }
        $data = [
            [
                'Name' => 'Danh sách',
                'Param' => '1',
                'Link' => 'userAgency',
                'Status' => 'A',
                'Parrent_ID' => $data->id,
                'isThuong' => '1',
                'isDaily' => '0',
                'isSuper' => '0',
            ],
            [
                'Name' => 'Thêm mới',
                'Param' => '2',
                'Link' => 'userAgency/create',
                'Status' => 'A',
                'Parrent_ID' => $data->id,
                'isThuong' => '1',
                'isDaily' => '0',
                'isSuper' => '0',
            ]
        ];
        $this->db->insert_batch('menu', $data);
    }

    public function down()
    {
        $this->db->delete('menu', array('Link' => 'userAgency'));
        $this->db->delete('menu', array('Link' => 'userAgency/create'));
    }
}