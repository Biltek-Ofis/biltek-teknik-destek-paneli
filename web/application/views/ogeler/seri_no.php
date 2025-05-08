<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "seri_no",
    "name" => "seri_no",
    "placeholder" => "Cihazın Seri Numarası",
    "value" => isset($seri_no_value) ? $seri_no_value : "",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));
