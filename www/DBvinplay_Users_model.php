<?php
Class DBvinplay_Users_model extends MY_Model
{
    var $table = 'users';
    var $key = 'id';

    function __construct()
    {
        parent::__construct();
        $this->db_vinplay = $this->load->database('vinplay',TRUE);
    }

    function create($data = array())
    {
        if($this->db_vinplay->insert($this->table, $data))
        {
            $this->log_activities($data);
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function update($id, $data)
    {
        if (!$id)
        {
            return FALSE;
        }

        $where = array();
        $where[$this->key] = $id;
        $this->update_rule($where, $data);

        return TRUE;
    }

    function updateByUsername($username, $data)
    {
        if (!$username)
        {
            return FALSE;
        }

        $where = array();
        $where["user_name"] = $username;
        $this->update_rule($where, $data);

        return TRUE;
    }

    function update_rule($where, $data)
    {
        if (!$where)
        {
            return FALSE;
        }
        $this->db_vinplay->where($where);
        $this->db_vinplay->update($this->table, $data);
        $this->log_activities($data, $where, $this->db_vinplay->database);
        return TRUE;
    }
}