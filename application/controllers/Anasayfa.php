<?php
require_once("varsayilan_controller.php");

class Anasayfa extends Varsayilan_Controller{

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        if ($this->Giris_Model->kullaniciGiris()){
            $this->load->model("Islemler_Model");
            //$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "test_icerik"));
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "cihaz_yonetimi", [], "inc/datatables"));
        }else{
			$this->load->view('giris', array("girisHatasi"=> ""));
		}
    }
}

?>