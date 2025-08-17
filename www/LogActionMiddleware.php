<?php

class LogActionMiddleware
{
    protected $controller;
    protected $ci;

    public function __construct($controller, $ci)
    {
        $this->controller = $controller;
        $this->ci = $ci;
    }

    public function run()
    {
        $methodRequest = $this->controller->input->method(TRUE);
        if ($methodRequest === 'GET') {
            return;
        }
        $dataRequest = $this->controller->input->post();
        if (is_array($dataRequest)) {
            unset($dataRequest['pass']);
            unset($dataRequest['password']);
        }
        $data = array(
            'username' => $this->ci->session->userdata('user_name_login'),
            'nickname' => $this->ci->session->userdata('nick_name_login'),
            'ip' => $this->ci->input->ip_address(),
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'request_data' => json_encode($this->ci->input->post()),
            'object' => $this->ci->router->fetch_class(),
            'type' => $methodRequest,
            'action' => $this->ci->router->fetch_method(),
            'tool' => "Admin",
            'status' => 0,
        );
        $this->ci->db->insert('log_loginadmin', $data);
    }
}