<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Giris extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anasayfa_Model");
    }
    public function index(){
        if (!$this->Anasayfa_Model->kullaniciGiris()){
            $this->load->model("Giris_Model");
            $kullanici_adi = $this->input->post("kullanici_adi");
            $sifre = $this->input->post("sifre");
            $durum = $this->Giris_Model->girisDurumu($kullanici_adi, $sifre);
            if($durum){
                $this->Anasayfa_Model->kullaniciOturumAc($kullanici_adi);
                redirect(base_url());
            }else{
                $this->load->view("giris", array("girisHatasi"=> "Giriş Başarısız. Lütfen tekrar deneyin"));
            }
        }else{
            redirect(base_url());
        }
    }
}
;?>