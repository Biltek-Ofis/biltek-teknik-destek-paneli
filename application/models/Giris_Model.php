<?php
class Giris_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function kullaniciGiris()
    {
        return isset($_SESSION["KULLANICI_ID"]);
    }
    public function girisDurumu($kullanici_adi, $sifre)
    {
        //Şifreleme $this->Islemler_Model->sifrele($sifre);
        $query = $this->db->limit(1)->where('kullanici_adi', $kullanici_adi)->get("Kullanicilar");
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
        $query = $this->db->limit(1)->where('kullanici_adi', $kullanici_adi)->get("Kullanicilar");
        if ($query->num_rows() > 0) {
            $_SESSION["KULLANICI_ID"] = $query->result()[0]->id;
        }
    }
    public function oturumSifirla()
    {
        unset($_SESSION["KULLANICI_ID"]);
    }
}
