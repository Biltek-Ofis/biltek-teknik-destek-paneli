<?php
require_once("Varsayilancontroller.php");

class Malzemeteslimi extends Varsayilancontroller
{
    private $kullaniciID;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
        $this->load->model("Islemler_Model");
        $this->load->model("Malzeme_Teslimi_Model");
        $this->kullaniciID = $this->Kullanicilar_Model->kullaniciBilgileri()["id"];
    }
    public function index()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Malzeme Teslimi", "malzemeteslimi", array(), "inc/datatables"));
        } else {
            $this->load->view('giris', array("girisHatasi" => ""));
        }
    }
    public function yazdir($id = "")
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $this->load->view(
                "icerikler/yazdir/malzemeteslimi",
                array(
                    "id" => $id,
                )
            );
        } else {
            $this->load->view('giris', array("girisHatasi" => ""));
        }
    }
    public function malzemeTeslimleriJQ()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            echo json_encode($this->Malzeme_Teslimi_Model->malzemeteslimleri());
        } else {
            echo json_encode(array());
        }
    }
    public function malzemeTeslimiEkleJQ()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            echo json_encode($this->Malzeme_Teslimi_Model->malzemeTeslimiEkle());
        } else {
            echo json_encode($this->Malzeme_Teslimi_Model->girisHatasi());
        }
    }
    public function malzemeTeslimiDuzenleJQ($id)
    {
        if ($this->Giris_Model->kullaniciGiris() && strlen($id) > 0) {
            echo json_encode($this->Malzeme_Teslimi_Model->malzemeTeslimiDuzenle($id));
        } else {
            echo json_encode($this->Malzeme_Teslimi_Model->girisHatasi());
        }
    }
    public function malzemeTeslimiSilJQ($id)
    {
        if ($this->Giris_Model->kullaniciGiris() && strlen($id) > 0) {
            echo json_encode($this->Malzeme_Teslimi_Model->malzemeTeslimiSil($id));
        } else {
            echo json_encode($this->Malzeme_Teslimi_Model->girisHatasi());
        }
    }
}
