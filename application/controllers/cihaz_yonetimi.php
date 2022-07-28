<?php
require_once("varsayilan_controller.php");

class Cihaz_Yonetimi extends Varsayilan_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        if ($this->Giris_Model->kullaniciGiris()){
            $this->load->model("Islemler_Model");
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Cihaz Yönetimi", "cihaz_yonetimi", [], "inc/datatables"));
        }else{
			$this->Kullanicilar_Model->girisUyari("/");
		}
    }
    public function cihazlarJQ($id){
		if ($this->Giris_Model->kullaniciGiris()){
			echo json_encode($this->Cihazlar_Model->cihazlarJQ($id));
		}
	}
	public function cihazlarTumuJQ(){
		if ($this->Giris_Model->kullaniciGiris()){
			echo json_encode($this->Cihazlar_Model->cihazlarTumuJQ());
		}
	}
	public function cihazEkle()
	{
		if ($this->Giris_Model->kullaniciGiris()){
			$veri = array(
				"musteri_adi"=> $this->input->post("musteri_adi"),
				"adres"=> $this->input->post("adres"),
				"gsm_mail"=> $this->input->post("gsm_mail"),
				"cihaz_turu"=> $this->input->post("cihaz_turu"),
				"cihaz"=> $this->input->post("cihaz"),
				"cihaz_modeli"=> $this->input->post("cihaz_modeli"),
				"seri_no"=> $this->input->post("seri_no"),
				"hasar_tespiti"=> $this->input->post("hasar_tespiti"),
				"cihazdaki_hasar"=> $this->input->post("cihazdaki_hasar"),
				"ariza_aciklamasi"=> $this->input->post("ariza_aciklamasi"),
				"servis_turu"=> $this->input->post("servis_turu"),
				"yedek_durumu"=> $this->input->post("yedek_durumu"),
				"tasima_cantasi"=> $this->input->post("tasima_cantasi"),
				"sarj_adaptoru" => $this->input->post("sarj_adaptoru"),
				"pil"=> $this->input->post("pil"),
				"diger_aksesuar"=> $this->input->post("diger_aksesuar"),
			);
			$ekle = $this->Cihazlar_Model->cihazEkle($veri);
			if($ekle){
				$id = $this->db->insert_id();
				redirect(base_url("cihaz_yonetimi")."#cihazDetayModal".$id);
			}else{
				$this->Kullanicilar_Model->girisUyari("/cihaz_yonetimi", "Ekleme işlemi gerçekleştirilemedi. ");
			}
		}else{
			$this->Kullanicilar_Model->girisUyari("/");
		}
	}
	public function cihazSil($id)
	{
		if ($this->Giris_Model->kullaniciGiris()){
			$sil = $this->Cihazlar_Model->cihazSil($id);
			if($sil){
				redirect(base_url("cihaz_yonetimi"));
			}else{
				$this->Kullanicilar_Model->girisUyari("/cihaz_yonetimi", "Silme işlemi gerçekleştirilemedi");
			}
		}else{
			$this->Kullanicilar_Model->girisUyari("/");
		}
	}
	public function silinenCihazlariBul()
	{
		echo json_encode($this->Cihazlar_Model->silinenCihazlariBul());
	}
	public function teslimEdildi($id, $durum)
	{
		if ($this->Giris_Model->kullaniciGiris()){
			$sil = $this->Cihazlar_Model->teslimEdildi($id, $durum);
			if($sil){
				redirect(base_url("cihaz_yonetimi"));
			}else{
				redirect(base_url("cihaz_yonetimi"));
			}
		}else{
			$this->Kullanicilar_Model->girisUyari("/");
		}
	}
}

?>