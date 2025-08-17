<?php

class Migrate extends CI_Controller
{
    public function index()
    {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE) {
            return show_error($this->migration->error_string());
        }
        echo 'Migrate thành công : ' . $this->migration->current();
    }
}