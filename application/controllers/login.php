<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->load->model("Login_Model");
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $status = $this->Login_Model->loginStatus($username, $password);
        if($status){
            $_SESSION["USER"] = $username;
            redirect(base_url());
        }else{
            $this->load->view("login", array("loginError"=> "Giriş Başarısız. Lütfen tekrar deneyin"));
        }
    }

}
;?>