<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");
$bilgileri_goster = FALSE;
if(isset($cihaz)){
    $bilgileri_goster = TRUE;
}

echo '<title>TEKNİK SERVİS FORMU' . ($bilgileri_goster ? " ".$cihaz->id : ""). '</title>';

$this->load->view("inc/styles");
$this->load->view("inc/scripts");
$this->load->view("inc/style_yazdir_tablo");

echo '<style>
        @page {
            margin: 0;
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 1.6cm;
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
    echo '<body onafterprint="kargoYazdirildi()">';
    
echo ' <table class="table table-bordered table-sm w-100">
        <tbody>
            <tr>
                <td style="border:0 !important;" class="p-2" colspan="20"><img height="110" src="' . base_url("dist/img/logo.png") . '" /></td>
            </tr>
            <tr>
                <td colspan="20" class="text-center font-weight-bold">KARGO BİLGİLERİ</td>
            </tr>
            <tr>
                <td colspan="5" class="font-weight-bold">Gönderen:</td>
                <td colspan="15">'.$ayarlar->sirket_unvani.'</td>
            </tr>
            <tr>
                <td colspan="5" class="font-weight-bold">Adres:</td>
                <td colspan="15">'.$ayarlar->adres.'</td>
            </tr>
            <tr>
                <td colspan="5" class="font-weight-bold">Telefon:</td>
                <td colspan="15">'.$ayarlar->sirket_telefonu.'</td>
            </tr>
            <tr>
                <td colspan="20" rowspans="5" class="font-weight-bold">&nbsp;&nbsp;</td>
            </tr>
            
            <tr>
                <td colspan="5" class="font-weight-bold">Alıcı:</td>
                <td colspan="15">'.$cihaz->musteri_adi.'</td>
            </tr>
            <tr>
                <td colspan="5" class="font-weight-bold">Adres:</td>
                <td colspan="15">'.$cihaz->adres.'</td>
            </tr>
            <tr>
                <td colspan="5" class="font-weight-bold">Telefon:</td>
                <td colspan="15">'.$cihaz->telefon_numarasi.'</td>
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
    </table>';
    echo '</body> </html>';