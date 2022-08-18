<?php
require_once("Varsayilancontroller.php");

class ServisKabul extends Varsayilancontroller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index($servis_no = "")
    {
        $this->load->view("icerikler/servis_kabul/ara", array("servis_no" => $servis_no));
    }
}
