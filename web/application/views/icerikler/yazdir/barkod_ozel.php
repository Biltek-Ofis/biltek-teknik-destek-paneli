<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");

$test = FALSE;

function checkAlign($str)
{
    if ($str == "left" || $str == "start" || $str == "right" || $str == "end" || $str == "center") {
        return $str;
    }
    return "center";
}

$satir1 = isset($_GET["satir1"]) ? $_GET["satir1"] : "";
$satir2 = isset($_GET["satir2"]) ? $_GET["satir2"] : "";
$satir3 = isset($_GET["satir3"]) ? $_GET["satir3"] : "";

$satir1Align = isset($_GET["satir1Align"]) ? $_GET["satir1Align"] : "center";
$satir1Align = checkAlign($satir1Align);
$satir2Align = isset($_GET["satir2Align"]) ? $_GET["satir2Align"] : "center";
$satir2Align = checkAlign($satir2Align);
$satir3Align = isset($_GET["satir3Align"]) ? $_GET["satir3Align"] : "center";
$satir3Align = checkAlign($satir3Align);

$satir1YaziBoyut = isset($_GET["satir1YaziBoyut"]) ? $_GET["satir1YaziBoyut"] : "17px";
$satir2YaziBoyut = isset($_GET["satir2YaziBoyut"]) ? $_GET["satir2YaziBoyut"] : "17px";
$satir3YaziBoyut = isset($_GET["satir3YaziBoyut"]) ? $_GET["satir3YaziBoyut"] : "17ox";


echo '<title>Barkod</title>';

$this->load->view("inc/eski/styles");
$this->load->view("inc/eski/scripts");
$this->load->view("inc/styles_important");
$ayarlar = $this->Ayarlar_Model->getir();
echo '<script src="' . base_url("dist/js/JsBarcode.all.min.js") . '"></script>';
$style = "width: " . $ayarlar->barkod_en . "mm;
            height: " . $ayarlar->barkod_boy . "mm;
            size: " . $ayarlar->barkod_en . "mm " . $ayarlar->barkod_boy . "mm;
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
                font-size:" . $ayarlar->barkod_numarasi_boyutu . "pt !important;
                max-height: 4mm !important;
                display:inline;
            }
            table tr:nth-child(2) .icerik{
                max-height: " . $ayarlar->barkod_boyutu . "mm !important;
            }
            table tr:first-child .icerik{
                font-size:" . $ayarlar->barkod_sirket_adi_boyutu . "pt !important;
            }
            table tr:last-child .icerik{
                font-size:" . $ayarlar->barkod_musteri_adi_boyutu . "pt !important;
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
echo '
        <tbody class="p-1">
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-center gizli" colspan="12" style="color:#fff !important; font-size:5px; opacity:0;"></td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-' . $satir1Align . '" colspan="12" style="font-size:' . $satir1YaziBoyut . ' !important;">' . $satir1 . '</td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-' . $satir2Align . '" colspan="12" style="font-size:' . $satir2YaziBoyut . ' !important;">' . $satir2 . '</td>
        </tr>
        <tr>
            <td class="p-0 pl-1 pr-1 m-0 text-' . $satir3Align . '" colspan="12" style="font-size:' . $satir3YaziBoyut . ' !important;">' . $satir3 . '</td>
        </tr>
        </tbody>
    </table>
</body>

</html>';
