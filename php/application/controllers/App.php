<?php
class App extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Giris_Model");
    }
    public function index(){
        redirect(base_url());
    }
    public function girisyap($kullaniciAdi, $sifre){
        $durum = $this->Giris_Model->girisDurumu($kullaniciAdi, $sifre);
        echo $durum ? "true" : "false";
    }
}
