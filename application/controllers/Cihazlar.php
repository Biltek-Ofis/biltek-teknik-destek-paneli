<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cihazlar extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model("Anasayfa_Model");
    }
	public function index($tur)
	{
		if ($this->Anasayfa_Model->kullaniciGiris()){
			$veri = array(
				"baslik" => $this->Anasayfa_Model->cihazTuru($tur),
				"cihazlar" => $this->Anasayfa_Model->cihazlarTekTur($tur),
				"cihazTurleri" => $this->Anasayfa_Model->cihazTurleri(),
				"suankiCihazTuru" => $tur,
			);
			$this->load->view('cihazlar', $veri);
		}else{
			$this->load->view('giris', array("girisHatasi"=> ""));
		}
	}
	public function cihazlarJQ($tur, $id){
        if ($this->Anasayfa_Model->kullaniciGiris()){
		    echo json_encode($this->Anasayfa_Model->cihazlarTekTurJQ($tur, $id));
        }
	}
	public function cihazlarTumuJQ($tur){
        if ($this->Anasayfa_Model->kullaniciGiris()){
		    echo json_encode($this->Anasayfa_Model->cihazlarTekTurTumuJQ($tur));
        }
	}
	public function cihazSil($tur, $id){
        if ($this->Anasayfa_Model->kullaniciGiris()){
			$sil = $this->Anasayfa_Model->cihazSil($id);
			if($sil){
				redirect(base_url("cihazlar/".$tur));
			}else{
				redirect(base_url("cihazlar/".$tur));
			}
		}else{
			$this->load->model("Kullanicilar_Model");
			$this->Kullanicilar_Model->girisUyari("cihazlar/".$tur);
		}
    }
}
