<?php
require_once("Varsayilancontroller.php");

class ServisKabul extends Varsayilancontroller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index($takip_numarasi = "")
    {
        $this->load->view("icerikler/servis_kabul/ara", array("takip_numarasi" => $takip_numarasi));
    }
}
