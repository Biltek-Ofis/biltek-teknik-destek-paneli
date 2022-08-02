<?php
require_once("varsayilan_controller.php");

class Js extends Varsayilan_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->model("Js_Model");
	}
    public function index(){
        redirect(base_url());
    }
    public $musteriAdi = "CARI_ISIM";
    public function musteri_adi($ara){
        echo json_encode($this->Js_Model->musteri_bilgileri($this->musteriAdi,$ara));
    }
}
