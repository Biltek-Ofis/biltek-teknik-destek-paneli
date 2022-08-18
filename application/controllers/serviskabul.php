<?php
require_once("varsayilan_controller.php");

class ServisKabul extends Varsayilan_Controller
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
