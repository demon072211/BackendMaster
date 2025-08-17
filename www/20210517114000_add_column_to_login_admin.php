<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_to_login_admin extends CI_Migration
{
    public function up()
    {
        $fields = array(
            'type' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
                'after' => 'tool'
            ),
            'object' => array(
                'type' => 'VARCHAR',
                'constraint' => '2000',
                'null' => TRUE,
                'after' => 'tool'
            ),
            'request_data' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'after' => 'tool'
            ),
            'old_data' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'after' => 'tool'
            ),
        );
        $this->dbforge->add_column('log_loginadmin', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('log_loginadmin', 'type');
        $this->dbforge->drop_column('log_loginadmin', 'object');
        $this->dbforge->drop_column('log_loginadmin', 'request_data');
        $this->dbforge->drop_column('log_loginadmin', 'old_data');
    }
}