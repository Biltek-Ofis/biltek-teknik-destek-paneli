<?php
class Giris_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function kullaniciGiris()
    {
        return isset($_SESSION["KULLANICI"]);
    }
    public function girisDurumu($kullanici_adi, $sifre)
    {
        //Şifreleme password_hash("123456", PASSWORD_DEFAULT);
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
        $_SESSION["KULLANICI"] = $kullanici_adi;
    }
    public function oturumSifirla()
    {
        unset($_SESSION["KULLANICI"]);
    }
}
