<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");

echo '<title>Barkod ' . ($test ? "0" : $cihaz->id) . '</title>';

$this->load->view("inc/styles");
$this->load->view("inc/scripts");

echo '<script src="' . base_url("dist/js/JsBarcode.all.min.js") . '"></script>';
$style = "width: ".getenv("BARKOD_EN")."mm;
            height: ".getenv("BARKOD_BOY")."mm;
            size: ".getenv("BARKOD_EN")."mm ".getenv("BARKOD_BOY")."mm;
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
                font-size:".getenv("BARKOD_NUMARASI_BOYUTU")."pt !important;
                max-height: 4mm !important;
                display:inline;
            }
            table tr:nth-child(2) .icerik{
                max-height: " . getenv("BARKOD_BOYUTU") . "mm !important;
            }
            table tr:first-child .icerik{
                font-size:".getenv("BARKOD_SIRKET_ADI_BOYUTU")."pt !important;
            }
            table tr:last-child .icerik{
                font-size:".getenv("BARKOD_MUSTERI_ADI_BOYUTU")."pt !important;
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

echo '<body onafterprint="self.close()">
    <script>
    $(document).ready(function(){
        JsBarcode("#barkod", "' . ($test ? "0000000000" : $cihaz->servis_no) . '", {
            width: 2,
            height: 30,
            displayValue: true,
            fontSize: 18,
            fontOptions: "bold"
        });
        $("#barkod").css({"height":"' . getenv("BARKOD_BOYUTU") . 'mm"});
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
