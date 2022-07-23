<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anasayfa extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model("Anasayfa_Model");
    }
	public function index()
	{
		if ($this->Anasayfa_Model->kullaniciGiris()){
			$veri = array(
				"teslimEdilenCihazlar" => $this->Anasayfa_Model->teslimEdilenCihazlar(),
				"devamEdenCihazlar" => $this->Anasayfa_Model->devamEdenCihazlar(),
				"cihazTurleri" => $this->Anasayfa_Model->cihazTurleri(),
			);
			$this->load->view('anasayfa', $veri);
		}else{
			$this->load->view('giris', array("girisHatasi"=> ""));
		}
	}
	public function devamEdenCihazlarJQ($id){
		echo json_encode($this->Anasayfa_Model->devamEdenCihazlarJQ($id));
	}
	public function teslimEdilenCihazlarJQ($id){
		echo json_encode($this->Anasayfa_Model->teslimEdilenCihazlarJQ($id));
	}
	public function cihazEkle()
	{
		if ($this->Anasayfa_Model->kullaniciGiris()){
			$veri = array(
				"musteri_adi"=> $this->input->post("musteri_adi"),
				"cihaz_turu"=> $this->input->post("cihaz_turu"),
				"cihaz" => $this->input->post("cihaz"),
				"ariza_aciklamasi"=> $this->input->post("ariza_aciklamasi")
			);
			$ekle = $this->Anasayfa_Model->cihazEkle($veri);
			if($ekle){
				redirect(base_url());
			}else{
				$this->load->model("Kullanicilar_Model");
				$this->Kullanicilar_Model->girisUyari();
			}
		}else{
			$this->load->model("Kullanicilar_Model");
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazSil($id)
	{
		if ($this->Anasayfa_Model->kullaniciGiris()){
			$sil = $this->Anasayfa_Model->cihazSil($id);
			if($sil){
				redirect(base_url());
			}else{
				redirect(base_url());
			}
		}else{
			$this->load->model("Kullanicilar_Model");
			$this->Kullanicilar_Model->girisUyari();
		}
	}
}
