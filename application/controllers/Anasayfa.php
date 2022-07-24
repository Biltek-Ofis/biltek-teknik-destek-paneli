<?php

class Anasayfa extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }
    public $baslikStr = "baslik";
    public $icerikStr = "icerik";
    public function index(){
        $this->load->model("Giris_Model");
        if ($this->Giris_Model->kullaniciGiris()){
            $this->load->view("tasarim", $this->tasarimArray("Anasayfa", "test_icerik"));
		}else{
			$this->load->view('giris', array("girisHatasi"=> ""));
		}
    }
    public function tasarimArray($baslik, $icerik){
        return array(
            "baslik"=> $baslik,
            "icerik"=> $icerik,
        );
    }

}

?>