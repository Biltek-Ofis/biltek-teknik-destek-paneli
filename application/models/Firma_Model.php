<?php
class Firma_Model extends CI_Model
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
    public $stokTablosu = "TBLSTSABIT";
    public function musteri_bilgileri($aranacak, $ara)
    {
        return $this->ara($this->musteriTablosu, $aranacak, $ara);
        //return $this->firmadb()->like('LOWER(' . $aranacak . ')', strtolower($ara))->get($this->musteriTablosu)->result();
    }
    public function stok($aranacak, $ara)
    {
        return $this->ara($this->stokTablosu, $aranacak, $ara);
        //return $this->firmadb()->like($aranacak, "N'" . $ara . "'")->get($this->stokTablosu)->result();
    }
    public function ara($tablo, $aranacak, $ara)
    {
        return $this->firmadb()->query("SELECT * FROM " . $tablo . " WHERE " . $aranacak . " LIKE N'%" . $ara . "%' collate Turkish_CI_AS")->result();
    }
}
