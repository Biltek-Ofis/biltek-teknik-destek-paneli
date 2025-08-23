<?php

require_once("Varsayilancontroller.php");
class Cihaz extends Varsayilancontroller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
    }
    public function index($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $cihaz = $this->Cihazlar_Model->cihazBul($id);
            if ($cihaz->num_rows() > 0) {
                $cihaz_bilg =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz->result())[0];
                if (!$this->cihazlar_Model->cihazDurumuKilitle($cihaz_bilg->guncel_durum) || $this->Kullanicilar_Model->yonetici()) {
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
            $veri = $this->Cihazlar_Model->cihazPost(FALSE);
            $duzenle = $this->Cihazlar_Model->cihazDuzenle($id, $veri);
            if($tur == "post" || $tur == "POST"){
                if ($duzenle) {
                    echo json_encode(array("mesaj" => "", "sonuc" => 1));
                }else{
                    echo json_encode(array("mesaj" => "Düzenleme işlemi gerçekleştirilemedi.<br>".$this->db->error()["message"], "sonuc" => 0));
                }
            }else{
                if ($duzenle) {
                    //$id = $this->db->insert_id();
                    redirect(base_url("cihaz/" . $id));
                } else {
                    $this->Kullanicilar_Model->girisUyari("", "Düzenleme işlemi gerçekleştirilemedi.<br>".$this->db->error()["message"]);
                }
            }
        } else {
            if($tur == "post" || $tur == "POST"){
                echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için tekrar kullanıcı girişi yapmalısınız! Lütfen sayfayı yenileyin ve tekrar deneyin.", "sonuc" => 0));
            }else{
                $this->Kullanicilar_Model->girisUyari("cikis");
            }
        }
    }

    public function yapilanIslemDuzenle($id, $tur)
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
            $notlar = $this->input->post("notlar");
            if (!isset($notlar)) {
                $notlar = "";
            } 
            $cihaz_verileri["notlar"] = $notlar;
            $tarih = $this->Islemler_Model->tarihDonusturSQL($this->input->post("tarih"));
            $bildirim_tarihi = $this->input->post("bildirim_tarihi");
            if (isset($bildirim_tarihi)) {
                $bildirim_tarihi = $this->Islemler_Model->tarihDonusturSQL($bildirim_tarihi);
                $cihaz_verileri["bildirim_tarihi"] = strlen($bildirim_tarihi) > 0 ? $bildirim_tarihi : NULL;
            } else {
                $cihaz_verileri["bildirim_tarihi"] = $this->Islemler_Model->tarihDonusturSQL($this->Islemler_Model->tarih());
            }
            $cikis_tarihi = $this->Islemler_Model->tarihDonusturSQL($this->input->post("cikis_tarihi"));
            if (strlen($tarih) > 0) {
                $cihaz_verileri["tarih"] = $tarih;
            }
            $cihaz_verileri["cikis_tarihi"] = strlen($cikis_tarihi) > 0 ? $cikis_tarihi : NULL;
            $this->Cihazlar_Model->cihazDuzenle(
                $id,
                $cihaz_verileri,
                0,
                FALSE
            );
            for ($i = 1; $i <= $this->Islemler_Model->maxIslemSayisi; $i++) {
                $islem = $this->input->post("islem" . $i);
                $miktar = $this->input->post("miktar" . $i);
                $maliyet = $this->input->post("maliyet" . $i);
                if(isset($maliyet)){
                    if(strlen($maliyet) == 0){
                        $maliyet = 0;
                    }
                }else{
                    $maliyet = 0;
                }
                $birim_fiyati = $this->input->post("birim_fiyati" . $i);
                $kdv = $this->input->post("kdv_" . $i);
                if(isset($islem) && !empty($islem)){
                    $veri = $this->Cihazlar_Model->yapilanIslemArray(
                        $id, 
                        $i, 
                        $islem, 
                        $maliyet,
                        $birim_fiyati, 
                        $miktar, 
                        $kdv
                    );
                    $duzenle = $this->Cihazlar_Model->islemDuzenle($id, $veri);
                    if (!$duzenle) {
                        if($tur == "post" || $tur == "POST"){
                            echo json_encode(array("mesaj" => "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"], "sonuc" => 0));
                        }else{
                            $this->Kullanicilar_Model->girisUyari("cihaz/" . $id, "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"]);
                        }
                        return;
                    }
                }else{
                    $sil =$this->Cihazlar_Model->islemSil($id, $i);
                    if (!$sil) {
                        if($tur == "post" || $tur == "POST"){
                            echo json_encode(array("mesaj" => "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"], "sonuc" => 0));
                        }else{
                            $this->Kullanicilar_Model->girisUyari("cihaz/" . $id, "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"]);
                        }
                        return;
                    }
                }
            }
            if($tur == "post" || $tur == "POST"){
                echo json_encode(array("mesaj" => "", "sonuc" => 1));
            }else{
                redirect(base_url("cihaz/" . $id));
            }
        } else {
            if($tur == "post" || $tur == "POST"){
                echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için tekrar kullanıcı girişi yapmalısınız! Lütfen sayfayı yenileyin ve tekrar deneyin.", "sonuc" => 0));
            }else{
                $this->Kullanicilar_Model->girisUyari("cikis");
            }
        }
    }
    public function teknik_servis_formu($id)
    {
        $auth = "";
        if(isset( $_GET["auth"])){
            $auth = $_GET["auth"];
        }else{
            unset($auth);
        }
        $gecerli = FALSE;
        if(isset($auth)){
            $gecerli = $this->Kullanicilar_Model->gecerliAuth($auth);
        }
        if ($this->Giris_Model->kullaniciGiris() || $gecerli) {
            if($id == "yazdir"){
                $this->load->view("icerikler/yazdir/teknik_servis_formu");
            }else{
                $cihaz = $this->Cihazlar_Model->cihazBul($id);
                if ($cihaz->num_rows() > 0) {
                    $cihaz_bilg = $cihaz->result();
                    $veriler =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz_bilg)[0];
                    if(isset($auth)){
                        $this->load->view("icerikler/yazdir/teknik_servis_formu", array("cihaz" => $veriler, "auth"=>$auth));
                    }else{
                        $this->load->view("icerikler/yazdir/teknik_servis_formu", array("cihaz" => $veriler));
                    }
                } else {
                    redirect(base_url());
                }
            }
        } else {
            redirect(base_url());
        }
    }
    public function kargo_bilgisi($id)
    {
        $cihaz = $this->Cihazlar_Model->cihazBul($id);
        if ($cihaz->num_rows() > 0) {
            $cihaz_bilg = $cihaz->result();
            $veriler =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz_bilg)[0];
            $ayarlar = $this->Ayarlar_Model->getir();
            $this->load->view("icerikler/yazdir/kargo_bilgisi", array("cihaz" => $veriler, "ayarlar"=>$ayarlar));
        } else {
            redirect(base_url());
        }
    }
    public function barkod($id)
    {
        if($id == "test"){
            $this->load->view("icerikler/yazdir/barkod", array("test" => TRUE));
        }else{
            $cihaz = $this->Cihazlar_Model->cihazBul($id);
            if ($cihaz->num_rows() > 0) {
                $cihaz_bilg = $cihaz->result();
                $veriler =  $this->Cihazlar_Model->cihazVerileriniDonustur($cihaz_bilg)[0];
                $this->load->view("icerikler/yazdir/barkod", array("cihaz" => $veriler, "test" => FALSE));
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
            $this->load->view("icerikler/yazdir/servis_kabul/form", array("cihaz" => $veriler));
        } else {
            redirect(base_url());
        }
    }
    public function medyaYukle($id)
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            $yukle = $this->Cihazlar_Model->medyaYukle($id);
            echo json_encode($yukle);
        } else {
            $this->Kullanicilar_Model->girisUyari("cikis");
        }
    }
    public function medyaSil($cihaz_id, $id, $json="get")
    {   if ($this->Giris_Model->kullaniciGiris()) {
            $medya = $this->Cihazlar_Model->medyaBul($id);
            $sil = $this->Cihazlar_Model->medyaSil($id);
            if($json == "post"){
                if($sil){
                    if($medya != null){
                        if(file_exists($medya->konum)){
                            unlink($medya->konum);
                        }    
                    }   
                    echo json_encode(array("mesaj" => "", "sonuc" => 1));
                }else{
                    echo json_encode(array("mesaj" => "Medya silinemedi lütfen daha sonra tekrar deneyin", "sonuc" => 0));    
                }
            }
            else{
                if ($sil) {
                    redirect(base_url("cihaz/" . $cihaz_id));
                } else {
                    $this->Kullanicilar_Model->girisUyari("cihaz/" . $cihaz_id, "Medya silinemedi lütfen daha sonra tekrar deneyin");
                }
            }
        }else{
            if($json == "post"){
                 echo json_encode(array("mesaj" => "Giriş yapmadığınız için bu işlemi gerçekleştiremezsiniz.", "sonuc" => 0));    
            }else{
                $this->Kullanicilar_Model->girisUyari("cihaz/" . $cihaz_id, "Giriş yapmadığınız için bu işlemi gerçekleştiremezsiniz.");
            }
        }
    }
}
