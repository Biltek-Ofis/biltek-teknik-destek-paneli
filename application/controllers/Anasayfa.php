<?php
require_once("Varsayilancontroller.php");

class Anasayfa extends Varsayilancontroller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
    }
    public function index(){
        if ($this->Giris_Model->kullaniciGiris()){
            $this->load->model("Islemler_Model");
            //$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "test_icerik"));
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "cihazyonetimi", [], "inc/datatables"));
        }else{
			$this->load->view('giris', array("girisHatasi"=> ""));
		}
    }
    public function test(){
        $this->load->view("icerikler/test");
    }
}

?>