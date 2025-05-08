<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "isim" . (isset($id) ? $id : ""),
    "name" => "isim",
    "label" => "İsim",
    "placeholder" => "İsim",
    "required" => TRUE,
    "value" => isset($tahsilat_sekli_isim_value) ? $tahsilat_sekli_isim_value : "",
    "minlength" => "3",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));
