<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!isset($tarih_id)){
    $tarih_id = "tarih";
}

$info = array(
    "id" => $tarih_id,
    "name" => "tarih",
    "type" => "datetime-local",
    "value" => isset($tarih_value) ? $this->Islemler_Model->tarihDonusturInput($tarih_value) : "",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));
