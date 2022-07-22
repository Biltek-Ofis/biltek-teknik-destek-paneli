<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cikis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->load->model("Anasayfa_Model");
        $this->Anasayfa_Model->oturumSifirla();
        redirect(base_url());
    }
}
;?>