<?php
require_once("Varsayilancontroller.php");

class Notlar extends Varsayilancontroller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Notlar_Model");
		$this->load->model("Giris_Model");
	}
	public function index()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Notlar", "notlar", [], "inc/datatables"));
		} else {
			redirect(base_url());
		}
	}
	public function getir()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$data = $this->Notlar_Model->getir();
			echo json_encode(array("mesaj" => "", "data" => $data, "sonuc" => 1));
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
	public function ekle()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$ekle = $this->Notlar_Model->ekle();
			if ($ekle) {
				echo json_encode(array("mesaj" => "Not ekleme başarılı", "sonuc" => 1));
			} else {
				echo json_encode(array("mesaj" => "Not ekleme başarısız. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
	public function duzenle($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$duzenle = $this->Notlar_Model->duzenle($id);
			if ($duzenle) {
				echo json_encode(array("mesaj" => "Not düzenleme başarılı", "sonuc" => 1));
			} else {
				echo json_encode(array("mesaj" => "Not düzenleme başarısız. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
	public function sil($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$sil = $this->Notlar_Model->sil($id);
			if ($sil) {
				echo json_encode(array("mesaj" => "Not silme başarılı", "sonuc" => 1));
			} else {
				echo json_encode(array("mesaj" => "Not silme başarısız. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
			}
		} else {
			echo json_encode(array("mesaj" => "Lütfen önce kullanıcı girişi yapın", "sonuc" => 0));
		}
	}
}
