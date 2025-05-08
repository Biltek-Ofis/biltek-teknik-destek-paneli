<?php
defined('BASEPATH') or exit('No direct script access allowed');

$info = array(
    "id" => "hasar_tespiti",
    "name" => "hasar_tespiti",
    "placeholder" => "Teslim alınırken yapılan hasar tespiti",
    "value" => isset($hasar_tespiti_value) ? $hasar_tespiti_value : "",
);
if (isset($sifirla)) {
    $info["sifirla"] = $sifirla;
}
$this->load->view("ogeler/hazir/textarea", array(
    "info" => $info,
));
