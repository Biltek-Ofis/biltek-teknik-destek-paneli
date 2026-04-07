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
    size: 40mm 20mm;
    margin: 0;
}

html, body {
    width: 40mm;
    height: 20mm;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* ANA KUTU */
.etiket {
    width: 40mm;
    height: 20mm;
    padding: 1mm 1mm 0 1mm;
}

/* ÜST */
.ust {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 5pt;
    font-weight: bold;
    border-bottom: 0.2mm solid #ccc;
    padding-bottom: 0.5mm;
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
    justify-content: flex-start; /* ÖNEMLİ */
    gap: 0.4mm; /* kontrollü boşluk */
}
/* SERVİS LABEL */
.label {
    font-size: 4pt;
    color: #666;
}

/* SERVİS NO */
.servis {
    font-size: 6pt;
    font-weight: bold;
    line-height: 1;
}

/* AYRAÇ */
.cizgi {
    border-top: 0.2mm solid #ccc;
    margin: 0.5mm 0;
}

/* MÜŞTERİ */
.musteri {
    font-size: 5pt;
    font-weight: bold;
    line-height: 1.1;
    word-break: break-word;
}

@media print {
    body {
        margin: 0;
        zoom: 0.95;
    }
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

    new QRCode(document.getElementById("qrkod"), {
        text: "biltekts://' . ($test ? "0000000000" : addslashes($cihaz->servis_no)) . '",
        width: 50,
        height: 50
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

            <div>
                <div class="label">SERVİS NO</div>
                <div class="servis">' . ($test ? "0000000000" : $cihaz->servis_no) . '</div>
            </div>

            <div class="cizgi"></div>

            <div class="musteri">
                ' . htmlspecialchars($test ? "Müşteri Adı" : $cihaz->musteri_adi) . '
            </div>

        </div>

    </div>

</div>

</body>
</html>';