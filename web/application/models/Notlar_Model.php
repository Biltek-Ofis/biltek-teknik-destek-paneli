<?php
class Notlar_Model extends CI_Model
{
    private $kullaniciID;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Islemler_Model");
        $this->load->model("Kullanicilar_Model");
        $this->kullaniciID = $this->Kullanicilar_Model->kullaniciBilgileri()["id"];
    }
    public function notlarTabloAdi()
    {
        return DB_ON_EK_STR . "notlar";
    }
    public function getir()
    {
        $query = $this->db->reset_query()->order_by("son_duzenleme", "DESC")->get($this->notlarTabloAdi())->result();
        $result = $this->donustur($query);
        return $result;
    }
    public function donustur($result)
    {
        for ($i = 0; $i < count($result); $i++) {
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
        if (!isset($veri["aciklama"])) {
            return FALSE;
        }
        $ekle = $this->db->reset_query()->insert($this->notlarTabloAdi(), $veri);
        if ($ekle) {
            $this->bildirim("Yeni Not Oluşturuldu", $veri["aciklama"]);
        }
        return $ekle;
    }
    public function duzenle($id)
    {
        $veri = $this->post();
        if (!isset($veri["aciklama"])) {
            return FALSE;
        }
        $duzenle = $this->db->reset_query()->where("id", $id)->update($this->notlarTabloAdi(), $veri);
        if ($duzenle) {
            $this->bildirim("Not Düzenlendi", $veri["aciklama"]);
        }
        return $duzenle;
    }

    public function sil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->notlarTabloAdi());
    }

    public function post($ekleme = FALSE)
    {
        $veri = array();

        $aciklama = $this->input->post("aciklama");
        if (isset($aciklama)) {
            $veri["aciklama"] = $aciklama;
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
    public function bildirim($baslik, $not)
    {
        $kullanicilar = $this->Kullanicilar_Model->kullanicilar(array(
            "musteri" => "0",
        ));

        foreach ($kullanicilar as $kullanici) {
            $this->Kullanicilar_Model->bildirimGonder($kullanici->id, $baslik, $not, "not");
        }
    }
}