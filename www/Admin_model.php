<?php
Class Admin_model extends MY_Model
{
    var $table = 'user';//
    function __construct()
    {
        parent::__construct();
        $this->load->model('userrole_model');
        $this->load->model('DBvinplay_Users_model');
    }

    function  get_info_admin($username){

        $this->db->where('UserName',$username);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }

    function  get_info_admin_nickname($username){

        $this->db->where('FullName',$username);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }

    function  get_info_admin_parent($parentid){

        $this->db->where('ParentID',$parentid);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function  get_admin_gift_code(){

        $this->db->where('Key!=',null);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }

    function  get_list_admin(){
        $this->db->select('user.ID,user.UserName,user.FullName,groupuser.Name');
        $this->db->join('userrole','user.ID = userrole.User_ID');
        $this->db->join('groupuser','groupuser.Id = userrole.Group_ID');
        $query = $this->db->get($this->table);
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }

    function  getPasswordById($id){
        $this->db->select('user.Password');
        $this->db->where('ID',$id)->limit(1);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            $arrayPassword = $query->result();
            return $arrayPassword[0]->Password;
        }else{
            return FALSE;
        }
    }
    function  getUserNameById($id){
        $this->db->select('user.UserName');
        $this->db->where('ID',$id)->limit(1);
        $query = $this->db->get($this->table);
        if($query->result())
        {
            $arrayUserName = $query->result();
            return $arrayUserName[0]->UserName;
        }else{
            return FALSE;
        }
    }

    public function getByUserName($userName)
    {
        $query = $this->db->select('ID')
            ->where('UserName', $userName)
            ->get($this->table);
        return $query->row();
    }

    public function createAccount($userName, $fullName, $groupId, $status) {
        $this->db->trans_begin();
        $password = md5("123456");
        $user = $this->getByUserName($userName);
        if ($user) {
            return false;
        }
        $data = array(
            'UserName' => $userName,
            'FullName' => $fullName,
            'Password' => $password,
            'Status' => $status,
            'isSuper' => "1"
        );
        $userId = $this->create($data);
        $data1 = array(
            'User_ID' => $userId,
            'Group_ID' => $groupId
        );
        $this->userrole_model->create($data1);
        $dataUser = array(
            'user_name' => $userName,
            'nick_name' => $fullName,
            'password' => $password,
            'dai_ly' => 100
        );
        $this->DBvinplay_Users_model->create($dataUser);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}