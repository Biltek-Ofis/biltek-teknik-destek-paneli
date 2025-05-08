<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "kullanici_sifre".(isset($id) ? $id : ""),
    "name" => "sifre",
    "label" => "Şifre",
    "placeholder"=> "Şifre",
    "type" => "password",
    "required"=> TRUE,
    "value" => isset($value) ? $value : "",
    "minlength"=> 6,
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));
