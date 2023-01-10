<?php

class Varsayilancontroller extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Cihazlar_Model");
        $this->load->model("Firma_Model");
        $this->load->model("Giris_Model");
        $this->load->model("Kullanicilar_Model");
        $this->load->model("Islemler_Model");
    }

}

?>