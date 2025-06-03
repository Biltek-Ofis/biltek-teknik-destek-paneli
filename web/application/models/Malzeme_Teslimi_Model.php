<?php
class Malzeme_Teslimi_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Islemler_Model");
    }
    public function tabloAdi()
    {
        return DB_ON_EK_STR . "malzeme_teslimi";
    }
    public function ozelIDTabloAdi()
    {
        return DB_ON_EK_STR . "malzeme_teslimi_ozelid";
    }
    public function islemlerTabloAdi()
    {
        return DB_ON_EK_STR . "malzeme_teslimi_islemler";
    }
    public function malzemeteslimleri()
    {
        $malzemeTeslimleri = $this->db->reset_query()->get($this->tabloAdi())->result_array();
        for ($i = 0; $i < count($malzemeTeslimleri); $i++) {
            $malzemeTeslimleri[$i] = $this->malzemeteslimiDonustur($malzemeTeslimleri[$i]);
        }
        return $malzemeTeslimleri;
    }
    public function malzemeteslimi($id)
    {
        $res = $this->db->reset_query()->where("id", $id)->get($this->tabloAdi());
        if ($res->num_rows() > 0) {
            $malzemeTeslimi = $res->result_array()[0];
            $malzemeTeslimi = $this->malzemeteslimiDonustur($malzemeTeslimi);
            return $malzemeTeslimi;
        }
        return null;
    }
    public function malzemeteslimiDonustur($malzemeTeslimi)
    {
        $malzemeTeslimi["odendi"] = $malzemeTeslimi["odeme_durumu"] == "1";
        $malzemeTeslimi["siparis_tarihi"] = $malzemeTeslimi["siparis_tarihi"] == '0000-00-00' ? "Belirtilmemiş" : $this->Islemler_Model->tarihDonustur($malzemeTeslimi["siparis_tarihi"], FALSE);
        $malzemeTeslimi["teslim_tarihi"] = $malzemeTeslimi["teslim_tarihi"] == '0000-00-00' ? "Belirtilmemiş" : $this->Islemler_Model->tarihDonustur($malzemeTeslimi["teslim_tarihi"], FALSE);
        $malzemeTeslimi["vade_tarihi"] = $malzemeTeslimi["vade_tarihi"] == '0000-00-00' ? "Belirtilmemiş" : $this->Islemler_Model->tarihDonustur($malzemeTeslimi["vade_tarihi"], FALSE);
        $malzemeTeslimi["vade_durumu"] = $malzemeTeslimi["vade_tarihi"] == "Belirtilmemiş" ? FALSE : strtotime(date("d.m.Y")) > strtotime($malzemeTeslimi["vade_tarihi"]);
        $malzemeTeslimi["islemler"] = $this->Malzeme_Teslimi_Model->malzemeteslimiIslemleri($malzemeTeslimi["id"]);
        return $malzemeTeslimi;
    }
    public function malzemeteslimiIslemleri($id)
    {
        return $this->db->reset_query()->where("teslim_id", $id)->get($this->islemlerTabloAdi())->result_array();
    }
    public function malzemeTeslimiEkle()
    {
        $veri = $this->post();
        $malzeme_teslim_no = $this->insertTrigger();
        if ($malzeme_teslim_no != "0") {
            $veri["teslim_no"] = $malzeme_teslim_no;
            $ekle = $this->db->reset_query()->insert($this->tabloAdi(), $veri);
            return $this->resp("Bir hata oluştu. Lütfen daha sonra tekrar deneyin!1", $ekle);
        } else {
            return $this->resp("Bir hata oluştu. Lütfen daha sonra tekrar deneyin!2");
        }
    }
    public function malzemeTeslimiDuzenle($id)
    {
        $veri = $this->post();
        $duzenle = $this->db->reset_query()->where("id", $id)->update($this->tabloAdi(), $veri);
        if (!$duzenle) {
            return $this->resp("Bir hata oluştu. Lütfen daha sonra tekrar deneyin!", $duzenle);
        }
        for ($i = 1; $i <= 10; $i++) {
            $islem = $this->input->post("islem" . $i);
            $adet = $this->input->post("adet" . $i);
            $birim_fiyati = $this->input->post("birim_fiyati" . $i);
            $kdv = $this->input->post("kdv_" . $i);
            if (isset($islem) && !empty($islem)) {
                $veri = $this->islemArray(
                    $id,
                    $i,
                    $islem,
                    $birim_fiyati,
                    $adet,
                    $kdv
                );
                $duzenle = $this->islemDuzenle($id, $veri);
                if (!$duzenle) {
                    echo json_encode(array("mesaj" => "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"], "sonuc" => 0));
                    return;
                }
            } else {
                $duzenle = $this->islemSil($id, $i);
                if (!$duzenle) {
                    return $this->resp("Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"], FALSE);
                }
            }
        }
        return $this->resp("Bir hata oluştu. Lütfen daha sonra tekrar deneyin!", $duzenle);
    }
    public function malzemeTeslimiSil($id)
    {
        $sil = $this->db->reset_query()->where("teslim_id", $id)->delete($this->islemlerTabloAdi());
        
        if(!$sil){
            return $this->resp("Bir hata oluştu. Lütfen daha sonra tekrar deneyin!", $sil);
        }
        $sil = $this->db->reset_query()->where("id", $id)->delete($this->tabloAdi());
        return $this->resp("Bir hata oluştu. Lütfen daha sonra tekrar deneyin!", $sil);
    }
    public function islemArray($id, $islem_sirasi, $islem, $birim_fiyat, $adet, $kdv)
    {
        return array(
            "teslim_id" => $id,
            "islem_sira" => $islem_sirasi,
            "isim" => $islem,
            "birim_fiyati" => $birim_fiyat,
            "adet" => $adet,
            "kdv" => $kdv
        );
    }
    public function islemDuzenle($id, $veri)
    {
        $konum = array(
            "teslim_id" => $id,
            "islem_sira" => $veri["islem_sira"]
        );
        $islem_bul = $this->db->reset_query()->where($konum)->get($this->islemlerTabloAdi());
        if ($islem_bul->num_rows() > 0) {
            return $this->db->reset_query()->where($konum)->update($this->islemlerTabloAdi(), $veri);
        } else {
            return $this->db->reset_query()->insert($this->islemlerTabloAdi(), $veri);
        }
    }
    public function islemSil($id, $islem_sira)
    {
        return $this->db->reset_query()->where(array(
            "teslim_id" => $id,
            "islem_sira" => $islem_sira
        ))->delete($this->islemlerTabloAdi());
    }
    public function girisHatasi()
    {
        return $this->resp("Bu işlemi gerçekleştirebilmek için giriş yapmış olmalısınız.");
    }
    public function resp($mesaj, $sonuc = FALSE)
    {
        return array(
            "sonuc" => $sonuc,
            "mesaj" => $mesaj,
        );
    }
    public function post()
    {
        $veri = array(
            "firma" => $this->input->post("firma"),
            "teslim_eden" => $this->input->post("teslim_eden"),
            "teslim_alan" => $this->input->post("teslim_alan"),
            "siparis_tarihi" => $this->input->post("siparis_tarihi"),
            "teslim_tarihi" => $this->input->post("teslim_tarihi"),
            "vade_tarihi" => $this->input->post("vade_tarihi"),

        );
        $odeme_durumu = $this->input->post("odeme_durumu");
        if (isset($odeme_durumu)) {
            $veri["odeme_durumu"] = $odeme_durumu;
        }
        return $veri;
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
    public function insertTrigger()
    {
        $isim = date("Y");
        $grup = date("Y");
        $sonID = $this->sonIDBul($isim, $grup);
        if ($sonID == 0) {
            $sonID = $sonID + 1;
            $ekle = $this->sonIDEkle($isim, $grup, $sonID);
            if (!$ekle) {
                return "0";
            }
        } else {
            $sonID = $sonID + 1;
            $duzenle1 = $this->sonIDGuncelle($isim, $grup, $sonID);
            if (!$duzenle1) {
                return "0";
            }
        }
        return $grup . sprintf('%06d', $sonID);
    }
}