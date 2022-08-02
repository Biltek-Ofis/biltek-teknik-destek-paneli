<?php
class Js_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function firmadb()
    {
        return $this->load->database('firma', TRUE);
    }
    public $musteriTablosu = "TBLCASABIT";
    public function musteri_bilgileri($aranacak,$ara){
        return $this->firmadb()->like($aranacak,$ara)->get($this->musteriTablosu)->result();
    }
}
