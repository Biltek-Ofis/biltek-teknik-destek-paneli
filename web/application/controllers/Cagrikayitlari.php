<?php
require_once("Varsayilancontroller.php");

class Cagrikayitlari extends Varsayilancontroller
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
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Çağrı Kayıtları", "cagri_kaydi", [], "inc/datatables"));
        } else {
            redirect(base_url());
        }
    }
    public function detay($id)
    {
        if ($this->Giris_Model->kullaniciGiris() || $this->Giris_Model->kullaniciGiris(TRUE)) {
            if (isset($id) && strlen($id)) {
                $this->load->model("Islemler_Model");

                $cagri = $this->Cihazlar_Model->cagriKaydiGetir($id);
                if ($this->Giris_Model->kullaniciGiris(TRUE)) {
                    if ($cagri != null && $cagri->kull_id != $this->Kullanicilar_Model->kullaniciBilgileri()["id"]) {
                        $cagri = null;
                    }
                }
                $this->load->view("tasarim", $this->Islemler_Model->tasarimArray($cagri != null ? "Çağrı Kaydı " . $cagri->id : "Çağrı Kaydı Bulunamadı", "cagri_kaydi_detay", [], "", array("cagri" => $cagri)));
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }
    public function ekle()
    {
        if ($this->Giris_Model->kullaniciGiris() || $this->Giris_Model->kullaniciGiris(TRUE)) {
            $ekle = $this->Cihazlar_Model->cagriKaydiEkle();
            if ($ekle) {
                redirect(base_url("cagrikayitlari"));
            } else {
                $this->Kullanicilar_Model->girisUyari("cagrikayitlari", "Çağrı kaydı eklenemedi lütfen daha sonra tekrar deneyin");
            }
        } else {
            redirect(base_url());
        }
    }
    public function duzenle($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            if (strlen($id) > 0) {
                $duzenle = $this->Cihazlar_Model->cagriKaydiDuzenle($id);
                if ($duzenle) {
                    redirect(base_url("cagrikayitlari"));
                } else {
                    $this->Kullanicilar_Model->girisUyari("cagrikayitlari", "Çağrı kaydı duzenlenemedi lütfen daha sonra tekrar deneyin");
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }
    public function sil($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            if (strlen($id) > 0) {
                $sil = $this->Cihazlar_Model->cagriKaydiSil($id);
                if ($sil) {
                    redirect(base_url("cagrikayitlari"));
                } else {
                    $this->Kullanicilar_Model->girisUyari("cagrikayitlari", "Çağrı kaydı silinemedi lütfen daha sonra tekrar deneyin");
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }
    public function fiyationayla($id)
    {
        $this->Cihazlar_Model->cagriDurumGuncelle($id, "Fiyat Onaylandı");
        redirect(base_url("cagrikayitlari/detay/" . $id));
    }
    public function fiyatireddet($id)
    {
        $this->Cihazlar_Model->cagriDurumGuncelle($id, "Fiyat Onaylanmadı");
        redirect(base_url("cagrikayitlari/detay/" . $id));
    }
}

?>