<?php
class Anasayfa_Model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public $cihazlarTabloAdi = "Cihazlar";
    public $cihazTurleriTabloAdi = "CihazTurleri";
    public $CihazDurumuTabloAdi = "CihazDurumu";
    public function kullaniciGiris(){
        return isset($_SESSION["KULLANICI"]);
    }
    public function cihazTuru($tur_id){
        $query = $this->db->where("id", $tur_id)->get($this->cihazTurleriTabloAdi);
        if($query->num_rows() > 0){
            return $query->result()[0]->isim;
        }else{
            return "Belirtilmemiş";
        }
    }
    public function tarihDonustur($tarih){
       return date("d/m/Y H:i", strtotime($tarih));
    }
    public function cihazSonDurumu($cihaz_id){
        $query = $this->db->where("cihaz_id", $cihaz_id)->limit(1)->get($this->CihazDurumuTabloAdi);
        if($query->num_rows() > 0){
            return $query->result()[0]->durum. " (". $this->tarihDonustur($query->result()[0]->tarih).")";
        }else{
            return "Bekleniyor";
        }
    }
    public function kullaniciOturumAc($kullanici_adi){
        $_SESSION["KULLANICI"] = $kullanici_adi;
    }
    public function oturumSifirla(){
        unset($_SESSION["KULLANICI"]);
    }
    public function cihazTurleri(){
        return $this->db->get($this->cihazTurleriTabloAdi)->result();
    }
    public function devamEdenCihazlar(){
        return $this->db->where("teslim_edildi !=",1)->where("silindi",0)->order_by('tarih','DESC')->get($this->cihazlarTabloAdi)->result();
    }
    public function teslimEdilenCihazlar(){
        return $this->db->where("teslim_edildi",1)->where("silindi",0)->order_by('tarih','DESC')->get($this->cihazlarTabloAdi)->result();
    }
    public function cihazEkle($veri){
        return $this->db->insert($this->cihazlarTabloAdi, $veri);
    }
    public function cihazSil($id){
        return $this->db->where("id",$id)->update($this->cihazlarTabloAdi,array("silindi"=> 1));
    }
}
?>