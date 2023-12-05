<?php
class Cihazlar_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function cihazlarTabloAdi()
    {
        return getenv(DB_ON_EK_STR) . "cihazlar";
    }
    public function islemlerTabloAdi()
    {
        return getenv(DB_ON_EK_STR) . "islemler";
    }
    public function cihazTurleriTabloAdi()
    {
        return getenv(DB_ON_EK_STR) . "cihazturleri";
    }
    public function silinenCihazlarTabloAdi()
    {
        return getenv(DB_ON_EK_STR) . "silinencihazlar";
    }
    public function medyalarTabloAdi()
    {
        return getenv(DB_ON_EK_STR) . "medyalar";
    }
    
    public function tahsilatSekilleriTabloAdi()
    {
        return getenv(DB_ON_EK_STR) . "tahsilatsekilleri";
    }
    public function musterileriAktar()
    {
        $this->load->model("Firma_Model");
        $cihazlar = $this->db->reset_query()->order_by("tarih", "DESC")->group_by("musteri_adi")->get($this->cihazlarTabloAdi())->result();
        foreach($cihazlar as $cihaz){
            $this->db->reset_query()->insert($this->Firma_Model->musteriTablosu(), array(
                "musteri_adi" => $cihaz->musteri_adi,
                "adres" => $cihaz->adres,
                "telefon_numarasi" => $cihaz->telefon_numarasi
            ));
            $son_eklenen = $this->db->insert_id();
            $this->db->reset_query()->where("musteri_adi", $cihaz->musteri_adi)->update($this->cihazlarTabloAdi(),array(
                "musteri_kod" => $son_eklenen
            ));
        }
    }
    public function yapilanIslemleriAktar()
    {
        $cihazlar = $this->db->reset_query()->order_by("id", "ASC")->get($this->cihazlarTabloAdi())->result();
        foreach($cihazlar as $cihaz){
            if(isset($cihaz->i_ad_1)){
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 1,
                    "ad" => $cihaz->i_ad_1,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_1,
                    "miktar" => $cihaz->i_miktar_1,
                    "kdv" => $cihaz->i_kdv_1
                ));
            }
            if(isset($cihaz->i_ad_2)){
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 2,
                    "ad" => $cihaz->i_ad_2,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_2,
                    "miktar" => $cihaz->i_miktar_2,
                    "kdv" => $cihaz->i_kdv_2
                ));
            }
            if(isset($cihaz->i_ad_3)){
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 3,
                    "ad" => $cihaz->i_ad_3,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_3,
                    "miktar" => $cihaz->i_miktar_3,
                    "kdv" => $cihaz->i_kdv_3
                ));
            }
            if(isset($cihaz->i_ad_4)){
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 4,
                    "ad" => $cihaz->i_ad_4,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_4,
                    "miktar" => $cihaz->i_miktar_4,
                    "kdv" => $cihaz->i_kdv_4
                ));
            }
            if(isset($cihaz->i_ad_5)){
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 5,
                    "ad" => $cihaz->i_ad_5,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_5,
                    "miktar" => $cihaz->i_miktar_5,
                    "kdv" => $cihaz->i_kdv_5
                ));
            }
            if(isset($cihaz->i_ad_6)){
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 6,
                    "ad" => $cihaz->i_ad_6,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_6,
                    "miktar" => $cihaz->i_miktar_6,
                    "kdv" => $cihaz->i_kdv_6
                ));
            }
        }
    }
    public function cihazBul($id)
    {
        return $this->db->reset_query()->where("id", $id)->limit(1)->get($this->cihazlarTabloAdi());
    }
    public function takipNumarasi($takip_numarasi)
    {
        $bul = array(
            "takip_numarasi" => $takip_numarasi,
        );
        return $this->db->reset_query()->where($bul)->limit(1)->get($this->cihazlarTabloAdi());
    }
    public function cihazTuru($tur_id)
    {
        $query = $this->db->reset_query()->where("id", $tur_id)->get($this->cihazTurleriTabloAdi());
        if ($query->num_rows() > 0) {
            return $query->result()[0]->isim;
        } else {
            return "Belirtilmemiş";
        }
    }
    public function cihazTurleri()
    {
        return $this->db->reset_query()->get($this->cihazTurleriTabloAdi())->result();
    }
    public function cihazTuruEkle($veri)
    {
        return $this->db->reset_query()->insert($this->cihazTurleriTabloAdi(), $veri);
    }
    public function cihazTuruDuzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->cihazTurleriTabloAdi(), $veri);
    }
    public function cihazTuruSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->cihazTurleriTabloAdi());
    }
    public function cihazTuruPost()
    {
        $veri = array(
            "isim" => $this->input->post("isim"),
            "sifre" => $this->input->post("sifre"),
        );
        return $veri;
    }
    public function tahsilatSekli($tur_id)
    {
        $query = $this->db->reset_query()->where("id", $tur_id)->get($this->tahsilatSekilleriTabloAdi());
        if ($query->num_rows() > 0) {
            return $query->result()[0]->isim;
        } else {
            return "";
        }
    }
    public function tahsilatSekilleri()
    {
        return $this->db->reset_query()->get($this->tahsilatSekilleriTabloAdi())->result();
    }
    public function tahsilatSekliEkle($veri)
    {
        return $this->db->reset_query()->insert($this->tahsilatSekilleriTabloAdi(), $veri);
    }
    public function tahsilatSekliDuzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->tahsilatSekilleriTabloAdi(), $veri);
    }
    public function tahsilatSekliSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->tahsilatSekilleriTabloAdi());
    }
    public function tahsilatSekliPost()
    {
        $veri = array(
            "isim" => $this->input->post("isim"),
        );
        return $veri;
    }
    public function cihazVerileriniDonustur($result)
    {
        $this->load->model("Islemler_Model");
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->tarih = $this->Islemler_Model->tarihDonustur($result[$i]->tarih);
            $result[$i]->bildirim_tarihi = $this->Islemler_Model->tarihDonustur($result[$i]->bildirim_tarihi);
            $result[$i]->cikis_tarihi = $this->Islemler_Model->tarihDonustur($result[$i]->cikis_tarihi);
            $result[$i]->cihaz_turu_val = $result[$i]->cihaz_turu;
            $result[$i]->cihaz_turu = $this->cihazTuru($result[$i]->cihaz_turu);
            $result[$i]->tahsilat_sekli_val = $result[$i]->tahsilat_sekli;
            $result[$i]->tahsilat_sekli = $this->tahsilatSekli($result[$i]->tahsilat_sekli);
            $sorumlu_per = $this->Kullanicilar_Model->tekKullanici($result[$i]->sorumlu);
            $result[$i]->sorumlu_val = $result[$i]->sorumlu;
            $result[$i]->sorumlu = isset($sorumlu_per) ? $sorumlu_per->ad_soyad : "Atanmamış";
            $result[$i]->islemler = $this->islemleriGetir($result[$i]->id);
        }
        return $result;
    }
    public function cihazlar()
    {
        $result = $this->db->reset_query()->order_by("id", "DESC")->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function islemleriGetir($cihazID)
    {
        return $this->db->reset_query()->where("cihaz_id", $cihazID)->order_by("islem_sayisi", "ASC")->get($this->islemlerTabloAdi())->result();
    }
    public function cihazlarTekTur($tur)
    {
        $where = array(
            "cihaz_turu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonel($tur)
    {
        $where = array(
            "sorumlu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarJQ($id)
    {
        $where = array(
            "id >" => $id,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function tekCihazJQ($id)
    {
        $where = array(
            "id" => $id,
        );
        $result = $this->db->reset_query()->where($where)->limit(1)->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurJQ($tur, $id)
    {
        $where = array(
            "id >" => $id,
            "cihaz_turu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonelJQ($sorumlu_personel, $id)
    {
        $where = array(
            "id >" => $id,
            "sorumlu" => $sorumlu_personel,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTumuJQ($sorumlu = "", $spesifik = array())
    {
        $where = array();
        if ($sorumlu != "") {
            $where["sorumlu"] = $sorumlu;
        }
        $where_in = NULL;
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC');

        if(count($spesifik)>0){
            $result = $result->where_in("id", $spesifik);
        }
        $result = $result->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    
    public function sonCihazJQ($sorumlu = "")
    {
        $where = array();
        if ($sorumlu != "") {
            $where["sorumlu"] = $sorumlu;
        }
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->LIMIT(1)->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurTumuJQ($tur)
    {
        $where = array(
            "cihaz_turu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonelTumuJQ($sorumlu_personel)
    {
        $where = array(
            "sorumlu" => $sorumlu_personel,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public $telefon_numarasi_bos = "+90 (___) ___-____";
    public function cihazPost($yeni = TRUE)
    {
        $musteri_kod = $this->input->post("musteri_kod");
        $veri = array(
            "musteri_kod" => (strlen($musteri_kod) > 0) ? $musteri_kod : null,
            "musteri_adi" => $this->input->post("musteri_adi"),
            "adres" => $this->input->post("adres"),
            "cihaz_turu" => $this->input->post("cihaz_turu"),
            "cihaz" => $this->input->post("cihaz"),
            "cihaz_modeli" => $this->input->post("cihaz_modeli"),
            "seri_no" => $this->input->post("seri_no"),
            "cihaz_sifresi" => $this->input->post("cihaz_sifresi"),
            "hasar_tespiti" => $this->input->post("hasar_tespiti"),
            "cihazdaki_hasar" => $this->input->post("cihazdaki_hasar"),
            "ariza_aciklamasi" => $this->input->post("ariza_aciklamasi"),
            "teslim_alinanlar" => $this->input->post("teslim_alinanlar"),
            "servis_turu" => $this->input->post("servis_turu"),
            "yedek_durumu" => $this->input->post("yedek_durumu"),
        );
        $tel_no = $this->input->post("telefon_numarasi");
        if(isset($tel_no)){
            if($tel_no == $this->telefon_numarasi_bos){
                $tel_no = "";
            }
            $veri["telefon_numarasi"] = $tel_no;
        }
        if($yeni){
            $veri["takip_numarasi"] = time();
        }
        $sorumlu = $this->input->post("sorumlu");
        if (isset($sorumlu)) {
            $veri["sorumlu"] = $sorumlu;
        }
        $tarih = $this->input->post("tarih");
        if (isset($tarih)) {
            $veri["tarih"] = $this->Islemler_Model->tarihDonusturSQL($tarih);
        }
        $tarih_girisi = $this->input->post("tarih_girisi");
        if (isset($tarih_girisi)) {
            if ($tarih_girisi == "oto") {
                $veri["tarih"] = $this->Islemler_Model->tarihDonusturSQLTime(time());
            }
        }
        return $veri;
    }
    public function cihazDuzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->cihazlarTabloAdi(), $veri);
    }
    public function islemDuzenle($id, $veri)
    {
        $konum = array(
            "cihaz_id" => $id,
            "islem_sayisi" => $veri["islem_sayisi"]
        );
        $islem_bul = $this->db->reset_query()->where($konum)->get($this->islemlerTabloAdi());
        if($islem_bul->num_rows() > 0){
            return $this->db->reset_query()->where($konum)->update($this->islemlerTabloAdi(), $veri);
        }else{
            return $this->db->reset_query()->insert($this->islemlerTabloAdi(), $veri);
        }
    }
    
    public function islemSil($id, $islem_sayisi)
    {
        return $this->db->reset_query()->where(array(
            "cihaz_id" => $id,
            "islem_sayisi" => $islem_sayisi
        ))->delete($this->islemlerTabloAdi());
    }
    public function cihazEkle($veri)
    {
        return $this->db->reset_query()->insert($this->cihazlarTabloAdi(), $veri);
    }
    public function ozelIDTabloAdi()
    {
        return getenv(DB_ON_EK_STR) . "ozelid";
    }
    public function insertTrigger()
    {
        $isim = date("Y");
        $grup = date("Y");
        $sonID = $this->Cihazlar_Model->sonIDBul($isim, $grup);
        if ($sonID == 0) {
            $sonID = $sonID + 1;
            $ekle = $this->Cihazlar_Model->sonIDEkle($isim, $grup, $sonID);
            if (!$ekle) {
                return 0;
            }
        } else {
            $sonID = $sonID + 1;
            $duzenle1 = $this->Cihazlar_Model->sonIDGuncelle($isim, $grup, $sonID);
            if (!$duzenle1) {
                return 0;
            }
        }
        return $grup . sprintf('%06d', $sonID);
    }
    public function deleteTrigger($id)
    {
        $this->db->reset_query()->query("DELETE FROM " . $this->silinenCihazlarTabloAdi() . " WHERE silinme_tarihi < now() - interval 1 day");
        return $this->db->reset_query()->insert($this->silinenCihazlarTabloAdi(), array("id" => $id));
    }
    public function sonIDEkle($isim, $grup, $sonID)
    {
        $veri = array(
            "id_adi" => $isim,
            "id_grup" => $grup,
            "id_val" => $sonID,
        );
        return $this->db->reset_query()->insert($this->ozelIDTabloAdi(), $veri);
    }
    public function sonIDGuncelle($isim, $grup, $sonID)
    {
        $where = array(
            "id_adi" => $isim,
            "id_grup" => $grup,
        );
        return $this->db->reset_query()->where($where)->update($this->ozelIDTabloAdi(), array("id_val" => $sonID));
    }
    public function sonIDBul($isim, $grup)
    {
        $where = array(
            "id_adi" => $isim,
            "id_grup" => $grup,
        );
        $query = $this->db->reset_query()->where($where)->limit(1)->get($this->ozelIDTabloAdi());
        if ($query->num_rows() > 0) {
            return $query->result()[0]->id_val;
        } else {
            return 0;
        }
    }
    public function cihazSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->cihazlarTabloAdi());
    }
    public function silinenCihazlariBul()
    {
        $results = $this->db->reset_query()->get($this->silinenCihazlarTabloAdi())->result();
        //$this->db->reset_query()->empty_table($this->silinenCihazlarTabloAdi());
        return $results;
    }

    public function yapilanIslemArray($cihaz_id, $islem_sayisi, $ad, $birim_fiyat, $miktar, $kdv)
    {
        return array(
            "cihaz_id" => $cihaz_id,
            "islem_sayisi" => $islem_sayisi,
            "ad" => $ad,
            "birim_fiyat" => $birim_fiyat,
            "miktar" => $miktar,
            "kdv" => $kdv
        );
    }
    public function cihazDetayModalAdi()
    {
        return "cihazDetay";
    }
    public function medyaYukle($veri)
    {
        return $this->db->reset_query()->insert($this->medyalarTabloAdi(), $veri);
    }
    public function medyaSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->medyalarTabloAdi());
    }

    public function medyaBul($id)
    {
        return $this->db->reset_query()->where("id", $id)->get($this->medyalarTabloAdi())->result()[0];
    }
    public function medyalar($id)
    {
        return $this->db->reset_query()->where("cihaz_id", $id)->get($this->medyalarTabloAdi())->result();
    }
}
