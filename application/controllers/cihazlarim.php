<?php
require_once("varsayilan_controller.php");

class Cihazlarim extends Varsayilan_Controller
{
    private $kullaniciID;

    public function __construct()
    {
        parent::__construct();
        $this->kullaniciID = $this->Kullanicilar_Model->kullaniciBilgileri()["id"];
    }
    public function index()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $veri = array(
                "baslik" => "Cihazlarım",
                "cihazlarim" => $this->Cihazlar_Model->cihazlarTekTur($this->kullaniciID),
                "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri(),
                "suankiPersonel" => $this->Kullanicilar_Model->kullaniciBilgileri()["id"],
            );
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray($veri["baslik"], "cihazlarim", $veri, "inc/datatables"));
        } else {
            $this->load->view('giris', array("girisHatasi" => ""));
        }
    }
    public function cihazlarJQ($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            echo json_encode($this->Cihazlar_Model->cihazlarTekPersonelJQ($this->kullaniciID, $id));
        }
    }
    public function cihazlarTumuJQ()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            echo json_encode($this->Cihazlar_Model->cihazlarTekPersonelTumuJQ($this->kullaniciID));
        }
    }
    public function cihazSil($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $sil = $this->Cihazlar_Model->cihazSil($id);
            if ($sil) {
                redirect(base_url("cihazlarim/"));
            } else {
                $this->Kullanicilar_Model->girisUyari("cihazlarim/", "Silme işlemi gerçekleştirilemedi");
            }
        } else {
            $this->Kullanicilar_Model->girisUyari("cikis");
        }
    }
}
