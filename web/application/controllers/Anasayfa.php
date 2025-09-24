<?php
require_once("Varsayilancontroller.php");

class Anasayfa extends Varsayilancontroller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
    }
    public function index()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $this->load->model("Islemler_Model");
            //$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "test_icerik"));
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "cihazyonetimi", [], "inc/datatables"));
        } else if ($this->Giris_Model->kullaniciGiris(TRUE)) {
            $this->load->model("Islemler_Model");
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "cagri_kaydi", [], "inc/datatables"));
        } else {
            $ekServisNo = "";
            if (isset($_GET["servisNo"])) {
                $cihazGoster = $_GET["servisNo"];
                $ekServisNo = "?servisNo=" . $cihazGoster;
            }
            $this->load->view(
                'giris',
                array(
                    "girisHatasi" => "",
                    "ekServisNo" => $ekServisNo,
                )
            );
        }
    }
    public function test()
    {
        $this->load->view("icerikler/test");
    }
}

?>