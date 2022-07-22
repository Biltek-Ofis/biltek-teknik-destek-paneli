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
			);
			$this->load->view('anasayfa', $veri);
		}else{
			$this->load->view('giris', array("girisHatasi"=> ""));
		}
	}
	public function cihazEkle()
	{
		$musteri_adi = $this->input->post("musteri_adi");
        $cihaz = $this->input->post("cihaz");
        $ariza_aciklamasi = $this->input->post("ariza_aciklamasi");
		$veri = array(
			"musteri_adi"=> $this->input->post("musteri_adi"),
			"cihaz"=> $this->input->post("cihaz"),
			"ariza_aciklamasi"=> $this->input->post("ariza_aciklamasi")
		);
		$ekle = $this->Anasayfa_Model->cihazEkle($veri);
		if($ekle){
			redirect(base_url());
		}else{
			redirect(base_url());
		}
	}
	public function cihazSil($id)
	{
		$sil = $this->Anasayfa_Model->cihazSil($id);
		if($sil){
			redirect(base_url());
		}else{
			redirect(base_url());
		}
	}
}
