<?php
require_once("Varsayilancontroller.php");

class Medyalar extends Varsayilancontroller
{

	public function __construct()
	{
		parent::__construct();
	}
	public function index($id, $sil_butonu="0")
	{
		$sil_butonu = $sil_butonu == "1" ? true : false;
		if ($this->Giris_Model->kullaniciGiris()) {
            $this->load->view("icerikler/medyalar", array("id"=>$id, "silButonu" => $sil_butonu));
		}
	}
}
