<?php
defined('BASEPATH') or exit('No direct script access allowed');

$kullaniciBilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();

$info = array(
    "id" => "sorumlu",
    "name" => "sorumlu",
    "type" => "hidden",
    "value"=>(isset($sorumlu_text_value) ? $sorumlu_text_value : ($kullaniciBilgileri["id"] != "" ? $kullaniciBilgileri["id"] : "0")),
);
$this->load->view("ogeler/hazir/standart", array(
    "info" => $info,
));