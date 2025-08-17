<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_menu_kim_binh_mai_to_mini_poker extends CI_Migration
{
    public function up()
    {
        $this->db->where('link', 'loggameslot/kimbinhmai')->set('Name', 'Mini poker');
        $this->db->update('menu');
    }

    public function down()
    {
        $this->db->where('link', 'loggameslot/kimbinhmai')->set('Name', 'Kim binh mai');
        $this->db->update('menu');
    }
}