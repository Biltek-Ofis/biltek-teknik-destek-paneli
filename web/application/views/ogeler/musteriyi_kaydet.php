<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "musteriyi_kaydet",
    "name" => "musteriyi_kaydet",
    "label" => "Müşteri bilgilerini kaydet",
    "checked" => TRUE,
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/check", array(
    "info" => $info,
));