<?php
require_once("varsayilan_controller.php");

class Yonetim extends Varsayilan_Controller
{

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		redirect(base_url());
	}
	public function kullanicilar()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Kullanıcılar", "yonetim/kullanicilar", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciEkle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			$sifre = $veri["sifre"];
			$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
			$ekle = $this->Kullanicilar_Model->ekle($veri);
			if ($ekle) {
				redirect(base_url("yonetim/kullanicilar"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/kullanicilar", "Kullanıcı eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciDuzenle($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			$kullanici = $this->Kullanicilar_Model->kullaniciListesi($id)[0];
			if ($kullanici->sifre != $veri["sifre"]) {
				$sifre = $veri["sifre"];
				$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
			}
			$duzenle = $this->Kullanicilar_Model->duzenle($id, $veri);
			if ($duzenle) {
				redirect(base_url("yonetim/kullanicilar"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/kullanicilar", "Kullanıcı düzenlenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciSil($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Kullanicilar_Model->sil($id);
			if ($sil) {
				redirect(base_url("yonetim/kullanicilar"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/kullanicilar", "Kullanıcı silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
}
