<?php
echo '<!DOCTYPE html>
<html lang="tr">
<head>';
$this->load->view("inc/meta");

echo '<title>Barkod ' . ($test ? "0" : $cihaz->id) . '</title>';
echo '<script src="' . base_url("dist/js/qrcode.min.js") . '"></script>';

$ayarlar = $this->Ayarlar_Model->getir();

echo '
<style>
@page {
    size: 40mm 19mm;
    margin: 0;
}

html, body {
    width: 40mm;
    height: 19mm;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* ANA KUTU */
.etiket {
    width: 40mm;
    height: 19mm;
    padding: 1mm 1mm 0 1mm;
    box-sizing: border-box;
}

/* ÜST */
.ust {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 6pt;
    font-weight: 1000 !important;
    border-bottom: 0.2mm solid #000;
    padding-bottom: 0.3mm;
}

/* ALT */
.alt {
    display: flex;
    height: 12mm;
    margin-top: 0.5mm;
}

/* QR */
.qr {
    width: 13mm;
    height: 13mm;
}

/* SAĞ */
.sag {
    flex: 1;
    padding-left: 1mm;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    gap: 0.3mm;
}

/* SERVİS NO */
.servis {
    font-size: 7pt;
    font-weight: 1000 !important;
    line-height: 1;
}

/* AYRAÇ */
.cizgi {
    border-top: 0.2mm solid #000;
    margin: 0.3mm 0;
}

/* MÜŞTERİ */
.musteri {
    font-size: 6pt;
    font-weight: 1000 !important;
    line-height: 1.1;
    word-break: break-word;
}

@media print {
    body {
        margin: 0;
        font-weight: 1000 !important;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    new QRCode(document.getElementById("qrkod"), {
        text: "biltekts://' . ($test ? "0000000000" : addslashes($cihaz->servis_no)) . '",
        width: 13 * 3.78,  // mm → px
        height: 13 * 3.78
    });

    setTimeout(function(){
        window.print();
    }, 500);
});
</script>

</head>
<body onafterprint="self.close()">

<div class="etiket">

    <div class="ust">
        <div>' . htmlspecialchars($ayarlar->barkod_ad) . '</div>
        <div>' . ($test ? "01.01.2020" : substr($cihaz->tarih, 0, -5)) . '</div>
    </div>

    <div class="alt">
        <div id="qrkod" class="qr"></div>
        <div class="sag">
            <div class="servis">' . ($test ? "0000000000" : $cihaz->servis_no) . '</div>
            <div class="cizgi"></div>
            <div class="musteri">' . htmlspecialchars($test ? "Müşteri Adı" : $cihaz->musteri_adi) . '</div>
        </div>
    </div>

</div>

</body>
</html>';