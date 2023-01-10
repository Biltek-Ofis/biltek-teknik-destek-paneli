<?php
require_once("Varsayilancontroller.php");

class Cihazyonetimi extends Varsayilancontroller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$this->load->model("Islemler_Model");
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "cihaz_yonetimi", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function cihazlarJQ($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->cihazlarJQ($id));
		}
	}
	
	public function tekCihazJQ($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->tekCihazJQ($id));
		}
	}
	public function cihazlarTumuJQ()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->cihazlarTumuJQ());
		}
	}
	public function cihazEkle()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$veri = $this->Cihazlar_Model->cihazPost();
			$servis_no = $this->Cihazlar_Model->insertTrigger();
			if ($servis_no != 0) {
				$veri["servis_no"] = $servis_no;
				$ekle = $this->Cihazlar_Model->cihazEkle($veri);
				if ($ekle) {
					$id = $this->db->insert_id();
					$musteriyi_kaydet = $this->input->post('musteriyi_kaydet');
					if(((int)$musteriyi_kaydet) == 1){
						if($veri["musteri_kod"] == NULL){
							$this->db->reset_query()->insert(
								$this->Firma_Model->musteriTablosu(),
								array(
									"musteri_adi" => $veri["musteri_adi"],
									"adres" => $veri["adres"],
									"telefon_numarasi" => $veri["telefon_numarasi"]
								)
							);
						}
					}
					redirect(base_url("") . "#" . $this->Cihazlar_Model->cihazDetayModalAdi() . $id);
				} else {
					$this->Kullanicilar_Model->girisUyari("", "Ekleme işlemi gerçekleştirilemedi. " . $this->db->error()["message"] . $servis_no);
				}
			} else {
				$this->Kullanicilar_Model->girisUyari("", "Ekleme işlemi gerçekleştirilemedi. " . $this->db->error()["message"] . $servis_no);
			}
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function cihazSil($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$sil = $this->Cihazlar_Model->cihazSil($id);
			$this->Cihazlar_Model->deleteTrigger($id);
			if ($sil) {
				redirect(base_url(""));
			} else {
				$this->Kullanicilar_Model->girisUyari("", "Silme işlemi gerçekleştirilemedi");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function silinenCihazlariBul()
	{
		echo json_encode($this->Cihazlar_Model->silinenCihazlariBul());
	}
}
