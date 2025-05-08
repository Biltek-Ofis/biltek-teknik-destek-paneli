<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "tahsilat_sekli",
    "name" => "tahsilat_sekli",
    "placeholder" => "Tahsilat Şekli",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$options = array(
    array(
        "value" => "0",
        "text" => "Tahsilat Şekli Seçin",
    )
);

foreach ($this->Cihazlar_Model->tahsilatSekilleri() as $tahsilatSekli) {
    $option = array(
        "value" => $tahsilatSekli->id,
        "text" => $tahsilatSekli->isim,
        "selected" => isset($tahsilat_sekli_value) && $tahsilat_sekli_value == $tahsilatSekli->id,
    );
    array_push($options, $option);
}
$info["options"] = $options;
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));
