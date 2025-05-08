<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "cihazdaki_hasar",
    "name" => "cihazdaki_hasar",
    "placeholder" => "Servis Türü",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$options = array();

for ($i = 0; $i < count($this->Islemler_Model->cihazdakiHasar); $i++) {
    $option = array(
        "value" => $i,
        "text" => $i == 0 ? "Hasar Türü Belirtin" : $this->Islemler_Model->cihazdakiHasar[$i],
        "selected" => isset($cihazdaki_hasar_value) && $cihazdaki_hasar_value == $i,
    );
    array_push($options, $option);
}
$info["options"] = $options;
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));