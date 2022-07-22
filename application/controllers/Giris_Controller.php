<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Giris_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->load->model("Login_Model");
        $kullanici_adi = $this->input->post("kullanici_adi");
        $sifre = $this->input->post("sifre");
        $durum = $this->Login_Model->girisDurumu($kullanici_adi, $sifre);
        if($durum){
            $_SESSION["USER"] = $kullanici_adi;
            redirect(base_url());
        }else{
            $this->load->view("login", array("girisHatasi"=> "Giriş Başarısız. Lütfen tekrar deneyin"));
        }
    }

}
;?>