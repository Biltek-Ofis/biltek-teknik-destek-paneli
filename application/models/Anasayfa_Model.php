<?php
class Anasayfa_Model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public $cihazlarTabloAdi = "Cihazlar";
    public function kullaniciGiris(){
        return isset($_SESSION["KULLANICI"]);
    }
    public function kullaniciOturumAc($kullanici_adi){
        $_SESSION["KULLANICI"] = $kullanici_adi;
    }
    public function oturumSifirla(){
        unset($_SESSION["KULLANICI"]);
    }
    public function devamEdenCihazlar(){
        return $this->db->where("teslim_edildi !=",1)->where("silindi",0)->get($this->cihazlarTabloAdi)->result();
    }
    public function teslimEdilenCihazlar(){
        return $this->db->where("teslim_edildi",1)->where("silindi",0)->get($this->cihazlarTabloAdi)->result();
    }
    public function cihazEkle($veri){
        return $this->db->insert($this->cihazlarTabloAdi, $veri);
    }
    public function cihazSil($id){
        return $this->db->where("id",$id)->update($this->cihazlarTabloAdi,array("silindi"=> 1));
    }
}
?>