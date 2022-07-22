<?php
class Login_Model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }
    public function loginStatus($username, $password){
        $query = $this->db->limit(1)->where('username',$username)->get("Users"); 
        if($query->num_rows() > 0){
            $pass = $query->result()[0]->password;
            if($password == $pass){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
?>