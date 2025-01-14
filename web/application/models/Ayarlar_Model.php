<?php
class Ayarlar_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Kullanicilar_Model");
    }
    public function tabloAdi()
    {
        return DB_ON_EK_STR . "ayarlar";
    }
    public function getir(){
        return $this->db->reset_query()->get($this->tabloAdi())->result()[0];
    }
    public function duzenle($veri){
        return $this->db->reset_query()->update($this->tabloAdi(), $veri);
    }
    public function kis_modu_duz(){
        $ayarlar = $this->getir();
        return $ayarlar->kis_modu == 1;
    }
    public function kis_modu(){
        $kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
        $ayarlar = $this->getir();
        if(strlen($kullanici["ad_soyad"]) > 0){
            return ($ayarlar->kis_modu == 1 && $kullanici["tema"] == "oto") || $kullanici["tema"] == "kis";
        }else{
            return $ayarlar->kis_modu == 1;
        }
    }
}
?>