<?php
class Cihazlar_Model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }
    public $cihazlarTabloAdi = "Cihazlar";
    public $cihazTurleriTabloAdi = "CihazTurleri";
    public $CihazDurumuTabloAdi = "CihazDurumu";
    public $silinmeDurumuTabloAdi = "SilinmeDurumu";
    public function cihazSonDurumu($cihaz_id){
        $query = $this->db->where("cihaz_id", $cihaz_id)->limit(1)->get($this->CihazDurumuTabloAdi);
        if($query->num_rows() > 0){
            return $query->result()[0]->durum;
        }else{
            return "Bekleniyor";
        }
    }
    public function cihazSonIslemTarih($cihaz_id, $varsayilanTarih){
        $this->load->model("Islemler_Model");
        $query = $this->db->where("cihaz_id", $cihaz_id)->limit(1)->get($this->CihazDurumuTabloAdi);
        if($query->num_rows() > 0){
            return $this->Islemler_Model->tarihDonustur($query->result()[0]->tarih);
        }else{
            return $this->Islemler_Model->tarihDonustur($varsayilanTarih);
        }
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
        $this->load->model("Islemler_Model");
        for($i = 0; $i < count($result); $i++){
             $result[$i]->tarih = $this->Islemler_Model->tarihDonustur($result[$i]->tarih);
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
}
?>