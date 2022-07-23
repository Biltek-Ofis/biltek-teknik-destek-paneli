<?php
class Anasayfa_Model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public $cihazlarTabloAdi = "Cihazlar";
    public $cihazTurleriTabloAdi = "CihazTurleri";
    public $CihazDurumuTabloAdi = "CihazDurumu";
    public $silinmeDurumuTabloAdi = "SilinmeDurumu";
    public function kullaniciGiris(){
        return isset($_SESSION["KULLANICI"]);
    }
    public function tarihDonustur($tarih){
       return date("d/m/Y H:i", strtotime($tarih));
    }
    public function cihazSonDurumu($cihaz_id){
        $query = $this->db->where("cihaz_id", $cihaz_id)->limit(1)->get($this->CihazDurumuTabloAdi);
        if($query->num_rows() > 0){
            return $query->result()[0]->durum;
        }else{
            return "Bekleniyor";
        }
    }
    public function cihazSonIslemTarih($cihaz_id, $varsayilanTarih){
        $query = $this->db->where("cihaz_id", $cihaz_id)->limit(1)->get($this->CihazDurumuTabloAdi);
        if($query->num_rows() > 0){
            return $this->tarihDonustur($query->result()[0]->tarih);
        }else{
            return $this->tarihDonustur($varsayilanTarih);
        }
    }
    public function kullaniciOturumAc($kullanici_adi){
        $_SESSION["KULLANICI"] = $kullanici_adi;
    }
    public function oturumSifirla(){
        unset($_SESSION["KULLANICI"]);
    }
    public function cihazTuru($tur_id){
        $query = $this->db->where("id", $tur_id)->get($this->cihazTurleriTabloAdi);
        if($query->num_rows() > 0){
            return $query->result()[0]->isim;
        }else{
            return "Belirtilmemiş";
        }
    }
    public function cihazTurleri(){
        return $this->db->get($this->cihazTurleriTabloAdi)->result();
    }
    
    public function cihazVerileriniDonustur($result){
        for($i = 0; $i < count($result); $i++){
             $result[$i]->tarih = $this->tarihDonustur($result[$i]->tarih);
             $result[$i]->cihaz_turu = $this->cihazTuru($result[$i]->cihaz_turu);
        }
        return $result;
     }
    public function cihazlar(){
        $where = array(
            "silindi" => 0,
        );
        $result = $this->db->where($where)->order_by('tarih','DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTur($tur){
        $where = array(
            "silindi" => 0,
            "cihaz_turu" => $tur,
        );
        $result = $this->db->where($where)->order_by('tarih','DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarJQ($id){
        $where = array(
            "id >"=> $id,
            "silindi" => 0
        );
        $result = $this->db->where($where)->order_by('tarih','ASC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurJQ($tur, $id){
        $where = array(
            "id >"=> $id,
            "silindi" => 0,
            "cihaz_turu" => $tur
        );
        $result = $this->db->where($where)->order_by('tarih','ASC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTumuJQ(){
        $result = $this->db->order_by('tarih','ASC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurTumuJQ($tur){
        $where = array(
            "cihaz_turu" => $tur
        );
        $result = $this->db->where($where)->order_by('tarih','ASC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazEkle($veri){
        return $this->db->insert($this->cihazlarTabloAdi, $veri);
    }
    public function cihazSil($id){
        return $this->db->where("id",$id)->update($this->cihazlarTabloAdi,array("silindi"=> 1));
    }
    public function silinenCihazlariBul(){
        $results = $this->db->get($this->silinmeDurumuTabloAdi)->result();
        //$this->db->empty_table($this->silinmeDurumuTabloAdi);
        return $results;
    }
    public function cogulEki($yazi){
        $sesliHarfler =
            'A'.
            'a'.
            'E'.
            'e'.
            'I'.
            'ı'.
            'İ'.
            'i'.
            'O'.
            'o'.
            'Ö'.
            'ö'.
            'U'.
            'u'.
            'Ü'.
            'ü'
        ;
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $sesliHarf = mb_ereg_replace('[^'.$sesliHarfler.']','',$yazi);
        $sonSesliHarf = mb_substr($sesliHarf,-1);
        switch($sonSesliHarf){
            case "A":
            case "a":
            case "I":
            case "ı":
            case "O":
            case "o":
            case "U":
            case "u":
                return $yazi."lar";
            case "E":
            case "E":
            case "İ":
            case "İ":
            case "Ö":
            case "ö":
            case "Ü":
            case "ü":
                return $yazi."ler";
            default:
                return $yazi;
        }
    }
}
?>