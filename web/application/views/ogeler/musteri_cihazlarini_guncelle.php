<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "musteri_cihazlarini_guncelle",
    "name" => "musteri_cihazlarini_guncelle",
    "label" => "Bilgileri müşterinin cihazları için de güncelle.",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/check", array(
    "info" => $info,
));