<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_menu_chim_dien extends CI_Migration
{
    public function up()
    {
        $this->db->where('link', 'loggameslot/chimdien')->set('Name', 'Thần bài');
        $this->db->update('menu');
    }

    public function down()
    {
        $this->db->where('link', 'loggameslot/taydu')->set('Name', 'Chim ');
        $this->db->update('menu');
    }
}