<?php
require_once("Varsayilancontroller.php");

class Medyalar extends Varsayilancontroller
{

	public function __construct()
	{
		parent::__construct();
	}
	public function index($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
            $this->load->view("icerikler/medyalar", array("id"=>$id));
		}
	}
}
