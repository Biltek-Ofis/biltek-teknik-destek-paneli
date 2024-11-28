<?php
class Urunler_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function urunlerTabloAdi()
    {
        return DB_ON_EK_STR . "urunler";
    }
    public function urunler(){
        $urunler = $this->db->reset_query()->get($this->urunlerTabloAdi())->result();
        return $urunler;
    }
    public function ekle(){
        $veri = $this->urunPost();
        $ekle = $this->db->reset_query()->insert($this->urunlerTabloAdi(), $veri);
        return $ekle;
    }
    
    public function duzenle($id){
        $veri = $this->urunPost();
        return $this->db->reset_query()->where(array("id" => $id))->update(
            $this->urunlerTabloAdi(),
            $veri
        );
    }
    public function sil($id){
        return $this->db->reset_query()->where(array("id" => $id))->delete($this->urunlerTabloAdi());
    }
    public function urunPost(){
        $veri = array(
            "isim" => $this->input->post("isim"),
            "barkod" => $this->input->post("barkod"),
            "stokkodu" => $this->input->post("stokkodu"),
            "alis" => $this->input->post("alis"),
            "satis" => $this->input->post("satis"),
            "indirimli" => $this->input->post("indirimli"),
            "kg" => $this->input->post("kg")
        );
        $aciklama = $this->input->post("aciklama");
        if(isset($aciklama)){
            $veri["aciklama"] = $aciklama; 
        }
        return $veri;
    }
    public function urunGetir($id, $isArray = FALSE){
        $urun = $this->db->reset_query()->where(array("id" => $id))->get($this->urunlerTabloAdi());
        if($isArray){
            return $urun->result_array();
        }else{
            return $urun->result();
        }
    }
}
?>