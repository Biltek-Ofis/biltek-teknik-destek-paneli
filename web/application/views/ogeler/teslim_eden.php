<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "teslim_eden",
    "name" => "teslim_eden",
    "placeholder" => "Teslim Eden Kişi",
    "value" => isset($teslim_eden_value) ? $teslim_eden_value : "",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));
