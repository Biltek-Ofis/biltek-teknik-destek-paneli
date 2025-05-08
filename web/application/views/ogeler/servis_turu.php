<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "servis_turu",
    "name" => "servis_turu",
    "placeholder" => "Servis Türü",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$options = array(
    array(
        "value" => "0",
        "text" => "Servis Türü Seçin",
        "selected"=> isset($servis_turu_value) && $servis_turu_value == 0,
    )
);

for ($i = 1; $i <= 4; $i++) {
    
    $option = array(
        "value" => $i,
        "text" =>$this->Islemler_Model->servisTuru($i),
        "selected" => isset($servis_turu_value) && $servis_turu_value == $i,
    );
    array_push($options, $option);
}
$info["options"] = $options;
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));
