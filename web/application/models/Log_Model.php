<?php
class Log_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Islemler_Model");
    }
    public function tabloAdi()
    {
        return DB_ON_EK_STR . "loglar";
    }
    public function kullaniciBul($uye_id)
    {
        $uID = 0;
        if ($uye_id != 0 && $uye_id != "0" && $uye_id != null && $uye_id != "") {
            $uID = $uye_id;
        }
        $this->load->model("Giris_Model");
        $this->load->model("Kullanicilar_Model");
        $this->load->model("Log_Model");
        if ($uID == 0 && $this->Giris_Model->kullaniciTanimi()) {
            $uID = $this->Giris_Model->kullaniciID();
        }
        $kullanici = null;
        if ($uID != 0) {
            $kullanici = $this->Kullanicilar_Model->tekKullanici($uID);
        }
        return $kullanici;
    }
    public function getir($id)
    {
        return $this->db->reset_query()->where("cihaz_id", $id)->order_by("tarih", "DESC")->get($this->tabloAdi())->result();
    }
    public function ekle($cihaz_id, $aciklama)
    {
        $this->load->model("Islemler_Model");
        $data = array(
            "cihaz_id" => $cihaz_id,
            "aciklama" => $aciklama,
            "tarih" => $this->Islemler_Model->guncelTarih(),
        );
        return $this->db->reset_query()->insert($this->tabloAdi(), $data);
    }
}