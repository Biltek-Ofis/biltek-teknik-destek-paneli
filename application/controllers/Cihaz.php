<?php

require_once("Varsayilancontroller.php");
class Cihaz extends Varsayilancontroller
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
                if ($cihaz_bilg->guncel_durum < count($this->Islemler_Model->cihazDurumu) - 1 || $this->Kullanicilar_Model->yonetici()) {
                    $baslik = 'Cihaz ' . $cihaz_bilg->servis_no . ' Detayları';
                    $this->load->view("tasarim", $this->Islemler_Model->tasarimArray($baslik, "cihaz", array("cihaz" => $cihaz_bilg, "baslik" => $baslik)));
                } else {
                    $this->Kullanicilar_Model->girisUyari("", "Bu cihazın teslim edildiği için düzenleme yapılamaz.");  
                }
            } else {
                redirect(base_url());
            }
        } else {
            $this->load->view('giris', array("girisHatasi" => ""));
        }
    }

    public function duzenle($id, $tur)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $veri = $this->Cihazlar_Model->cihazPost();
            $duzenle = $this->Cihazlar_Model->cihazDuzenle($id, $veri);
            if($tur == "post" || $tur == "POST"){
                if ($duzenle) {
                    echo json_encode(array("mesaj" => "", "sonuc" => 1));
                }else{
                    echo json_encode(array("mesaj" => "Düzenleme başarısız. Lütfen geliştirici ile iletişime geçin.", "sonuc" => 0));
                }
            }else{
                if ($duzenle) {
                    //$id = $this->db->insert_id();
                    redirect(base_url("cihaz/" . $id));
                } else {
                    $this->Kullanicilar_Model->girisUyari("", "Düzenleme işlemi gerçekleştirilemedi. ");
                }
            }
        } else {
            $this->Kullanicilar_Model->girisUyari("cikis");
        }
    }

    public function yapilanIslemDuzenle($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $guncel_durum = $this->input->post("guncel_durum");
            $guncel_durum_suanki = $this->input->post("guncel_durum_suanki");
            $tahsilat_sekli = $this->input->post("tahsilat_sekli");
            $fatura_durumu = $this->input->post("fatura_durumu");
            $fis_no = $this->input->post("fis_no");
            $cihaz_verileri = array(
                "yapilan_islem_aciklamasi" => $this->input->post("yapilan_islem_aciklamasi"),
                "guncel_durum" => $guncel_durum,
                "tahsilat_sekli" => $tahsilat_sekli,
                "fatura_durumu" => $fatura_durumu,
                "fis_no" => $fis_no
            );
            $tarih = $this->Islemler_Model->tarihDonusturSQL($this->input->post("tarih"));
            $bildirim_tarihi = $this->Islemler_Model->tarihDonusturSQL($this->input->post("bildirim_tarihi"));
            $cikis_tarihi = $this->Islemler_Model->tarihDonusturSQL($this->input->post("cikis_tarihi"));
            if (strlen($tarih) > 0) {
                $cihaz_verileri["tarih"] = $tarih;
            }
            if ($guncel_durum_suanki != $guncel_durum) {
                $cihaz_verileri["bildirim_tarihi"] = $this->Islemler_Model->tarihDonusturSQL($this->Islemler_Model->tarih());
            } else {
                $cihaz_verileri["bildirim_tarihi"] = strlen($bildirim_tarihi) > 0 ? $bildirim_tarihi : NULL;
            }
            $cihaz_verileri["cikis_tarihi"] = strlen($cikis_tarihi) > 0 ? $cikis_tarihi : NULL;
            $this->Cihazlar_Model->cihazDuzenle(
                $id,
                $cihaz_verileri
            );
            for ($i = 1; $i <= $this->Islemler_Model->maxIslemSayisi; $i++) {
                $islem = $this->input->post("islem" . $i);
                $miktar = $this->input->post("miktar" . $i);
                $birim_fiyati = $this->input->post("birim_fiyati" . $i);
                $kdv = $this->input->post("kdv_" . $i);
                if(isset($islem) && !empty($islem)){
                    $veri = $this->Cihazlar_Model->yapilanIslemArray(
                        $id, 
                        $i, 
                        $islem, 
                        $birim_fiyati, 
                        $miktar, 
                        $kdv
                    );
                    $duzenle = $this->Cihazlar_Model->islemDuzenle($id, $veri);
                    if (!$duzenle) {
                        $this->Kullanicilar_Model->girisUyari("cihaz/" . $id, "Düzenleme işlemi gerçekleştirilemedi. " . $this->db->error()["message"]);
                        return;
                    }
                }else{
                    $sil =$this->Cihazlar_Model->islemSil($id, $i);
                    if (!$sil) {
                        $this->Kullanicilar_Model->girisUyari("cihaz/" . $id, "Düzenleme işlemi gerçekleştirilemedi. " . $this->db->error()["message"]);
                        return;
                    }
                }
            }
            redirect(base_url("cihaz/" . $id));
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
    public function barkod($id)
    {
        if($id == "test"){
            $this->load->view("icerikler/barkod_yazdir", array("test" => TRUE));
        }else{
            $cihaz = $this->Cihazlar_Model->cihazBul($id);
            if ($cihaz->num_rows() > 0) {
                $cihaz_bilg = $cihaz->result();
                $veriler =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz_bilg)[0];
                $this->load->view("icerikler/barkod_yazdir", array("cihaz" => $veriler, "test" => FALSE));
            } else {
                redirect(base_url());
            }
        }
    }

    public function servis_kabul($id)
    {
        $cihaz = $this->Cihazlar_Model->cihazBul($id);
        if ($cihaz->num_rows() > 0) {
            $cihaz_bilg = $cihaz->result();
            $veriler =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz_bilg)[0];
            $this->load->view("icerikler/servis_kabul/form", array("cihaz" => $veriler));
        } else {
            redirect(base_url());
        }
    }
    public function medyaYukle($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            if (!$_FILES["yuklenecekDosya"]["tmp_name"]) {
                echo json_encode(array("mesaj" => "Hata: Lütfen bir resim veya video seçin", "sonuc" => 0));
                exit();
            } else {
                $uzanti = pathinfo($_FILES['yuklenecekDosya']['name'], PATHINFO_EXTENSION);
                $uzanti = strtolower($uzanti);
                if (($_FILES["yuklenecekDosya"]["type"] == "video/mp4")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/pjpeg")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/jpeg")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/png")
                ) {
                    $dosyaKonumu = "yuklemeler/";
                    $orjinal_dosya_adi = $_FILES["yuklenecekDosya"]["name"];
                    $boyut = $_FILES["yuklenecekDosya"]["size"];
                    $boyut_mb = number_format(($boyut / 1048576), 2);
                    $tasinacakKonum = "$dosyaKonumu" . $id . "_" . rand(1000, 9999) . "_" . $_FILES["yuklenecekDosya"]["name"];
                    $tur = ($_FILES["yuklenecekDosya"]["type"] == "video/mp4") ? "video" : "resim";

                    $yukleVeri = array(
                        "cihaz_id" => $id,
                        "konum" => $tasinacakKonum,
                        "tur" => $tur
                    );
                    $ekle = $this->Cihazlar_Model->medyaYukle($yukleVeri);
                    if ($ekle) {
                        $eklenenID = $this->db->insert_id();
                        if (move_uploaded_file($_FILES["yuklenecekDosya"]["tmp_name"], $tasinacakKonum)) {
                            echo json_encode(array("mesaj" => "$orjinal_dosya_adi dosyasının yüklemesi tamamlandı.", "sonuc" => 1));
                        } else {
                            $this->Cihazlar_Model->medyaSil($eklenenID);
                            echo json_encode(array("mesaj" => "Dosya yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
                        }
                    } else {
                        echo json_encode(array("mesaj" => "Dosya yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
                    }
                } else {
                    echo json_encode(array("mesaj" => "Geçerli bir resim veya video dosyası seçin.", "sonuc" => 0));
                    exit;
                }
            }
        } else {
            $this->Kullanicilar_Model->girisUyari("cikis");
        }
    }
    public function medyaSil($cihaz_id, $id)
    {
        $medya = $this->Cihazlar_Model->medyaBul($id);
        unlink($medya->konum);
        $sil = $this->Cihazlar_Model->medyaSil($id);
        if ($sil) {
            redirect(base_url("cihaz/" . $cihaz_id));
        } else {
            $this->Kullanicilar_Model->girisUyari("cihaz/" . $cihaz_id, "Medya silinemedi lütfen daha sonra tekrar deneyin");
        }
    }
}
