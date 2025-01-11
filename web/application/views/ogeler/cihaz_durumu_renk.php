<?php
echo '<div class="row';
if (isset($sifirla)) {
    echo " p-0 ml-1";
}else{
    echo " ml-1";
}
echo '"><label class="ml-0">Arkaplan Rengi</label></div>';
echo '<div class="row">';
echo '<div class="form-check';
if (isset($sifirla)) {
    echo " p-0 ml-3";
}else{
    echo " ml-3";
}
echo '">';

// Mavi
//!isset($renk_kodu) || !isset($renk_ismi) || !isset($renk_value)
$renkArray = array();
if(isset($cihaz_durumu_renk_value)){
    $renkArray["cihaz_durumu_renk_value"] = $cihaz_durumu_renk_value;
}
if(isset($id)){
    $renkArray["id"] = $id;
}

$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"white", "renk_ismi"=>"Beyaz"), $renkArray));
$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"dark", "renk_ismi"=>"Siyah"), $renkArray));
$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"secondary", "renk_ismi"=>"Gri"), $renkArray));
$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"primary", "renk_ismi"=>"Mavi"), $renkArray));
$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"success", "renk_ismi"=>"Yeşil"), $renkArray));
$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"danger", "renk_ismi"=>"Kırmızı"), $renkArray));
$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"pink", "renk_ismi"=>"Pembe"), $renkArray));
$this->load->view("ogeler/cihaz_durumu_renk_radio", array_merge(array("renk_kodu"=>"warning", "renk_ismi"=>"Turuncu"), $renkArray));

echo '</div>';

echo '</div>';
