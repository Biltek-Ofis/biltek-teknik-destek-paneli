<?php

class Anasayfa extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }
    public $baslikStr = "baslik";
    public $icerikStr = "icerik";
    public function index(){
        $this->load->view("tasarim", $this->tasarimArray("Anasayfa", "test_icerik"));
    }
    public function tasarimArray($baslik, $icerik){
        return array(
            "baslik"=> $baslik,
            "icerik"=> $icerik,
        );
    }

}

?>