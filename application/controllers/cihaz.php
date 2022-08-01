<?php

require_once("varsayilan_controller.php");
class Cihaz extends Varsayilan_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $cihaz = $this->Cihazlar_Model->cihazBul($id);
            if ($cihaz->num_rows() > 0) {
                $cihaz_bilg =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz->result())[0];
                $baslik = 'Cihaz ' . $cihaz_bilg->id . ' Detayları';
                $this->load->view("tasarim", $this->Islemler_Model->tasarimArray($baslik, "cihaz", array("cihaz" => $cihaz_bilg, "baslik" => $baslik)));
            } else {
                redirect(base_url());
            }
        } else {
            $this->load->view('giris', array("girisHatasi" => ""));
        }
    }

    public function duzenle($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $veri = $this->Cihazlar_Model->cihazPost(true);
            $duzenle = $this->Cihazlar_Model->cihazDuzenle($id, $veri);
            if ($duzenle) {
                //$id = $this->db->insert_id();
                redirect(base_url("cihaz/" . $id));
            } else {
                $this->Kullanicilar_Model->girisUyari("", "Düzenleme işlemi gerçekleştirilemedi. ");
            }
        } else {
            $this->Kullanicilar_Model->girisUyari("cikis");
        }
    }

    public function yapilanIslemDuzenle($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $this->Cihazlar_Model->yapilanIslemleriTemizle($id);
            $cihaz_verileri = array(
                "yapilan_islem_aciklamasi" => $this->input->post("yapilan_islem_aciklamasi"),
            );
            $tarih = $this->Islemler_Model->tarihDonusturSQL($this->input->post("tarih"));
            $bildirim_tarihi = $this->Islemler_Model->tarihDonusturSQL($this->input->post("bildirim_tarihi"));
            $cikis_tarihi = $this->Islemler_Model->tarihDonusturSQL($this->input->post("cikis_tarihi"));
            if (strlen($tarih) > 0) {
                $cihaz_verileri["tarih"] = $tarih;
            }
            $cihaz_verileri["bildirim_tarihi"] = strlen($bildirim_tarihi) > 0 ? $bildirim_tarihi : NULL;
            $cihaz_verileri["cikis_tarihi"] = strlen($cikis_tarihi) > 0 ? $cikis_tarihi : NULL;
            $this->Cihazlar_Model->cihazDuzenle(
                $id,
                $cihaz_verileri,
            );
            for ($i = 0; $i < 5; $i++) {
                $islem = $this->input->post("islem" . $i);
                if (strlen($islem) > 0) {
                    $veri = $this->Cihazlar_Model->yapilanIslemArray(
                        $id,
                        $islem,
                        $this->input->post("miktar" . $i),
                        $this->input->post("birim_fiyati" . $i),
                    );
                    $ekle = $this->Cihazlar_Model->yapilanIslemEkle($veri);
                    if (!$ekle) {
                        $this->Kullanicilar_Model->girisUyari("cihaz/" . $id . "#yapilan-islemler", "Düzenleme işlemi gerçekleştirilemedi. ");
                        return;
                    }
                }
            }

            redirect(base_url("cihaz/" . $id . "#yapilan-islemler"));
        } else {
            $this->Kullanicilar_Model->girisUyari("cikis");
        }
    }
    public function teknik_servis_formu($id)
    {
        $cihaz = $this->Cihazlar_Model->cihazBul($id);
        if ($cihaz->num_rows() > 0) {
            $cihaz_bilg = $cihaz->result();
            $veriler =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz_bilg)[0];
            $this->load->view("icerikler/teknik_servis_formu_yazdir", array("cihaz" => $veriler));
        } else {
            redirect(base_url());
        }
    }
}
