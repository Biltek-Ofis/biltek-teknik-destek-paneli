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
    public function temalarTabloAdi()
    {
        return DB_ON_EK_STR . "temalar";
    }
    public function getir(){
        return $this->db->reset_query()->get($this->tabloAdi())->result()[0];
    }
    public function duzenle($veri){
        return $this->db->reset_query()->update($this->tabloAdi(), $veri);
    }
    public function kar_yagisi(){
        $tema = $this->kullaniciTema();
        if($tema == null){
            return FALSE;
        }else{
            return $tema->kar_yagisi == 1;
        }
    }
    public function temalar(){
        return $this->db->reset_query()->get($this->temalarTabloAdi())->result();
    }
    public function siteTema(){
        $ayarlar = $this->getir();
        $tema = $this->db->reset_query()->where("id", $ayarlar->tema)->get($this->temalarTabloAdi());
        if($tema->num_rows() > 0){
            return $tema->result()[0];
        }else{
            return $this->bosTema();
        }
    }
    public function kullaniciTema(){
        $kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
        $ayarlar = $this->getir();
        $temaID  = $ayarlar->tema;
        if(strlen($kullanici["ad_soyad"]) > 0){
            if($kullanici["tema"] != 0){
                $temaID = $kullanici["tema"];
            }
        }
        $tema = $this->db->reset_query()->where("id", $temaID)->get($this->temalarTabloAdi());
        if($tema->num_rows() > 0){
            return $tema->result()[0];
        }else{
            return $this->bosTema();
        }
    }
    public function kullaniciAsilTema(){
        $kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
        if(strlen($kullanici["ad_soyad"]) > 0){
            $tema = $this->db->reset_query()->where("id", $kullanici["tema"])->get($this->temalarTabloAdi());
            if($tema->num_rows() > 0){
                return $tema->result()[0];
            }
        }
        return $this->bosTema();
    }
    public function bosTema(){
        $tema = new stdClass;
        $tema->id = 0;
        $tema->isim = "Otomatik";
        $tema->arkaplan	= "";
        $tema->yazi_rengi = "";
        $tema->giris_arkaplani = "";
        $tema->beyaz_arkaplan_yazi = "";
        $tema->menu_icon_rengi = "";
        $tema->kar_yagisi = 0;
        $tema->onizleme_resmi = "";
        return $tema;
    }
}
?>