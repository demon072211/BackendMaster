<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_menu_attendance extends CI_Migration
{
    public function up()
    {
        $data = array(
            'Name' => 'Điểm danh',
            'Param' => '19',
            'Link' => 'attendance',
            'Status' => 'A',
            'Parrent_ID' => -1,
            'isThuong' => '1',
            'isDaily' => '0',
            'isSuper' => '0',
        );
        $this->db->insert('menu', $data);
        $data = $this->db->select('id')->where('link', 'attendance')->where('Parrent_ID', -1)->get('menu')->row();
        if (!$data) {
            return;
        }
        $data = [
            [
                'Name' => 'Danh sách điểm danh',
                'Param' => '1',
                'Link' => 'attendance',
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
        $this->db->delete('menu', array('Link' => 'attendance'));
    }
}