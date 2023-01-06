<?php
class Giris_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function kullaniciGiris()
    {
        if($this-> kullaniciTanimi()){
            $this->load->model("Kullanicilar_Model");
            return $this->Kullanicilar_Model->kullaniciBilgileri()["id"] != "";
        }else{
            return false;
        }
    }
    public function kullaniciTanimi(){
        return isset($_SESSION["KULLANICI_ID"]);
    }
    public function girisDurumu($kullanici_adi, $sifre)
    {
        //Şifreleme $this->Islemler_Model->sifrele($sifre);
        //Varsayılan şifre (123456) $2y$10$b0wKhP9Nq5JhjJGH8cS61e20BwaepxxovalwslAZUbX3F3gBQcycm
        $this->load->model("Kullanicilar_Model");
        $query = $this->db->limit(1)->where('kullanici_adi', $kullanici_adi)->get($this->Kullanicilar_Model->kullanicilarTabloAdi());
        if ($query->num_rows() > 0) {
            if (password_verify($sifre, $query->result()[0]->sifre)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function kullaniciOturumAc($kullanici_adi)
    {
        $this->load->model("Kullanicilar_Model");
        $query = $this->db->limit(1)->where('kullanici_adi', $kullanici_adi)->get($this->Kullanicilar_Model->kullanicilarTabloAdi());
        if ($query->num_rows() > 0) {
            $_SESSION["KULLANICI_ID"] = $query->result()[0]->id;
        }
    }
    public function oturumSifirla()
    {
        unset($_SESSION["KULLANICI_ID"]);
    }
}
