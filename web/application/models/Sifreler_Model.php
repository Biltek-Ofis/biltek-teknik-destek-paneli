<?php
class Sifreler_Model extends CI_Model
{
    private $kullaniciID;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Islemler_Model");
        $this->load->model("Kullanicilar_Model");
        $this->kullaniciID = $this->Kullanicilar_Model->kullaniciBilgileri()["id"];
    }
    public function sifrelerTabloAdi()
    {
        return DB_ON_EK_STR . "sifreler";
    }
    public function getir()
    {
        $query = $this->db->reset_query()->order_by("musteri_adi", "ASC")->get($this->sifrelerTabloAdi())->result();
        $result = $this->donustur($query);
        return $result;
    }
    public function donustur($result)
    {
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->k_adi = $this->encryption->decrypt($result[$i]->k_adi);
            $result[$i]->sifre = $this->encryption->decrypt($result[$i]->sifre);
            $result[$i]->olusturan_id = $result[$i]->olusturan;
            $result[$i]->duzenleyen_id = $result[$i]->duzenleyen;
            $olusturan = $this->Kullanicilar_Model->tekKullanici($result[$i]->olusturan);
            if ($olusturan != null) {
                $result[$i]->olusturan = $olusturan->ad_soyad;
            } else {
                $result[$i]->olusturan = "Belirtilmemiş";
            }

            $duzenleyen = $this->Kullanicilar_Model->tekKullanici($result[$i]->duzenleyen);
            if ($duzenleyen != null) {
                $result[$i]->duzenleyen = $duzenleyen->ad_soyad;
            } else {
                $result[$i]->duzenleyen = "Belirtilmemiş";
            }

            $result[$i]->tarih = $this->Islemler_Model->tarihDonusturSiralama($result[$i]->tarih);
            $result[$i]->son_duzenleme = $this->Islemler_Model->tarihDonusturSiralama($result[$i]->son_duzenleme);
        }
        return $result;
    }
    public function ekle()
    {
        $veri = $this->post(TRUE);
        if (!isset($veri["musteri_adi"])) {
            return FALSE;
        }
        if (!isset($veri["aciklama"])) {
            return FALSE;
        }
        if (!isset($veri["k_adi"])) {
            return FALSE;
        }
        if (!isset($veri["sifre"])) {
            return FALSE;
        }
        return $this->db->reset_query()->insert($this->sifrelerTabloAdi(), $veri);
    }
    public function duzenle($id)
    {
        $veri = $this->post();
        if (!isset($veri["musteri_adi"])) {
            return FALSE;
        }
        if (!isset($veri["aciklama"])) {
            return FALSE;
        }
        if (!isset($veri["k_adi"])) {
            return FALSE;
        }
        if (!isset($veri["sifre"])) {
            return FALSE;
        }
        return $this->db->reset_query()->where("id", $id)->update($this->sifrelerTabloAdi(), $veri);
    }

    public function sil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->sifrelerTabloAdi());
    }

    public function post($ekleme = FALSE)
    {
        $veri = array();

        $musteri_adi = $this->input->post("musteri_adi");
        if (isset($musteri_adi)) {
            $veri["musteri_adi"] = $musteri_adi;
        }
        $aciklama = $this->input->post("aciklama");
        if (isset($aciklama)) {
            $veri["aciklama"] = $aciklama;
        }
        $k_adi = $this->input->post("k_adi");
        if (isset($k_adi)) {
            $veri["k_adi"] = $this->encryption->encrypt($k_adi);
        }
        $sifre = $this->input->post("sifre");
        if (isset($sifre)) {
            $veri["sifre"] = $this->encryption->encrypt($sifre);
        }
        $kullanici_id = $this->kullaniciID;
        $kullanici = $this->input->post("kullanici");
        if (isset($kullanici)) {
            $kullanici_id = $kullanici;
        }
        if ($ekleme) {
            $veri["olusturan"] = $kullanici_id;
        }
        $veri["duzenleyen"] = $kullanici_id;

        if ($ekleme) {
            $veri["tarih"] = $this->Islemler_Model->tarih();
            $veri["son_duzenleme"] = $veri["tarih"];
        } else {
            $veri["son_duzenleme"] = $this->Islemler_Model->tarih();
        }

        return $veri;
    }
}