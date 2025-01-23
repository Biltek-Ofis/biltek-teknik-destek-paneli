<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");

echo '<title>Barkod ' . ($test ? "0" : $cihaz->id) . '</title>';

$this->load->view("inc/styles");
$this->load->view("inc/scripts");

$ayarlar = $this->Ayarlar_Model->getir();
echo '<script src="' . base_url("dist/js/JsBarcode.all.min.js") . '"></script>';
$style = "width: ".$ayarlar->barkod_en."mm;
            height: ".$ayarlar->barkod_boy."mm;
            size: ".$ayarlar->barkod_en."mm ".$ayarlar->barkod_boy."mm;
            font-weight: 1000 !important;
            word-break: break-word;
            page-break-before: always;
            display: inline;";
$tableStyle = "
            body, table {
                padding: 0 !important;
                margin: 0 !important;
            }
            table thead,table thead tr,table thead tr td{
                height:0 !important;
                line-height:0 !important;
                padding:0 !important;
                margin:0 !important;
            }
            table tr .icerik{
                font-size:".$ayarlar->barkod_numarasi_boyutu."pt !important;
                max-height: 4mm !important;
                display:inline;
            }
            table tr:nth-child(2) .icerik{
                max-height: " . $ayarlar->barkod_boyutu . "mm !important;
            }
            table tr:first-child .icerik{
                font-size:".$ayarlar->barkod_sirket_adi_boyutu."pt !important;
            }
            table tr:last-child .icerik{
                font-size:".$ayarlar->barkod_musteri_adi_boyutu."pt !important;
            }
            table tbody tr:last-child{
                page-break-after: auto;
            }
            ";
echo '
    <style>
        body {
            margin: 0;
            ' . $style . '
        }

        @page {
            margin: 0;
            ' . $style . '
        }
        ' . $tableStyle . '
        @media print {
            body {
                margin: 0;
                ' . $style . '
            }
            @page {
                margin: 0;
                ' . $style . '
            }
            ' . $tableStyle . '
        }
    </style>
    <script>
    $(document).ready(function() {
        setTimeout(function(){
            window.print();
        },1000);
    });
    </script>
</head>';
echo '<body onafterprint="self.close()" class="ozel_tema_yok">
    <script>
    $(document).ready(function(){
        JsBarcode("#barkod", "' . ($test ? "0000000000" : $cihaz->servis_no) . '", {
            width: 2,
            height: 30,
            displayValue: true,
            fontSize: 18,
            fontOptions: "bold"
        });
        $("#barkod").css({"height":"' . $ayarlar->barkod_boyutu . 'mm"});
    });
    </script>
    <table class="table table-borderless">
        <thead>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody class="p-1">
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="5"><div class="icerik">' . $ayarlar->barkod_ad . '</div></td>
            <td class="p-0 pl-1 pr-1 m-0 text-right" colspan="7"><div class="icerik">' . ($test ? "01.01.2020" : substr($cihaz->tarih, 0, -5)) . '</div></td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="12"><div class="icerik"><svg style="width:100%;" id="barkod"></svg></div></td>
        </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="12"><div class="icerik">';
$musteri_adi = $test ? "Müşteri Adı" : $cihaz->musteri_adi;
if (strlen($musteri_adi) > 40) {
    // echo rtrim(explode(";;", wordwrap($musteri_adi, 35, ";;"))[0]) . '...';
    echo rtrim(str_split($musteri_adi, 40)[0]) . '...';
} else {
    echo $musteri_adi;
}
echo '</div></td>
            </tr>
        </tbody>
    </table>
</body>

</html>';