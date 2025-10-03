<?php

require FCPATH . 'composer/google-api/vendor/autoload.php';
use Kedniko\FCM\FCM;
class Kullanicilar_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function girisUyari($konum = "", $hata = "")
    {
        echo '<script>
        var r = confirm("' . ($hata == "" ? "Bu işlemi gerçekleştirmek için gerekli yetkiniz bulunmuyor!" : $hata) . '");
        if (r == true) {
            window.location.replace("' . base_url($konum) . '");
        }else{
            window.location.replace("' . base_url($konum) . '");
        }</script>';
    }
    public function kullanicilarTabloAdi()
    {
        return DB_ON_EK_STR . "kullanicilar";
    }
    public function kullaniciAuthTabloAdi()
    {
        return DB_ON_EK_STR . "kullanici_auth";
    }
    public function kullaniciBildirimleriTabloAdi()
    {
        return DB_ON_EK_STR . "kullanici_bildirimleri";
    }

    public function kullaniciTablosu($id = "", $kullanici_adi = "", $ad_soyad = "", $sifre = "", $yonetici = 0, $teknikservis = 0, $urunduzenleme = 0, $musteri = 0, $tema = "oto")
    {
        return array(
            "id" => $id,
            "kullanici_adi" => $kullanici_adi,
            "ad_soyad" => $ad_soyad,
            "sifre" => $sifre,
            "yonetici" => $yonetici,
            "teknikservis" => $teknikservis,
            "urunduzenleme" => $urunduzenleme,
            "musteri" => $musteri,
            "tema" => $tema,
        );
    }

    public function kullaniciBilgileri()
    {
        if ($this->Giris_Model->kullaniciTanimi()) {
            $kullaniciTablo = $this->db->reset_query()->where("id", $_SESSION["KULLANICI_ID"])->get($this->kullanicilarTabloAdi());
            if ($kullaniciTablo->num_rows() > 0) {
                $kullanici = $kullaniciTablo->result()[0];
                return $this->kullaniciTablosu($kullanici->id, $kullanici->kullanici_adi, $kullanici->ad_soyad, $kullanici->sifre, $kullanici->yonetici, $kullanici->teknikservis, $kullanici->urunduzenleme, $kullanici->musteri, $kullanici->tema);
            } else {
                return $this->kullaniciTablosu();
            }
        } else {
            return $this->kullaniciTablosu();
        }
    }
    public function yonetici()
    {
        return $this->kullaniciBilgileri()["yonetici"] == 1;
    }
    public function kullaniciGetir($id = "")
    {
        return $this->db->reset_query()->where(array("id" => $id))->get($this->kullanicilarTabloAdi())->result();
    }
    public function kullanicilar($where = array())
    {
        $kullanici_adi_var = False;
        foreach ($where as $key => $value) {
            if (substr($key, 0, 13) == "kullanici_adi") {
                $kullanici_adi_var = True;
            }
        }
        if (!$kullanici_adi_var) {
            $where["kullanici_adi !="] = "OZAY";
        }
        return $this->db->reset_query()->where($where)->get($this->kullanicilarTabloAdi())->result();
    }
    public function tekKullanici($id)
    {
        $sonuc = $this->db->reset_query()->where(array("id" => $id))->get($this->kullanicilarTabloAdi());
        if ($sonuc->num_rows() > 0) {
            return $sonuc->result()[0];
        } else {
            return null;
        }
    }
    public function tekKullanici_array($id)
    {
        $sonuc = $this->db->reset_query()->where(array("id" => $id))->get($this->kullanicilarTabloAdi());
        if ($sonuc->num_rows() > 0) {
            return $sonuc->result_array()[0];
        } else {
            return null;
        }
    }
    public function tekKullaniciIsım($isim)
    {
        $sonuc = $this->db->reset_query()->where(array("ad_soyad" => $isim))->get($this->kullanicilarTabloAdi());
        if ($sonuc->num_rows() > 0) {
            return $sonuc->result()[0];
        } else {
            return null;
        }
    }
    public function tekKullaniciAdi($kullaniciAdi)
    {
        $sonuc = $this->db->reset_query()->where(array("kullanici_adi" => $kullaniciAdi))->get($this->kullanicilarTabloAdi());
        if ($sonuc->num_rows() > 0) {
            return $sonuc->result()[0];
        } else {
            return null;
        }
    }

    public $format = "Y-m-d H:i:s";
    public $bitisZamani = (7 * 24 * 60 * 60);
    public function ekle($veri)
    {
        return $this->db->reset_query()->insert($this->kullanicilarTabloAdi(), $veri);
    }
    public function duzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->kullanicilarTabloAdi(), $veri);
    }
    public function sil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->kullanicilarTabloAdi());
    }
    public function authOlustur($kullaniciBilgileri, $auth, $cihazID){

        ///2024-12-22 10:46:21.00000
        $bitis = time() + $this->Kullanicilar_Model->bitisZamani;
        $veri = array(
            "kullanici_id" => $kullaniciBilgileri->id,
            "auth" => $auth,
            "bitis" => date($this->Kullanicilar_Model->format, $bitis),
            "cihazID" => $cihazID,
        );
        if (isset($fcmToken)) {
            $this->Kullanicilar_Model->fcmTokenSifirla($fcmToken);
            $veri["fcmToken"] = $fcmToken;
        }
        $this->Kullanicilar_Model->authEkle($veri);
    }
    public function authEkle($veri)
    {
        $query = $this->db->reset_query()->where(array("cihazID" => $veri["cihazID"]))->get($this->kullaniciAuthTabloAdi());
        if ($query->num_rows() > 0) {
            return $this->db->reset_query()->where("cihazID", $veri["cihazID"])->update($this->kullaniciAuthTabloAdi(), $veri);
        } else {
            return $this->db->reset_query()->insert($this->kullaniciAuthTabloAdi(), $veri);
        }
    }
    public function authSil($auth)
    {
        return $this->db->reset_query()->where("auth", $auth)->delete($this->kullaniciAuthTabloAdi());
    }
    public function authDuzenle($auth, $veri)
    {
        return $this->db->reset_query()->where("auth", $auth)->update($this->kullaniciAuthTabloAdi(), $veri);
    }
    public function gecerliAuth($auth)
    {
        $query = $this->db->reset_query()->where("auth", $auth)->get($this->kullaniciAuthTabloAdi());
        if ($query->num_rows() > 0) {
            $sonuc = $query->result()[0];
            if ($this->gecerliAuthTarih($sonuc->bitis)) {
                return TRUE;
            }
        }
        return FALSE;
    }
    public function gecerliAuthTarih($bitis)
    {
        $bitis = DateTime::createFromFormat($this->format, $bitis)->getTimestamp();
        $guncel = time();
        return $guncel < $bitis;
    }

    public function fcmTokenSifirla($fcmToken)
    {
        return $this->db->reset_query()->where("fcmToken", $fcmToken)->update($this->kullaniciAuthTabloAdi(), array("fcmToken" => ""));
    }
    public function bildirimGonder($id, $baslik = "", $icerik = "", $tip = "standart", $bildirimID = "0")
    {
        if($this->firebaseAyarlandi()){
            $query = $this->db->reset_query()->where(array("kullanici_id" => $id))->get($this->Kullanicilar_Model->kullaniciAuthTabloAdi());

            if ($query->num_rows() > 0) {

                $query = $query->result();
                $authKeyContent = json_decode(file_get_contents(FCPATH . "assets/biltek-teknik-servis-firebase-adminsdk-blxjr-56f5e63332.json"), true);
                $bearerToken = FCM::getBearerToken($authKeyContent);
                foreach ($query as $row) {
                    if (strlen($row->fcmToken) > 0) {
                        $body = [
                            'message' => [
                                'token' => $row->fcmToken,
                                'data' => [
                                    'title' => $baslik,
                                    'body' => $icerik,
                                    'tip'=> $tip,
                                    'id' => $bildirimID,
                                ],
                            ],
                        ];
                        try {
                            FCM::send($bearerToken, FIREBASE_CONFIG["projectId"], $body);
                        } catch (Exception $e) {

                        }
                    }
                }
            }
        }
    }
    public function bildirimGonderCihaz($id, $cihaz_id)
    {
        $bildirimler = $this->bildirimleriGetirKullaniciTur($id, "cihaz");

        $cihaz = $this->Cihazlar_Model->cihazBul($cihaz_id);
        if ($cihaz->num_rows() > 0) {
            $cihaz = $cihaz->result()[0];
            $baslik = 'Yeni cihaz girişi yapıldı.';
            $mesaj = $cihaz->musteri_adi . " - " . $cihaz->cihaz . "" . (strlen($cihaz->cihaz_modeli) > 0 ? " " . $cihaz->cihaz_modeli : "") . " - " . $cihaz->ariza_aciklamasi;
            if (count($bildirimler) > 0) {
                $bildirim = $bildirimler[0];
                if (strval($bildirim->durum) == "1") {
                    $this->bildirimGonder($id, $baslik, $mesaj, "cihaz", $cihaz->servis_no);
                }
            }else{
                $this->bildirimGonder($id, $baslik, $mesaj, "cihaz",  $cihaz->servis_no);
            }
        }
    }
    public function bildirimGonderCagri($tur_id, $cagri_id, $tip = "")
    {
        if(strlen($tip) == 0) {
            return;
        }
        $bildirimler = $this->bildirimleriGetirTur("cagri-" . $tur_id);
        $cagri = $this->Cihazlar_Model->cagriKaydiGetir($cagri_id);
        if ($cagri != null) {
            foreach ($bildirimler as $bildirim) {
                if (strval($bildirim->durum) == "1") {
                    $baslik = 'Yeni Çağrı Kaydı';
                    $mesaj = "";
                    
                    $cihaz = $this->Cihazlar_Model->cagriCihazi($cagri->id);
                    if($cihaz != null){
                        $mesaj .= $cihaz->servis_no . " - ";
                    }
                    $mesaj .= $cagri->bolge . " " . $cagri->birim . " - " . $cagri->cihaz . "" . (strlen($cagri->cihaz_modeli) > 0 ? " " . $cagri->cihaz_modeli : "") . " - " . $cagri->ariza_aciklamasi;
                    if ($tip == "fiyatonay") {
                        $baslik = 'Çağrı Kaydı Fiyatı Onaylandı';
                    } else if ($tip == 'fiyatret') {
                        $baslik = 'Çağrı Kaydı Fiyatı Reddedildi';
                    }
                    $this->bildirimGonder($bildirim->kullanici_id, $baslik, $mesaj, "cagri", $cagri->id);
                }
            }
        }
    }
    public function girisDurumuAuth($auth)
    {
        $query = $this->db->reset_query()->where(array("auth" => $auth))->get($this->kullaniciAuthTabloAdi());
        if ($query->num_rows() > 0) {
            $sonuc = $query->result()[0];
            if ($this->gecerliAuthTarih($sonuc->bitis)) {
                return $this->tekKullanici_array($sonuc->kullanici_id);
            } else {
                $this->authSil($auth);
            }
        } else {
            return array();
        }
    }
    public function kullaniciPost($yonetici_dahil = false)
    {
        $veri = array(
            "kullanici_adi" => $this->input->post("kullanici_adi"),
            "ad_soyad" => $this->input->post("ad_soyad"),
            "sifre" => $this->input->post("sifre"),
            "urunduzenleme" => 0,
            "teknikservis" => 0,
            "yonetici" => 0,
            "musteri" => 0,
        );
        $teknikservis = $this->input->post("teknikservis");
        $urunduzenleme = $this->input->post("urunduzenleme");
        if (isset($teknikservis)) {
            $veri["teknikservis"] = $teknikservis;
        }
        if (isset($urunduzenleme)) {
            $veri["urunduzenleme"] = $urunduzenleme;
        }
        $yonetici = $this->input->post("yonetici");
        if ($yonetici_dahil && isset($yonetici)) {
            $veri["yonetici"] = $yonetici;
        }
        return $veri;
    }
    public function kullaniciAdiKontrol($kullanici_adi)
    {
        $where = array(
            "kullanici_adi" => $kullanici_adi
        );
        $query = $this->db->reset_query()->where($where)->get($this->kullanicilarTabloAdi());
        return !($query->num_rows() > 0);
    }
    public function musteriBilgileri()
    {
        $this->load->model("Firma_Model");
        return $this->db->reset_query()->order_by("musteri_adi", "ASC")->get($this->Firma_Model->musteriTablosu())->result();
    }
    public function musteriPost($veri)
    {
        return array(
            "musteri_adi" => $this->input->post("musteri_adi"),
            "adres" => $this->input->post("adres"),
            "telefon_numarasi" => $this->input->post("telefon_numarasi")
        );
    }
    public function musteriEkle($veri)
    {
        return $this->db->reset_query()->insert($this->Firma_Model->musteriTablosu(), $veri);
    }
    public function musteriDuzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->Firma_Model->musteriTablosu(), $veri);
    }
    public function musteriSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->Firma_Model->musteriTablosu());
    }
    public function bildirimleriGetirTur($tur)
    {
        return $this->db->reset_query()->where(array("tur" => $tur))->get($this->kullaniciBildirimleriTabloAdi())->result();
    }
    public function bildirimleriGetirKullaniciTur($kullanici_id, $tur)
    {
        return $this->db->reset_query()->where(array("kullanici_id" => $kullanici_id, "tur" => $tur))->get($this->kullaniciBildirimleriTabloAdi())->result();
    }
    public function bildirimleriGetir($kullanici_id)
    {
        return $this->db->reset_query()->where(array("kullanici_id" => $kullanici_id))->get($this->kullaniciBildirimleriTabloAdi())->result();
    }
    public function bildirimAyarla($kullanici_id, $tur, $durum)
    {
        $whereVeri = array(
            "kullanici_id" => $kullanici_id,
            "tur" => $tur,
        );
        $bildirim = $this->db->reset_query()->where($whereVeri)->get($this->kullaniciBildirimleriTabloAdi());
        $durumDuz = strval($durum);
        if (is_bool($durum)) {
            $durumDuz = $durum ? "1" : "0";
        } else if (is_numeric($durum)) {
            $durumDuz = $durum == 1 ? "1" : "0";
        } else if (is_string($durum)) {
            if ($durum == "1") {
                $durumDuz = "1";
            } else if (strtolower($durum) == "true") {
                $durumDuz = "1";
            } else {
                $durumDuz = "0";
            }
        }
        if ($bildirim->num_rows() > 0) {
            return $this->db->reset_query()->where($whereVeri)->update($this->kullaniciBildirimleriTabloAdi(), array(
                "durum" => $durumDuz == "1" ? 1 : 0,
            ));
        } else {
            return $this->db->reset_query()->insert($this->kullaniciBildirimleriTabloAdi(), array(
                "kullanici_id" => $kullanici_id,
                "tur" => $tur,
                "durum" => $durumDuz == "1" ? 1 : 0,
            ));
        }

    }
    public function firebaseAyarlandi(){
        if(defined("FIREBASE_CONFIG")){
            if(isset(FIREBASE_CONFIG["apiKey"]) && strlen(FIREBASE_CONFIG["apiKey"]) > 0
                && isset(FIREBASE_CONFIG["authDomain"]) && strlen(FIREBASE_CONFIG["authDomain"]) > 0
                && isset(FIREBASE_CONFIG["projectId"]) && strlen(FIREBASE_CONFIG["projectId"]) > 0
                && isset(FIREBASE_CONFIG["storageBucket"]) && strlen(FIREBASE_CONFIG["storageBucket"]) > 0
                && isset(FIREBASE_CONFIG["messagingSenderId"]) && strlen(FIREBASE_CONFIG["messagingSenderId"]) > 0
                && isset(FIREBASE_CONFIG["appId"]) && strlen(FIREBASE_CONFIG["appId"]) > 0
                && isset(FIREBASE_CONFIG["webPushCertificates"]) && strlen(FIREBASE_CONFIG["webPushCertificates"]) > 0
            ){
                return TRUE;
            }
        }
        return FALSE;
    }
}
