<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "teslim_alinanlar",
    "name" => "teslim_alinanlar",
    "placeholder" => "Teslim Alınanlar",
    "value" => isset($teslim_alinanlar_value) ? $teslim_alinanlar_value : "",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/textarea", array(
    "info" => $info,
));
