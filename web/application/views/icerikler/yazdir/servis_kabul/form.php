<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $this->load->view("inc/meta");
    ?>
    <title>SERVİS KABUL FORMU <?= $cihaz->id; ?></title>
    <?php
    $this->load->view("inc/eski/styles");
    $this->load->view("inc/eski/scripts");
    ?>
    <script src="<?= base_url("dist/js/JsBarcode.all.min.js?v=1.0"); ?>"></script>
    <script src="<?= base_url("dist/js/qrcode.min.js?v=1.0"); ?>"></script>
    <?php
    $this->load->view("inc/style_yazdir");
    $this->load->view("inc/style_yazdir_tablo");
    $this->load->view("inc/styles_important");
    ?>
    <style>
        body {
            font-size: 13pt !important;
        }

        @media print {
            body {
                font-size: 13pt !important;
            }

            @page {
                font-size: 13pt !important;
            }
        }
    </style>
</head>

<body onafterprint="self.close()" class="ozel_tema_yok">
    <div class="dondur">
        <div class="row">
            <?php

            $this->load->view("icerikler/yazdir/servis_kabul/tablo", array(
                "cihaz" => $cihaz,
                "barcode_script" => 'JsBarcode("#barcode1", "' . $cihaz->servis_no . '", {
    width: 2,
    height: 40,
    displayValue: false
});
$("#barcode1").css({"height":"3cm"})',
                "barcode_div" => '<svg style="max-width:20%;" id="barcode1"></svg>'
            ));
            ?>
            <div class="col-2"></div>
            <?php
            $this->load->view("icerikler/yazdir/servis_kabul/tablo", array(
                "cihaz" => $cihaz,
                "barcode_script" => 'new QRCode(document.getElementById("barcode2"), {
	text: "' . base_url("cihazdurumu") . '/' . $cihaz->takip_numarasi . '",
	width: 80,
	height: 80,
	colorDark : "#000000",
	colorLight : "#ffffff",
	correctLevel : QRCode.CorrectLevel.H
});
$("#barcode2 > img").css({"margin":"auto", "width":"3cm", "height":"3cm"});',
                "barcode_div" => '<span style="max-width:20%;" id="barcode2"></span>'
            ));
            ?>
        </div>
    </div>
    <div class="dondur">
        <div class="row">
            <?php
            $this->load->view("icerikler/yazdir/servis_kabul/aciklama");
            ?>
            <div class="col-2"></div>
            <?php
            $this->load->view("icerikler/yazdir/servis_kabul/aciklama");
            ?>
        </div>
    </div>
</body>

</html>