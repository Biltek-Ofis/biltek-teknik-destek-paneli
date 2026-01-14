<?php
require_once("Varsayilancontroller.php");

class Js extends Varsayilancontroller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
        $this->load->model("Firma_Model");
    }
    public function index()
    {
        redirect(base_url());
    }
    public $musteriAdi = "musteri_adi";
    public $stokAdi = "STOK_ADI";
    public function musteri_adi( )
    {
        $ara = $this->input->post("ara");
        echo $this->Islemler_Model->turkceKarakter(json_encode($this->Firma_Model->musteriBilgileri($this->musteriAdi, $ara)));
    }
    public function ucretler()
    {
        $ara = $this->input->post("ara");
        $this->load->model("Ucretler_Model");
        $ucretler = $this->Ucretler_Model->ucretler($ara);
        echo json_encode($ucretler);
    }
}
