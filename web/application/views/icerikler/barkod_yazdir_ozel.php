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
            
            .gizli{
                color: #fff !important;
            }
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
    <table class="table table-borderless m-auto">
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
        </thead>';
        $yaziBoyut = "19px;";
        echo '
        <tbody class="p-1">
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-center gizli" colspan="12" style="color:#fff !important; font-size:5px; opacity:0;">A</td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-center" colspan="12" style="font-size:'.$yaziBoyut.' !important;">YAZI 1</td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-center" colspan="12"> </td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-center" colspan="12" style="font-size:'.$yaziBoyut.' !important;">YAZI 2</td>
        </tr>
        </tbody>
    </table>
</body>

</html>';
