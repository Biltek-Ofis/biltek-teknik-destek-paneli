<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "kullanici_teknikservis",
    "name" => "teknikservis",
    "label" => "Teknik Servis Elemanı",
    "placeholder" => "Teknik Servis Elemanı",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}

$optionEvet = array(
    "value" => "1",
    "text" => "Evet",
    "selected" => isset($value) && $value == 1,
);
$optionHayir = array(
    "value" => "0",
    "text" => "Hayır",
    "selected" => isset($value) && $value == 0,
);
$info["options"] = array(
    $optionEvet,
    $optionHayir,
);
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));
