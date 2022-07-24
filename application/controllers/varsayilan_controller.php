<?php

class Varsayilan_Controller extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Cihazlar_Model");
        $this->load->model("Giris_Model");
    }

}

?>