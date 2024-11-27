<?php
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
    public function kullanicilarTabloAdi() {
        return DB_ON_EK_STR."kullanicilar";
    }

    public function kullaniciTablosu($id = "", $kullanici_adi = "", $ad_soyad = "", $sifre = "", $yonetici = 0, $teknikservis = 0, $urunduzenleme = 0)
    {
        return array(
            "id" => $id,
            "kullanici_adi" => $kullanici_adi,
            "ad_soyad" => $ad_soyad,
            "sifre" => $sifre,
            "yonetici" => $yonetici,
            "teknikservis" => $teknikservis,
            "urunduzenleme" => $urunduzenleme
        );
    }

    public function kullaniciBilgileri()
    {
        if ($this->Giris_Model->kullaniciTanimi()) {
            $kullaniciTablo = $this->db->reset_query()->where("id", $_SESSION["KULLANICI_ID"])->get($this->kullanicilarTabloAdi());
            if ($kullaniciTablo->num_rows() > 0) {
                $kullanici = $kullaniciTablo->result()[0];
                return $this->kullaniciTablosu($kullanici->id, $kullanici->kullanici_adi, $kullanici->ad_soyad, $kullanici->sifre, $kullanici->yonetici, $kullanici->teknikservis, $kullanici->urunduzenleme);
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
        return $this->db->reset_query()->where(array("id"=> $id))->get($this->kullanicilarTabloAdi())->result();
    }
    public function kullanicilar($where = array()){
        $kullanici_adi_var = False;
        foreach($where as $key => $value){
            if (substr($key, 0, 13) == "kullanici_adi") {
                $kullanici_adi_var = True;
            }
        }
        if(!$kullanici_adi_var){
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
    public function kullaniciPost($yonetici_dahil = false)
    {
        $veri = array(
            "kullanici_adi" => $this->input->post("kullanici_adi"),
            "ad_soyad" => $this->input->post("ad_soyad"),
            "sifre" => $this->input->post("sifre"),
            "teknikservis" => $this->input->post("teknikservis"),
            "urunduzenleme" => $this->input->post("urunduzenleme"),
        );
        if ($yonetici_dahil) {
            $veri["yonetici"] = $this->input->post("yonetici");
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
    public function musteriBilgileri(){
        $this->load->model("Firma_Model");
        return $this->db->reset_query()->get($this->Firma_Model->musteriTablosu())->result();
    }
    public function musteriPost($veri){
        return array(
            "musteri_adi" => $this->input->post("musteri_adi"),
            "adres" => $this->input->post("adres"),
            "telefon_numarasi" => $this->input->post("telefon_numarasi")
        );
    }
    public function musteriEkle($veri){
        return $this->db->reset_query()->insert($this->Firma_Model->musteriTablosu(), $veri);
    }
    public function musteriDuzenle($id, $veri){
        return $this->db->reset_query()->where("id", $id)->update($this->Firma_Model->musteriTablosu(), $veri);
    }
    public function musteriSil($id){
        return $this->db->reset_query()->where("id", $id)->delete($this->Firma_Model->musteriTablosu());
    }
}
