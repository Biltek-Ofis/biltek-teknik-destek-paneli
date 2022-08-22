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
$barkodYukseklik = "10mm";
$tableStyle = "
            table tr .icerik{
                font-size:12px !important;
                max-height: 4mm !important;
            }
            table tr:first-child .icerik{
                font-size:20px !important;
                max-height: 7mm !important;
            }
            table tr:nth-child(3) .icerik{
                max-height: " . $barkodYukseklik . " !important;
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
            height: 20,
            displayValue: false,
        });
        $("#barkod").css({"height":"' . $barkodYukseklik . '"});
    });
    </script>
    <table class="table table-borderless">
        <thead>
            <tr></tr>
            <tr></tr>
        </thead>
        <tbody class="p-1">
            <tr>
                <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="2"><div class="icerik">' . $cihaz->servis_no . '</div></td>
            </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0" colspan="2"><div class="icerik">';
if (strlen($cihaz->musteri_adi) > 30) {
    echo str_split($cihaz->musteri_adi, 30)[0] . '...';
} else {
    echo $cihaz->musteri_adi;
}
echo '</div></td>
            </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0 text-left" colspan="2"><div class="icerik"><svg id="barkod"></svg></div></td>
            </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0 text-right" colspan="2"><div class="icerik">' . $cihaz->tarih . '</div></td>
            </tr>
        </tbody>
    </table>
</body>

</html>';
