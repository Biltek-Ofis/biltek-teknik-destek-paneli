<?php
class App extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Giris_Model");
        $this->load->model("Kullanicilar_Model");
        $this->load->model("Cihazlar_Model");
    }
    public function index()
    {
        redirect(base_url());
    }
    public function token($token)
    {
        if (isset($token)) {
            if ($token == getenv("AUTH_TOKEN")) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function hataMesaji($kod)
    {
        $sonuc = array(
            "hata" => $kod
        );
        switch ($kod) {
            case 1:
                $sonuc["mesaj"] = "Yetkisiz İşlem";
                break;
            default:
                $sonuc["kod"] = 99;
                $sonuc["mesaj"] = "Bir hata oluştu";
                break;
        }
        return $sonuc;
    }
    public function girisyap($kullaniciAdi, $sifre, $token)
    {
        if ($this->token($token)) {
            $durum = $this->Giris_Model->girisDurumu($kullaniciAdi, $sifre);
            $sonuc = array(
                "id" => "0",
                "durum" => "false"
            );
            if ($durum) {
                $kullaniciBilgileri = $this->Kullanicilar_Model->tekKullaniciAdi($kullaniciAdi);
                if (isset($kullaniciBilgileri)) {
                    $sonuc["durum"] = "true";
                    $sonuc["id"] = $kullaniciBilgileri->id;
                }
            }
            echo json_encode($sonuc);
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function kullaniciBilgileri($id, $token)
    {
        if ($this->token($token)) {
            $kullanici = $this->Kullanicilar_Model->tekKullanici($id);
            echo json_encode($kullanici);
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function cihazlarTumu($token)
    {
        if ($this->token($token)) {
            echo json_encode($this->Cihazlar_Model->cihazlarTumuJQ());
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
}
