<?php
class Home_Model extends CI_Model{

    
    public function __construct()
    {
        parent::__construct();
    }
    public $customerTableName = "Customers";
    public function getNotCompletedCustomer(){
        return $this->db->where("status !=","Teslim Edildi")->get($this->customerTableName)->result();
    }
    public function getCompletedCustomer(){
        return $this->db->where("status","Teslim Edildi")->get($this->customerTableName)->result();
    }
    public function addCustomer($data){
        return $this->db->insert($this->customerTableName, $data);
    }
}
?>