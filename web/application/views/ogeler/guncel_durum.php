<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<input type="hidden" name="guncel_durum_suanki" value="<?=(isset($guncel_durum_value) ? $guncel_durum_value : 0) ;?>">
<?php


$info = array(
    "id" => "guncel_durum",
    "name" => "guncel_durum",
    "placeholder" => "Güncel Durum",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$options = array();

$cihazDurumlari = $this->Cihazlar_Model->cihazDurumlari();

foreach ($cihazDurumlari as $cihazDurumu) {
    $option = array(
        "value" => $cihazDurumu->id,
        "text" => ($cihazDurumu->varsayilan > 0 ? "Güncel Durum Seçin (" : "") . $cihazDurumu->durum . ($cihazDurumu->varsayilan > 0 ? ")" : ""),
        "selected" => isset($guncel_durum_value) && $guncel_durum_value == $cihazDurumu->id,
    );
    array_push($options, $option);
}
$info["options"] = $options;
$this->load->view("ogeler/hazir/select", array(
    "info" => $info,
));

