<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_menu_chi_tiet_tai_xiu_sieu_toc extends CI_Migration
{
    public function up()
    {
        $data = $this->db->select('id')->where('link', 'minigame')->where('Parrent_ID', -1)->get('menu')->row();
        if (!$data) {
            return;
        }
        $data = array(
            'Name' => 'Chi tiết tài xỉu siêu tốc',
            'Param' => '31',
            'Link' => 'logminigame/taixiustDetail',
            'Status' => 'A',
            'Parrent_ID' => $data->id,
            'isThuong' => '1',
            'isDaily' => '0',
            'isSuper' => '0',
        );
        $this->db->insert('menu', $data);

        $alterName = $this->db->select('id')->where('link', 'logminigame/taixiust')->get('menu')->row();
        if ($alterName) {
            $this->db->where('link', 'logminigame/taixiust')->set('Name', 'Lịch sử tài xỉu siêu tốc');
            $this->db->update('menu');
        }
    }

    public function down()
    {
        $this->db->delete('menu', array('Link' => 'logminigame/taixiustDetail'));
    }
}