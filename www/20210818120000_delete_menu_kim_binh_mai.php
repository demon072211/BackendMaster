<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Delete_menu_kim_binh_mai extends CI_Migration
{
    public function up()
    {
        $this->db->delete('menu', array('Link' => 'loggameslot/kimbinhmai'));
    }

    public function down()
    {

    }
}