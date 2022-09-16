<?php
class App extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Giris_Model");
        $this->load->model("Kullanicilar_Model");
    }
    public function index(){
        redirect(base_url());
    }
    public function girisyap($kullaniciAdi, $sifre){
        $durum = $this->Giris_Model->girisDurumu($kullaniciAdi, $sifre);
        $sonuc = array(
            "id"=> "0",
            "durum"=> "false"
        );
        if($durum){
            $kullaniciBilgileri = $this->Kullanicilar_Model->tekKullaniciAdi($kullaniciAdi);
            if(isset($kullaniciBilgileri)){
                $sonuc["durum"] = "true";
                $sonuc["id"] = $kullaniciBilgileri->id;
            }
        }
        echo json_encode($sonuc);
    }
    public function kullaniciBilgileri($id){
        $kullanici = $this->Kullanicilar_Model->tekKullanici($id);
        echo json_encode($kullanici);
    }
}
