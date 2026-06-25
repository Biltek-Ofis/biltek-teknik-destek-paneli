<?php
require_once("Varsayilancontroller.php");

class Sifreler extends Varsayilancontroller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Ayarlar_Model");
		$this->load->model("Sifreler_Model");
	}
	public function index()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
			$girebilir = False;
			if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["sifreler"] == 1) {
				$girebilir = True;
			}
			if ($girebilir) {
				$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Müşteri Şifreleri", "sifreler", array(), "inc/datatables"));
			} else {
				redirect(base_url());
			}
		} else {
			$this->load->view('giris', array("girisHatasi" => ""));
		}
	}

	public function getir()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
			$girebilir = False;
			if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["sifreler"] == 1) {
				$girebilir = True;
			}
			if ($girebilir) {
				$data = $this->Sifreler_Model->getir();
				echo json_encode(array("mesaj" => "", "data" => $data, "sonuc" => 1));
			} else {
				echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için yetkiniz bulunmuyor", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
	public function ekle()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
			$girebilir = False;
			if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["sifreler"] == 1) {
				$girebilir = True;
			}
			if ($girebilir) {
				$ekle = $this->Sifreler_Model->ekle();
				if ($ekle) {
					echo json_encode(array("mesaj" => "Şifre ekleme başarılı", "sonuc" => 1));
				} else {
					echo json_encode(array("mesaj" => "Şifre ekleme başarısız. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
				}
			} else {
				echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için yetkiniz bulunmuyor", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
	public function duzenle($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
			$girebilir = False;
			if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["sifreler"] == 1) {
				$girebilir = True;
			}
			if ($girebilir) {
				$duzenle = $this->Sifreler_Model->duzenle($id);
				if ($duzenle) {
					echo json_encode(array("mesaj" => "Şifre düzenleme başarılı", "sonuc" => 1));
				} else {
					echo json_encode(array("mesaj" => "Şifre düzenleme başarısız. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
				}
			} else {
				echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için yetkiniz bulunmuyor", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
	public function sil($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
			$girebilir = False;
			if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["sifreler"] == 1) {
				$girebilir = True;
			}
			if ($girebilir) {
				$sil = $this->Sifreler_Model->sil($id);
				if ($sil) {
					echo json_encode(array("mesaj" => "Şifre silme başarılı", "sonuc" => 1));
				} else {
					echo json_encode(array("mesaj" => "Şifre silme başarısız. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
				}
			} else {
				echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için yetkiniz bulunmuyor", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
}
