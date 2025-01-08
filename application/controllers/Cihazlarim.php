<?php
require_once("Varsayilancontroller.php");

class Cihazlarim extends Varsayilancontroller
{
    private $kullaniciID;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
        $this->kullaniciID = $this->Kullanicilar_Model->kullaniciBilgileri()["id"];
    }
    public function index()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $veri = array(
                "baslik" => "Cihazlarım",
                "cihazlarim" => $this->Cihazlar_Model->cihazlarTekTur($this->kullaniciID),
                "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri(),
                "suankiPersonel" => $this->Kullanicilar_Model->kullaniciBilgileri()["id"]
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
            $limit = $this->input->post("limit");
        	$offset = $this->input->post("offset");
			if(!isset($limit)){
				$limit = "";
			}
			if(!isset($offset)){
				$offset = "";
			}
        	$arama = $this->input->post("arama");
			if(!isset($arama)){
				$arama = "";
			}
            echo json_encode($this->Cihazlar_Model->cihazlarTekPersonelTumuJQ($this->kullaniciID, $limit, $offset, $arama));
        }
    }
    public function cihazSil($id, $tur)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $sil = $this->Cihazlar_Model->cihazSil($id);
            if($tur == "POST" || $tur == "post"){
				if ($sil) {
					echo json_encode(array("mesaj" => "", "sonuc" => 1));
				}else{
					echo json_encode(array("mesaj" => "Silme işlemi gerçekleştirilemedi. " . $this->db->error()["message"], "sonuc" => 0));
				}
			}else{
                if ($sil) {
                    redirect(base_url("cihazlarim/"));
                } else {
                    $this->Kullanicilar_Model->girisUyari("cihazlarim/", "Silme işlemi gerçekleştirilemedi");
                }
            }
        } else {
            if($tur == "POST" || $tur == "post"){
				echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için kullanıcı girişi yapmanız gerekmektedir. Lütfen sayfayı yenileyip tekrar deneyin.", "sonuc" => 0));
			}else{
				$this->Kullanicilar_Model->girisUyari("cikis");
			}
        }
    }
}
