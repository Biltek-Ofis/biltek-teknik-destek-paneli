<?php
class Home_Model extends CI_Model{

    
    public function __construct()
    {
        parent::__construct();
    }
    public $devicesTableName = "Cihazlar";
    public function getNotDeliveredDevice(){
        return $this->db->where("teslim_edildi !=",1)->get($this->devicesTableName)->result();
    }
    public function getDeliveredDevice(){
        return $this->db->where("teslim_edildi",1)->get($this->devicesTableName)->result();
    }
    public function addCustomer($data){
        return $this->db->insert($this->devicesTableName, $data);
    }
}
?>