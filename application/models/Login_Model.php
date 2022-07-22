<?php
class Login_Model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }
    public function user($username, $password){

        return $this->db->where('username',$username)->get("Users")->result();
    }

}
?>