<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "tarih_girisi",
    "name" => "tarih_girisi",
    "label" => "Giriş Tarihi:",
    "placeholder" => "Tarih Girişi",
    "options" =>array(
        array(
            "value" => "oto",
            "text" => "Otomatik (Güncel Tarih)",
            "selected" => TRUE,
        ),
        array(
            "value" => "el",
            "text" => "El ile Giriş",
        ),
    )
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));