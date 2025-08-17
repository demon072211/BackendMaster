<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_menu_tay_du_to_dua_xe extends CI_Migration
{
    public function up()
    {
        $this->db->where('link', 'loggameslot/taydu')->set('Name', 'Đua xe');
        $this->db->update('menu');
    }

    public function down()
    {
        $this->db->where('link', 'loggameslot/taydu')->set('Name', 'Tây du');
        $this->db->update('menu');
    }
}