<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "kullanici_adi" . (isset($id) ? $id : ""),
    "name" => "kullanici_adi",
    "label" => "Kullanıcı Adı",
    "placeholder" => "Kullanıcı Adı",
    "required" => TRUE,
    "value" => isset($value) ? $value : "",
    "minlength" => "3",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));
