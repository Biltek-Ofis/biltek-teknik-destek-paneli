<?php
$urun = array();
if(isset($urun_id)){
    $urun = $this->Urunler_Model->urunGetir($urun_id)[0];
}
echo '<div class="row">';
$this->load->view("ogeler/urun/isim", array("isim_value"=> isset($urun_id) ? $urun->isim : ""));
echo '</div>';
if(isset($urun_id)){
    echo '
                    <div class="row">';
$this->load->view("ogeler/urun/aciklama", array("aciklama_value"=> $urun->aciklama));
echo '</div>';
}
echo '
                    <div class="row">';
$this->load->view("ogeler/urun/barkod", array("barkod_value"=> isset($urun_id) ? $urun->barkod : ""));
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/urun/stokkodu", array("stokkodu_value"=> isset($urun_id) ? $urun->stokkodu : ""));
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/urun/alis", array("alis_value"=> isset($urun_id) ? $urun->alis : ""));
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/urun/satis", array("satis_value"=> isset($urun_id) ? $urun->satis : ""));
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/urun/indirimli", array("indirimli_value"=> isset($urun_id) ? $urun->indirimli : ""));
echo '</div>';
?>