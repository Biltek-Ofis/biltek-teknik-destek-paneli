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
        return DB_ON_EK_STR."musteriler";
    }
    public $stokTablosu = "TBLSTSABIT";
    public function musteriBilgileri($aranacak, $ara, $limit = 0)
    {
        return $this->ara($this->musteriTablosu(), $aranacak, $ara, $limit, array('musteri_adi' => 'ASC'));
        //return $this->firmadb()->like('LOWER(' . $aranacak . ')', strtolower($ara))->get($this->musteriTablosu())->result();
    }
    public function stok($aranacak, $ara, $limit = 0)
    {
        return $this->ara($this->stokTablosu, $aranacak, $ara, $limit);
        //return $this->firmadb()->like($aranacak, "N'" . $ara . "'")->get($this->stokTablosu)->result();
    }
    public function ara($tablo, $aranacak, $ara, $limit = 0, $order_by = array())
    {
        //$ara = $this->Islemler_Model->turkceKarakterArama($ara);
        //return $this->firmadb()->query("SELECT * FROM " . $tablo . " WHERE " . $aranacak . " LIKE N'%" . $ara . "%' collate Turkish_CI_AS")->result();
        $query = $this->db->reset_query()->like($aranacak, $ara);
        if($limit > 0){
            $query = $query->limit($limit);
        }
        if(count($order_by) > 0) {
            foreach ($order_by as $column => $direction) {
                $query = $query->order_by($column, $direction);
            }
        }
        return $query->get($tablo)->result();
    }
}
