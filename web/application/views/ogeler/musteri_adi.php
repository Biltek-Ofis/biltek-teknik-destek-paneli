<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!isset($musteri_adi_oto)){
    $musteri_adi_oto = TRUE;
}
?>
    <input id="musteri_kod" name="musteri_kod" type="hidden" value="<?=isset($musteri_kod_value) ? $musteri_kod_value : "";?>">
<?php
$info = array(
    "id" => "musteri_adi".$musteri_adi_sayi,
    "name" => "musteri_adi",
    "placeholder" => "Müşteri Adı Soyadı *",
    "value" => isset($musteri_adi_value) ? $musteri_adi_value : "",
    "required" => TRUE,
    "ek" => ' data-mainform="'.$musteri_adi_form.'" data-oto="'.($musteri_adi_oto ? "true" : "false").'"',
    "class" => "musteri_adi",
    "ekDiv" => '<ul id="musteri_adi_liste" class="typeahead dropdown-menu col musteri_adi_liste" style="max-height:300px;overflow-y: auto;" role="listbox"></ul>',
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));
