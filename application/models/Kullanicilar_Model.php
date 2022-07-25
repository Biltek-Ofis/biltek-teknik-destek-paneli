<?php
class Kullanicilar_Model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function girisUyari($konum){
        echo '<script>
        var r = confirm("Bu işlemi gerçekleştirmek için gerekli yetkiniz bulunmuyor!");
        if (r == true) {
            window.location.replace("'.base_url($konum).'");
        }else{
            window.location.replace("'.base_url($konum).'");
        }</script>';
    }
    public $kullanicilarTablosu = "Kullanicilar";

    public function kullaniciTablosu($id = "", $kullanici_adi = "", $ad = "", $soyad = ""){
        return array(
            "id"=> $id,
            "kullanici_adi"=> $kullanici_adi,
            "ad"=> $ad,
            "soyad"=> $soyad,
        );
    }

    public function kullaniciBilgileri(){
        if($this->Giris_Model->kullaniciGiris()){
            $kullanici = $this->db->where("kullanici_adi", $_SESSION["KULLANICI"])->get($this->kullanicilarTablosu)->result()[0];
            return $this->kullaniciTablosu($kullanici->id, $kullanici->kullanici_adi, $kullanici->ad, $kullanici->soyad);
        }else{
            return $this->kullaniciTablosu();
        }
    }
}
?>