<?php
require_once("Varsayilancontroller.php");

class Yonetim extends Varsayilancontroller
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
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Kullanıcılar", "yonetim/kullanicilar", array("baslik" => "Kullanıcılar"), "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function personel()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Personel", "yonetim/personel", array("baslik" => "Personel"), "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciEkle($tur = 0)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			if (strlen($veri["kullanici_adi"]) >= 3) {
				if (strlen($veri["sifre"]) >= 6) {
					if ($this->Kullanicilar_Model->kullaniciAdiKontrol($veri["kullanici_adi"])) {
						$sifre = $veri["sifre"];
						$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
						$ekle = $this->Kullanicilar_Model->ekle($veri);
						if ($ekle) {
							redirect(base_url($this->konum($tur)));
						} else {
							$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Hesap eklenemedi lütfen daha sonra tekrar deneyin");
						}
					} else {
						$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Bu kullanıcı adı zaten mevcut.");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Şifre en az 6 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Kullanıcı adı en az 3 karakter olmalıdır.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciDuzenle($id, $tur = 0)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			if (strlen($veri["kullanici_adi"]) >= 3) {
				if (strlen($veri["sifre"]) >= 6) {
					if ($this->Kullanicilar_Model->kullaniciAdiKontrol($veri["kullanici_adi"]) || $veri["kullanici_adi"] == $this->input->post("kullanici_adi_orj" . $id)) {
						$kullanici = $this->Kullanicilar_Model->kullaniciListesi($id)[0];
						if ($kullanici->sifre != $veri["sifre"]) {
							$sifre = $veri["sifre"];
							$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
						}
						$duzenle = $this->Kullanicilar_Model->duzenle($id, $veri);
						if ($duzenle) {
							redirect(base_url($this->konum($tur)));
						} else {
							$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Hesap düzenlenemedi lütfen daha sonra tekrar deneyin");
						}
					} else {
						$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Bu kullanıcı adı zaten mevcut.");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Şifre en az 6 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Kullanıcı adı en az 3 karakter olmalıdır.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciSil($id, $tur = 0)
	{

		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Kullanicilar_Model->sil($id);
			if ($sil) {
				redirect(base_url($this->konum($tur)));
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur), "Hesap silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function konum($tur = 0)
	{
		$konum = "yonetim/personel";
		if ($tur == 1) {
			$konum = "yonetim/kullanicilar";
		}
		return $konum;
	}
	public function rapor()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Rapor", "yonetim/rapor", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihaz_turleri()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Cihaz Türleri", "yonetim/cihaz_turleri", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruEkle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazTuruPost();
			$ekle = $this->Cihazlar_Model->cihazTuruEkle($veri);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri#yeniCihazTuruEkleModal", "Cihaz türü eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruDuzenle($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazTuruPost();
			$ekle = $this->Cihazlar_Model->cihazTuruDuzenle($id, $veri);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri#yeniCihazTuruEkleModal", "Cihaz türü eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruSil($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Cihazlar_Model->cihazTuruSil($id);
			if ($sil) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri", "Cihaz türü eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
}
