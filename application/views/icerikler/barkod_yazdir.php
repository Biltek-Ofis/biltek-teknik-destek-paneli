<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");

echo '<title>Barkod ' . $cihaz->id . '</title>';

$this->load->view("inc/styles");
$this->load->view("inc/scripts");
echo '<script src="' . base_url("dist/js/JsBarcode.all.min.js") . '"></script>';
$style = "width: 40mm;
            height: 20mm;
            size: 40mm 20mm;
            font-weight: 1000 !important;
            word-break: break-word;
            page-break-before: always;
            display: inline;";
$barkodYukseklik = "14mm";
$tableStyle = "
            table thead,table thead tr,table thead tr td{
                height:0 !important;
                line-height:0 !important;
                padding:0 !important;
                margin:0 !important;
            }
            table tr .icerik{
                font-size:12px !important;
                max-height: 4mm !important;
                display:inline;
            }
            table tr:nth-child(2) .icerik{
                max-height: " . $barkodYukseklik . " !important;
            }
            table tr:last-child .icerik, table tr:first-child .icerik{
                font-size:10px !important;
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
</head>';

echo '<body onafterprint="self.close()">
    <script>
    $(document).ready(function(){
        JsBarcode("#barkod", "' . $cihaz->servis_no . '", {
            width: 2,
            height: 30,
            displayValue: true,
            fontSize: 18,
            fontOptions: "bold"
        });
        $("#barkod").css({"height":"' . $barkodYukseklik . '"});
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
            <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="5"><div class="icerik">' . SITE_BASLIGI . '</div></td>
            <td class="p-0 pl-1 pr-1 m-0 text-right" colspan="7"><div class="icerik">' . substr($cihaz->tarih, 0, -5) . '</div></td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="12"><div class="icerik"><svg style="width:100%;" id="barkod"></svg></div></td>
        </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="12"><div class="icerik">';
if (strlen($cihaz->musteri_adi) > 40) {
    // echo rtrim(explode(";;", wordwrap($cihaz->musteri_adi, 35, ";;"))[0]) . '...';
    echo rtrim(str_split($cihaz->musteri_adi, 40)[0]) . '...';
} else {
    echo $cihaz->musteri_adi;
}
echo '</div></td>
            </tr>
        </tbody>
    </table>
</body>

</html>';
