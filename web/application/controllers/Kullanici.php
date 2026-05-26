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
			$guncelle = $this->Kullanicilar_Model->guncelle($_SESSION["KULLANICI_ID"]);
			if($guncelle == null){
				redirect(base_url("kullanici"));
			}else{
				$this->Kullanicilar_Model->girisUyari("kullanici", $guncelle);
			}
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function tema($tema = "oto")
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
			$this->Kullanicilar_Model->duzenle($kullanici["id"], array(
				"tema" => $tema,
			));
			redirect(base_url());
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function duyuruGonder()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$gecerliKullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
			if ($gecerliKullanici["yonetici"] == 1) {
				try {
					$duyuru_baslik = $this->input->post("duyuru_baslik");
					$duyuru_mesaj = $this->input->post("duyuru_mesaj");

					$kullanicilar = $this->Kullanicilar_Model->kullanicilar();

					foreach ($kullanicilar as $kullanici) {
						$this->Kullanicilar_Model->bildirimGonder($kullanici->id, $duyuru_baslik, $duyuru_mesaj, "duyuru");
					}
					echo json_encode(array("mesaj" => "Başarılı", "sonuc" => 1));
				} catch (Exception $e) {
					echo json_encode(array("mesaj" => $e, "sonuc" => 0));
				}
			} else {
				echo json_encode(array("mesaj" => "Bu işlemi sadece yöneticiler gerçekleştirebilir.", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
	public function fcmToken(){
		if ($this->Giris_Model->kullaniciGiris() || $this->Giris_Model->kullaniciGiris(TRUE)) {
			$fcmToken = $this->input->post("token");
			$auth = $this->Giris_Model->auth();
			if(isset($auth) && strlen($auth) > 0 && isset($fcmToken) && strlen($fcmToken) > 0){
				$this->Kullanicilar_Model->fcmTokenSifirla($fcmToken);
				$this->Kullanicilar_Model->authDuzenle($auth, array(
					"fcmToken" => $fcmToken,
				));
			}
		}
	}
}
