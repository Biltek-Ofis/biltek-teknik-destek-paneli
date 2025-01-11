<?php
require_once("Varsayilancontroller.php");

class Kullanici extends Varsayilancontroller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->model("Ayarlar_Model");
	}
	public function index()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray($kullanici["ad_soyad"], "kullanici", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function guncelle()
	{
		if ($this->Giris_Model->kullaniciGiris()) {

			$veri = $this->Kullanicilar_Model->kullaniciPost(false);
			$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
			if (strlen($veri["kullanici_adi"]) >= 3) {
				if (strlen($veri["sifre"]) >= 6) {
					if ($this->Kullanicilar_Model->kullaniciAdiKontrol($veri["kullanici_adi"]) || $veri["kullanici_adi"] == $this->input->post("kullanici_adi_orj")) {
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
						$this->Kullanicilar_Model->girisUyari("kullanici", "Bu kullanıcı adı zaten mevcut.");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari("kullanici", "Şifreniz en az 6 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari("kullanici", "Kullanıcı adınız en az 3 karakter olmalıdır.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
}
