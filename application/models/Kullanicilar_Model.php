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

    public function kullaniciTablosu($id = "", $kullanici_adi = "", $isim = ""){
        return array(
            "id"=> $id,
            "kullanici_adi"=> $kullanici_adi,
            "isim"=> $isim,
        );
    }

    public function kullaniciBilgileri(){
        if($this->Giris_Model->kullaniciGiris()){
            $kullanici = $this->db->where("kullanici_adi", $_SESSION["KULLANICI"])->get($this->kullanicilarTablosu)->result()[0];
            return $this->kullaniciTablosu($kullanici->id, $kullanici->kullanici_adi, $kullanici->isim);
        }else{
            return $this->kullaniciTablosu();
        }
    }
}
?>