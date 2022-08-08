<?php
require_once("varsayilan_controller.php");

class Kullanici extends Varsayilan_Controller
{

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray($kullanici["ad"] . " " . $kullanici["soyad"], "kullanici", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function guncelle()
	{
		if ($this->Giris_Model->kullaniciGiris()) {

			$veri = $this->Kullanicilar_Model->kullaniciPost(false);
			$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
			if ($kullanici["sifre"] != $veri["sifre"]) {
				$sifre = $veri["sifre"];
				$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
			}
			$duzenle = $this->Kullanicilar_Model->duzenle($kullanici["id"], $veri);
			if ($duzenle) {
				redirect(base_url("kullanici"));
			} else {
				$this->Kullanicilar_Model->girisUyari("kullanici", "Bilgileriniz güncellenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
}
