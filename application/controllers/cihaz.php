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
