<?php
require_once("varsayilan_controller.php");

class Cihazlar extends Varsayilan_Controller
{

	public function __construct()
	{
		parent::__construct();
	}
	public function index($tur)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$veri = array(
				"baslik" => $this->Cihazlar_Model->cihazTuru($tur),
				"cihazlar" => $this->Cihazlar_Model->cihazlarTekTur($tur),
				"cihazTurleri" => $this->Cihazlar_Model->cihazTurleri(),
				"suankiCihazTuru" => $tur,
			);
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray($this->Cihazlar_Model->cihazTuru($tur), "cihazlar", $veri, "inc/datatables"));
		} else {
			$this->load->view('giris', array("girisHatasi" => ""));
		}
	}
	public function cihazlarJQ($tur, $id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->cihazlarTekTurJQ($tur, $id));
		}
	}
	public function cihazlarTumuJQ($tur)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->cihazlarTekTurTumuJQ($tur));
		}
	}
	public function cihazSil($tur, $id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$sil = $this->Cihazlar_Model->cihazSil($id);
			if ($sil) {
				redirect(base_url("cihazlar/" . $tur));
			} else {
				$this->Kullanicilar_Model->girisUyari("cihazlar/" . $tur, "Silme işlemi gerçekleştirilemedi");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function teslimEdildi($tur, $id, $durum)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$guncellendi = $this->Cihazlar_Model->teslimEdildi($id, $durum);
			if ($guncellendi) {
				redirect(base_url("cihazlar/" . $tur)."#".$this->Cihazlar_Model->cihazDetayModalAdi().$id);
			} else {
				$this->Kullanicilar_Model->girisUyari("cihazlar/" . $tur, "Teslim durumu güncelleme işlemi gerçekleştirilemedi");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
}
