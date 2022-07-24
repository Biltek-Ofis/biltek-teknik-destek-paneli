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
            $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Cihaz Yönetimi", "cihaz_yonetimi"));
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
			$veri = array(
				"musteri_adi"=> $this->input->post("musteri_adi"),
				"cihaz_turu"=> $this->input->post("cihaz_turu"),
				"cihaz" => $this->input->post("cihaz"),
				"ariza_aciklamasi"=> $this->input->post("ariza_aciklamasi")
			);
			$ekle = $this->Cihazlar_Model->cihazEkle($veri);
			if($ekle){
				redirect(base_url("cihaz_yonetimi"));
			}else{
				$this->load->model("Kullanicilar_Model");
				$this->Kullanicilar_Model->girisUyari("/");
			}
		}else{
			$this->load->model("Kullanicilar_Model");
			$this->Kullanicilar_Model->girisUyari("/");
		}
	}
	public function cihazSil($id)
	{
		if ($this->Giris_Model->kullaniciGiris()){
			$sil = $this->Cihazlar_Model->cihazSil($id);
			if($sil){
				redirect(base_url("cihaz_yonetimi"));
			}else{
				redirect(base_url("cihaz_yonetimi"));
			}
		}else{
			$this->load->model("Kullanicilar_Model");
			$this->Kullanicilar_Model->girisUyari("/");
		}
	}
	public function silinenCihazlariBul()
	{
		echo json_encode($this->Cihazlar_Model->silinenCihazlariBul());
	}
}

?>