<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");

echo '<title>SERVİS KABUL FORMU ' . $cihaz->id . '</title>';

$this->load->view("inc/styles");
$this->load->view("inc/scripts");
echo '<script src="' . base_url("dist/js/JsBarcode.all.min.js") . '"></script>';
echo '<script src="' . base_url("dist/js/qrcode.min.js") . '"></script>';
$this->load->view("inc/style_yazdir");
$this->load->view("inc/style_yazdir_tablo");
echo '<style>';
echo 'body{
        font-size:13px !important;
    }';
echo '</style>';
echo '</head>';

echo '<body onafterprint="self.close()">
    <div class="dondur">
        <div class="row">
            ';
$this->load->view("icerikler/servis_kabul/tablo", array("cihaz" => $cihaz, "barcode_script" => 'JsBarcode("#barcode1", "' . $cihaz->servis_no . '", {
    width: 2,
    height: 40,
    displayValue: false
});', "barcode_div" => '<svg style="max-width:20%;" id="barcode1"></svg>'));
echo '<div class="col-2"></div>';
$this->load->view("icerikler/servis_kabul/tablo", array("cihaz" => $cihaz,  "barcode_script" => 'new QRCode(document.getElementById("barcode2"), {
	text: "' . $cihaz->servis_no . '",
	width: 40,
	height: 40,
	colorDark : "#000000",
	colorLight : "#ffffff",
	correctLevel : QRCode.CorrectLevel.H
});
$("#barcode2 > img").css({"margin":"auto"});', "barcode_div" => '<span style="max-width:20%;" id="barcode2"></span>'));
echo '</div>
    </div>
    <div class="dondur">
        <div class="row">';
        $this->load->view("icerikler/servis_kabul/aciklama");
        echo '<div class="col-2"></div>';
        $this->load->view("icerikler/servis_kabul/aciklama");
echo '</div>
</div>
</body>

</html>';
