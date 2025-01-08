<?php

class Giris extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
        $this->load->model("Giris_Model");
        $this->load->model("Kullanicilar_Model");
    }
    public function index(){
        $ekServisNo = "";
        if(isset( $_GET["servisNo"])){
            $cihazGoster = $_GET["servisNo"];
            $ekServisNo = "?servisNo=".$cihazGoster;
        }
        if (!$this->Giris_Model->kullaniciGiris()){
            $kullanici_adi = $this->input->post("kullanici_adi");
            $sifre = $this->input->post("sifre");
            $durum = $this->Giris_Model->girisDurumu($kullanici_adi, $sifre);
            if($durum){
                $this->Giris_Model->kullaniciOturumAc($kullanici_adi);
                $kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
                if($kullanici["teknikservis"] == 1){
                    redirect(base_url("cihazlarim/".$ekServisNo));
                }else{
                    redirect(base_url($ekServisNo));
                }
            }else{
                $this->load->view("giris", array(
                        "girisHatasi"=> "Giriş Başarısız. Lütfen tekrar deneyin", 
                        "ekServisNo"=> $ekServisNo,
                    )
                );
            }
        }else{
            redirect(base_url($ekServisNo));
        }
    }

}

?>