<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "kullanici_yonetici",
    "name" => "yonetici",
    "placeholder" => "Yönetici",
    "label" => "Hesap Türü",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}

$hesapTuru = -1;
if (isset($kullaniciTuru)) {
    $hesapTuru = $kullaniciTuru;
}

$info["options"] = array(
    array(
        "value" => "0",
        "text" => "Personel",
        "selected" => (isset($value) && $value == 0) || $hesapTuru == 0,
    ),
    array(
        "value" => "1",
        "text" => "Yönetici",
        "selected" => (isset($value) && $value == 1) || $hesapTuru == 1,
    ),
);
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));
