<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->load->model("Login_Model");
        print_r($this->Login_Model->user("admin", "123456"));
    }

}
;?>