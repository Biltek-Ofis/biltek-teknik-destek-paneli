<?php
require_once("varsayilan_controller.php");
class Cihaz extends Varsayilan_Controller{

    public function __construct()
    {
        parent::__construct();
    }
    public function index($id){
        if ($this->Giris_Model->kullaniciGiris()){
            $cihaz = $this->Cihazlar_Model->cihazBul($id);
            if($cihaz->num_rows() > 0){
                $cihaz_bilg = $cihaz->result()[0];
                $baslik = $cihaz_bilg->musteri_adi .' - ' . $cihaz_bilg->cihaz . ' - Cihaz Detayları';
                $this->load->view("tasarim", $this->Islemler_Model->tasarimArray($baslik, "cihaz", array("cihaz"=>$cihaz_bilg, "baslik"=>$baslik)));
            }else{
                redirect(base_url());
            }
        }else{
            $this->load->view('giris', array("girisHatasi"=> ""));
        }
    }

}

?>