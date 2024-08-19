<?php
class Ayarlar_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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
}
?>