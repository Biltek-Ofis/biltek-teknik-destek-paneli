<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "yedek_durumu",
    "name" => "yedek_durumu",
    "placeholder" => "Yedekleme İşlemi",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$options = array();

for ($i = 0; $i < count($this->Islemler_Model->evetHayir); $i++) {
    $option = array(
        "value" => $i,
        "text" => $i == 0 ? "Yedek alınacak mı?" : $this->Islemler_Model->evetHayir[$i],
        "selected" => isset($yedek_durumu_value) && $yedek_durumu_value == $i,
    );
    array_push($options, $option);
}
$info["options"] = $options;
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));
