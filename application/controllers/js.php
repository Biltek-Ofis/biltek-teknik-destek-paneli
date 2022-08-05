<?php
require_once("varsayilan_controller.php");

class Js extends Varsayilan_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Firma_Model");
    }
    public function index()
    {
        redirect(base_url());
    }
    public $musteriAdi = "CARI_ISIM";
    public $stokAdi = "STOK_ADI";
    public function musteri_adi()
    {
        $ara = $this->input->post("ara");
        echo json_encode($this->Firma_Model->musteri_bilgileri($this->musteriAdi, $ara));
    }
    public function stok()
    {
        $ara = $this->input->post("ara");
        echo json_encode($this->Firma_Model->stok($this->stokAdi, $ara));
    }
}
