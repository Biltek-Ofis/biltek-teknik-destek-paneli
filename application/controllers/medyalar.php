<?php
require_once("varsayilan_controller.php");

class Medyalar extends Varsayilan_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Islemler_Model");
	}
	public function index($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
            $this->load->view("icerikler/medyalar", array("id"=>$id));
		}
	}
}
