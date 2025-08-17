<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_menu_set_big_small extends CI_Migration
{
    public function up()
    {
        $data = $this->db->select('id')->where('link', 'gameconfig')->where('Parrent_ID', -1)->get('menu')->row();
        if (!$data) {
            return;
        }
        $data = array(
            'Name' => 'Set kết quả tài xỉu',
            'Param' => '20',
            'Link' => 'usergame/setresulttaixiu',
            'Status' => 'A',
            'Parrent_ID' => $data->id,
            'isThuong' => '1',
            'isDaily' => '0',
            'isSuper' => '0',
        );
        $this->db->insert('menu', $data);

        $this->db->where('link', 'usergame/setresult')->set('Name', 'Set xúc sắc tài xỉu bầu cua'); //
        $this->db->update('menu');
    }

    public function down()
    {
        $this->db->delete('menu', array('Link' => 'usergame/setresulttaixiu'));
        $this->db->where('link', 'usergame/setresult')->set('Name', 'Set result tài xỉu bầu cua');
        $this->db->update('menu');
    }
}