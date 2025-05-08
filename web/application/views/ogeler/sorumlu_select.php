<?php
defined('BASEPATH') or exit('No direct script access allowed');

$sorumlular123 = $this->Kullanicilar_Model->kullanicilar();

$info = array(
    "id" => "sorumlu",
    "name" => "sorumlu",
    "placeholder" => "Sorumlu",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$options = array(
    array(
        "value" => "",
        "text" => "Sorumlu Personel Seçin *",
    )
);

foreach ($sorumlular123 as $sorumlu) {
    if($sorumlu->teknikservis == 1){
    $option = array(
        "value" => $sorumlu->id,
        "text" =>$sorumlu->ad_soyad,
        "selected" => isset($sorumlu_value) && ($sorumlu_value == $sorumlu->ad_soyad || $sorumlu_value == $sorumlu->id),
    );
    array_push($options, $option);
}
}
$info["options"] = $options;
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));
