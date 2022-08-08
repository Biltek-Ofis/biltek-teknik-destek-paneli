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
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "cihaz_yonetimi", [], "inc/datatables"));
        }else{
			$this->Kullanicilar_Model->girisUyari("cikis");
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
			$veri = $this->Cihazlar_Model->cihazPost();
			$ekle = $this->Cihazlar_Model->cihazEkle($veri);
			if($ekle){
				//$id = $this->db->insert_id();
				redirect(base_url(""));
			}else{
				$this->Kullanicilar_Model->girisUyari("", "Ekleme işlemi gerçekleştirilemedi. ");
			}
		}else{
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function cihazSil($id)
	{
		if ($this->Giris_Model->kullaniciGiris()){
			$sil = $this->Cihazlar_Model->cihazSil($id);
			if($sil){
				redirect(base_url(""));
			}else{
				$this->Kullanicilar_Model->girisUyari("", "Silme işlemi gerçekleştirilemedi");
			}
		}else{
			$this->Kullanicilar_Model->girisUyari("cikis");
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
				redirect(base_url("")."#".$this->Cihazlar_Model->cihazDetayModalAdi().$id);
			} else {
				$this->Kullanicilar_Model->girisUyari("#".$this->Cihazlar_Model->cihazDetayModalAdi().$id, "Teslim durumu güncelleme işlemi gerçekleştirilemedi");
			}
		}else{
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function cikisTarihi($id)
	{
		if ($this->Giris_Model->kullaniciGiris()){
			$sil = $this->Cihazlar_Model->cikisTarihi($id);
			if($sil){
				redirect(base_url("")."#".$this->Cihazlar_Model->cihazDetayModalAdi().$id);
			} else {
				$this->Kullanicilar_Model->girisUyari("#".$this->Cihazlar_Model->cihazDetayModalAdi().$id, "Teslim durumu güncelleme işlemi gerçekleştirilemedi");
			}
		}else{
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
}

?>