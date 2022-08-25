<?php
class Cihazlar_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public $cihazlarTabloAdi = "Cihazlar";
    public $cihazTurleriTabloAdi = "CihazTurleri";
    public $silinenCihazlarTabloAdi = "SilinenCihazlar";
    public $medyalarTabloAdi = "Medyalar";
    public function cihazBul($id)
    {
        return $this->db->where("id", $id)->limit(1)->get($this->cihazlarTabloAdi);
    }
    public function servisNo($servis_no)
    {
        $bul = array(
            "servis_no" => $servis_no,
        );
        return $this->db->where($bul)->limit(1)->get($this->cihazlarTabloAdi);
    }
    public function cihazTuru($tur_id)
    {
        $query = $this->db->where("id", $tur_id)->get($this->cihazTurleriTabloAdi);
        if ($query->num_rows() > 0) {
            return $query->result()[0]->isim;
        } else {
            return "Belirtilmemiş";
        }
    }
    public function cihazTurleri()
    {
        return $this->db->get($this->cihazTurleriTabloAdi)->result();
    }
    public function cihazTuruEkle($veri)
    {
        return $this->db->insert($this->cihazTurleriTabloAdi, $veri);
    }
    public function cihazTuruDuzenle($id, $veri)
    {
        return $this->db->where("id", $id)->update($this->cihazTurleriTabloAdi, $veri);
    }
    public function cihazTuruSil($id)
    {
        return $this->db->where("id", $id)->delete($this->cihazTurleriTabloAdi);
    }
    public function cihazTuruPost()
    {
        $veri = array(
            "isim" => $this->input->post("isim"),
            "sifre" => $this->input->post("sifre"),
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
            $result[$i]->cihaz_turu = $this->cihazTuru($result[$i]->cihaz_turu);
            $sorumlu_per = $this->Kullanicilar_Model->tekKullanici($result[$i]->sorumlu);
            $result[$i]->sorumlu = isset($sorumlu_per) ? $sorumlu_per->ad_soyad : "Atanmamış";
        }
        return $result;
    }
    public function cihazlar()
    {
        $result = $this->db->order_by("id", "DESC")->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTur($tur)
    {
        $where = array(
            "cihaz_turu" => $tur,
        );
        $result = $this->db->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonel($tur)
    {
        $where = array(
            "sorumlu" => $tur,
        );
        $result = $this->db->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarJQ($id)
    {
        $where = array(
            "id >" => $id,
        );
        $result = $this->db->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurJQ($tur, $id)
    {
        $where = array(
            "id >" => $id,
            "cihaz_turu" => $tur
        );
        $result = $this->db->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonelJQ($sorumlu_personel, $id)
    {
        $where = array(
            "id >" => $id,
            "sorumlu" => $sorumlu_personel
        );
        $result = $this->db->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTumuJQ()
    {
        $result = $this->db->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurTumuJQ($tur)
    {
        $where = array(
            "cihaz_turu" => $tur
        );
        $result = $this->db->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonelTumuJQ($sorumlu_personel)
    {
        $where = array(
            "sorumlu" => $sorumlu_personel
        );
        $result = $this->db->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi)->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazPost()
    {
        $musteri_kod = $this->input->post("musteri_kod");
        $veri = array(
            "musteri_kod" => (strlen($musteri_kod) > 0) ? $musteri_kod : NULL,
            "musteri_adi" => $this->input->post("musteri_adi"),
            "adres" => $this->input->post("adres"),
            "gsm_mail" => $this->input->post("gsm_mail"),
            "cihaz_turu" => $this->input->post("cihaz_turu"),
            "cihaz" => $this->input->post("cihaz"),
            "cihaz_modeli" => $this->input->post("cihaz_modeli"),
            "seri_no" => $this->input->post("seri_no"),
            "cihaz_sifresi" => $this->input->post("cihaz_sifresi"),
            "hasar_tespiti" => $this->input->post("hasar_tespiti"),
            "cihazdaki_hasar" => $this->input->post("cihazdaki_hasar"),
            "ariza_aciklamasi" => $this->input->post("ariza_aciklamasi"),
            "servis_turu" => $this->input->post("servis_turu"),
            "yedek_durumu" => $this->input->post("yedek_durumu"),
        );
        $sorumlu = $this->input->post("sorumlu");
        if (isset($sorumlu)) {
            $veri["sorumlu"]  = $sorumlu;
        }
        $tarih = $this->input->post("tarih");
        if (isset($tarih)) {
            $veri["tarih"] =  $this->Islemler_Model->tarihDonusturSQL($tarih);
        }
        return $veri;
    }
    public function cihazDuzenle($id, $veri)
    {
        return $this->db->where("id", $id)->update($this->cihazlarTabloAdi, $veri);
    }
    public function cihazEkle($veri)
    {
        return $this->db->insert($this->cihazlarTabloAdi, $veri);
    }
    public function cihazSil($id)
    {
        return $this->db->where("id", $id)->delete($this->cihazlarTabloAdi);
    }
    public function silinenCihazlariBul()
    {
        $results = $this->db->get($this->silinenCihazlarTabloAdi)->result();
        //$this->db->empty_table($this->silinenCihazlarTabloAdi);
        return $results;
    }

    public function yapilanIslemArray($index, $islem, $miktar, $birim_fiyati, $kdv)
    {
        return array(
            "i_ad_" . $index => $islem,
            "i_birim_fiyat_" . $index => $birim_fiyati,
            "i_miktar_" . $index => $miktar,
            "i_kdv_" . $index => $kdv,
        );
    }
    public function cihazDetayModalAdi()
    {
        return "cihazDetay";
    }
    public function medyaYukle($veri)
    {
        return $this->db->insert($this->medyalarTabloAdi, $veri);
    }
    public function medyaSil($id)
    {
        return $this->db->where("id", $id)->delete($this->medyalarTabloAdi);
    }

    public function medyaBul($id)
    {
        return $this->db->where("id", $id)->get($this->medyalarTabloAdi)->result()[0];
    }
    public function medyalar($id)
    {
        return $this->db->where("cihaz_id", $id)->get($this->medyalarTabloAdi)->result();
    }
}
