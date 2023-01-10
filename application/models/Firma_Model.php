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
    public function musteriTablosu() {
        return getenv(DB_ON_EK_STR)."musteriler";
    }
    public $stokTablosu = "TBLSTSABIT";
    public function musteri_bilgileri($aranacak, $ara)
    {
        return $this->ara($this->musteriTablosu(), $aranacak, $ara);
        //return $this->firmadb()->like('LOWER(' . $aranacak . ')', strtolower($ara))->get($this->musteriTablosu())->result();
    }
    public function stok($aranacak, $ara)
    {
        return $this->ara($this->stokTablosu, $aranacak, $ara);
        //return $this->firmadb()->like($aranacak, "N'" . $ara . "'")->get($this->stokTablosu)->result();
    }
    public function ara($tablo, $aranacak, $ara)
    {
        //$ara = $this->Islemler_Model->turkceKarakterArama($ara);
        //return $this->firmadb()->query("SELECT * FROM " . $tablo . " WHERE " . $aranacak . " LIKE N'%" . $ara . "%' collate Turkish_CI_AS")->result();
        return $this->db->like($aranacak, $ara)->get($tablo)->result();
    }
}
