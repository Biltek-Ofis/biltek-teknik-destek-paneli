<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");

echo '<title>KARGO BİLGİLERİ ' .$cihaz->id. '</title>';

$this->load->view("inc/styles");
$this->load->view("inc/scripts");
$this->load->view("inc/style_yazdir");
$this->load->view("inc/style_yazdir_tablo");
$tdPadding = "10px";
$fontBoyutu = "25pt";
echo '<style>
        body {
            font-size: '.$fontBoyutu.' !important;
        }
        table tr td, table tr th{
            padding: '.$tdPadding.' !important;
        }

        @media print {
            @page {
                margin: 0;
                font-size: '.$fontBoyutu.' !important;
            }

            body {
                margin: 1.6cm;
                font-size: '.$fontBoyutu.' !important;
            }
            table tr td, table tr th{
                padding: '.$tdPadding.' !important;
            }
            .list-group .list-group-item {
                height: 20px !important;
                line-height: 20px !important;
                border: 0 !important;
            }
        }
      </style>
       <style>
        .list-group .list-group-item {
            height: 20px !important;
            line-height: 20px !important;
            border: 0 !important;
        }
    </style>
            <script>
    function kargoYazdirildi(){
       self.close();
    }
    $(document).ready(function() {
        window.print();
    });
    </script>
</head>';
    echo '<body onafterprint="kargoYazdirildi()" class="ozel_tema_yok">';
    
echo '
<div class="">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-sm">';
            
            $bolumSpan = 3;
            $icerikSpan = 17;
            echo '
                <tbody>
                    <tr>
                        <td style="border:0 !important;" class="p-2" colspan="20"><img height="130" src="' . base_url("dist/img/logo.png") . '" /></td>
                    </tr>
                    <tr>
                        <td colspan="20" class="text-center font-weight-bold">KARGO BİLGİLERİ</td>
                    </tr>
                    <tr>
                        <td colspan="'.$bolumSpan.'" class="font-weight-bold">Gönderen:</td>
                        <td colspan="'.$icerikSpan.'">'.$ayarlar->sirket_unvani.'</td>
                    </tr>
                    <tr>
                        <td colspan="'.$bolumSpan.'" class="font-weight-bold">Adres:</td>
                        <td colspan="'.$icerikSpan.'">'.$ayarlar->adres.'</td>
                    </tr>
                    <tr>
                        <td colspan="'.$bolumSpan.'" class="font-weight-bold">Telefon:</td>
                        <td colspan="'.$icerikSpan.'">'.$ayarlar->sirket_telefonu.'</td>
                    </tr>
                    <tr>
                        <td colspan="20" rowspans="5" class="font-weight-bold">&nbsp;&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td colspan="'.$bolumSpan.'" class="font-weight-bold">Alıcı:</td>
                        <td colspan="'.$icerikSpan.'">'.$cihaz->musteri_adi.'</td>
                    </tr>
                    <tr>
                        <td colspan="'.$bolumSpan.'" class="font-weight-bold">Adres:</td>
                        <td colspan="'.$icerikSpan.'">'.$cihaz->adres.'</td>
                    </tr>
                    <tr>
                        <td colspan="'.$bolumSpan.'" class="font-weight-bold">Telefon:</td>
                        <td colspan="'.$icerikSpan.'">'.$cihaz->telefon_numarasi.'</td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 5%;"></td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>';
    echo '</body> </html>';