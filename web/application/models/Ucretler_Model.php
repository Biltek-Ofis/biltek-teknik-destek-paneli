<?php
class Ucretler_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Islemler_Model");
    }
    public function tabloAdi()
    {
        return DB_ON_EK_STR . "ucretler";
    }
    public function kategoriTabloAdi()
    {
        return DB_ON_EK_STR . "ucretler_kat";
    }

    public function kategoriler(){
        return $this->db->reset_query()->get($this->kategoriTabloAdi())->result();
    }
    public function kategoriEkle(){
        $post = $this->kategoriPost();
        $resp = array();
        if(!isset($post["isim"])){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "İsim gönderilmedi.";
        }
        $kategori = $this->kategoriBul("", $post["isim"]);
        if($kategori->num_rows() > 0){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "Bu isimde bir kategori zaten mevcut.";
        }
        if(!isset($resp["sonuc"])){
            $olustur = $this->db->reset_query()->insert($this->kategoriTabloAdi(), $post);
            $resp["sonuc"] =  $olustur;
            $resp["mesaj"] = $this->db->error()["message"];
        }
        return $resp;
    }
    public function kategoriDuzenle($id){
        $post = $this->kategoriPost();
        $resp = array();
        if(!isset($post["isim"])){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "İsim gönderilmedi.";
        }
        $kategori = $this->kategoriBul($id);
        if($kategori->num_rows() == 0){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "ID bulunamadı.";
        }
        $kategori2 = $this->kategoriBul("", $post["isim"]);
        if($kategori2->num_rows() > 0){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "Bu isimde bir kategori zaten mevcut.";
        }
        if(!isset($resp["sonuc"])){
            $olustur = $this->db->reset_query()->where("id", $id)->update($this->kategoriTabloAdi(), $post);
            $resp["sonuc"] =  $olustur;
            $resp["mesaj"] = $this->db->error()["message"];
        }
        return $resp;
    }
    public function kategoriSil($id){
        $kategori = $this->kategoriBul($id);
        if($kategori == null){
            return FALSE;
        }
        if($kategori->num_rows() > 0){
            return $this->db->reset_query()->where("id", $id)->delete($this->kategoriTabloAdi());
        }
        return FALSE;
    }
    public function kategoriBul($id = "", $isim = ""){
        $where = array();
        if(strlen($id) > 0){
            $where["id"] = $id;
        }
        if(strlen($isim) > 0){
            $where["isim"] = $isim;
        }
        if(count($where) > 0){
            return $this->db->reset_query()->where($where)->get($this->kategoriTabloAdi());
        }else{
            return null;
        }
    }
    public function kategoriPost(){
        $veri = array();
        $isim = $this->input->post("isim");
        if(isset($isim)){
             $veri["isim"] = $this->input->post("isim");
        }
        return $veri;
    }

    // Ücretler

    public function ucretler($isim = ""){
        $query = $this->db->reset_query();
        if(strlen($isim) > 0){
            $query = $query->like("isim", $isim);
        }
        return $query->order_by("cat_id ASC, id ASC")->get($this->tabloAdi())->result();
    }
    public function ucretEkle(){
        $post = $this->ucretPost();
        $resp = array();
        if(!isset($post["cat_id"]) || !isset($post["isim"]) || !isset($post["ucret"])){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "Eksik veri.";
        }
        $ucret = $this->ucretBul("", $post["isim"], $post["cat_id"]);
        if($ucret->num_rows() > 0){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "Bu kategoride bu ücret adı zaten mevcut";
        }
        if(!isset($resp["sonuc"])){
            $olustur = $this->db->reset_query()->insert($this->tabloAdi(), $post);
            $resp["sonuc"] =  $olustur;
            $resp["mesaj"] = $this->db->error()["message"];
        }
        return $resp;
    }
    public function ucretDuzenle($id){
        $post = $this->ucretPost();
        $resp = array();
        if(!isset($post["cat_id"]) || !isset($post["isim"]) || !isset($post["ucret"])){
            $resp["sonuc"] = FALSE;
            $resp["mesaj"] = "Eksik veri.";
        }
        if(!isset($resp["sonuc"])){
            $olustur = $this->db->reset_query()->where("id", $id)->update($this->tabloAdi(), $post);
            $resp["sonuc"] =  $olustur;
            $resp["mesaj"] = $this->db->error()["message"];
        }
        return $resp;
    }
    public function ucretSil($id){
        $ucret = $this->ucretBul($id);
        if($ucret == null){
            return FALSE;
        }
        if($ucret->num_rows() > 0){
            return $this->db->reset_query()->where("id", $id)->delete($this->tabloAdi());
        }
        return FALSE;
    }
    public function ucretBul($id = "", $isim = "", $cat_id = ""){
        $where = array();
        if(strlen($id) > 0){
            $where["id"] = $id;
        }
        if(strlen($isim) > 0){
            $where["isim"] = $isim;
        }
        if(strlen($cat_id) > 0){
            $where["cat_id"] = $cat_id;
        }
        if(count($where) > 0){
            return $this->db->reset_query()->where($where)->get($this->tabloAdi());
        }else{
            return null;
        }
    }
    public function ucretPost(){
        $veri = array();
        $cat_id = $this->input->post("cat_id");
        if(isset($cat_id)){
             $veri["cat_id"] = $this->input->post("cat_id");
        }
        $isim = $this->input->post("isim");
        if(isset($isim)){
             $veri["isim"] = $this->input->post("isim");
        }
        $ucret = $this->input->post("ucret");
        if(isset($ucret)){
             $veri["ucret"] = $this->input->post("ucret");
        }
        return $veri;
    }
}