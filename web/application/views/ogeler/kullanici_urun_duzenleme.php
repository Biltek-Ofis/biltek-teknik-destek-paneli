<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "kullanici_urunduzenleme",
    "name" => "urunduzenleme",
    "label" => "Ürün Düzenleme",
    "placeholder" => "Ürün Düzenleme",
    "disabled" => isset($yonetici) && $yonetici == 1,
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$onceki_secildi = FALSE;

$optionEvet = array(
    "value" => "1",
    "text" => "Evet",
);
if ((isset($value) && $value == 1) || (isset($yonetici) && $yonetici == 1)) {
    $onceki_secildi = TRUE;
    $optionEvet["selected"] = TRUE;
}
$optionHayir = array(
    "value" => "0",
    "text" => "Hayır",
);
if (isset($value) && $value == 0 && !$onceki_secildi) {
    $optionHayir["selected"] = TRUE;
}
$info["options"] = array(
    $optionEvet,
    $optionHayir,
);
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));