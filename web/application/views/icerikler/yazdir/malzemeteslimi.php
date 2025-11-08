<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <?php
    $this->load->view("inc/meta");
    $bilgileri_goster = FALSE;
    $malzemeTeslimi = null;
    if (isset($id) && strlen($id) > 0) {
        $bilgileri_goster = TRUE;
        $malzemeTeslimi = $this->Malzeme_Teslimi_Model->malzemeteslimi($id);
    }
    ?>
    <title>MALZEME TESLİM FORMU<?= $bilgileri_goster ? " " . $malzemeTeslimi["id"] : ""; ?></title>
    <?php

    $this->load->view("inc/eski/styles");
    $this->load->view("inc/eski/scripts");
    $this->load->view("inc/style_yazdir_tablo");
    $this->load->view("inc/styles_important");
    ?>
    <style>
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
        $(document).ready(function () {
            window.print();
        });
    </script>
</head>

<body onafterprint="self.close();" class="ozel_tema_yok">
    <table class="table table-bordered table-sm w-100">
        <tbody>
            <tr>
                <td style="border:0 !important;" class="align-middle p-2" colspan="14" rowspan="8"><img height="110"
                        src="<?= base_url("dist/img/logo.png"); ?>"></td>
            </tr>
            <tr>
                <th style="border:0 !important;" class="text-end h5 fw-bold pr-3" colspan="6"></th>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="6"></td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3"></td>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3"></td>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3"> </td>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr>
                <td style="border:0 !important; font-weight: bold;" class="text-right pr-2" colspan="6">No:
                    <?= $bilgileri_goster ? $malzemeTeslimi["teslim_no"] : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; ?>
                </td>
            </tr>
            <tr>
                <td colspan="20" class="text-center fw-bold">MALZEME TESLİM FORMU</td>
            </tr>
            <tr>
                <th colspan="4" class="fw-bold">FİRMA
                </th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="14"><?= $bilgileri_goster ? $malzemeTeslimi["firma"] : ""; ?></td>
            </tr>
            <tr>
                <th colspan="4" class="fw-bold">SİPARİŞ TARİHİ
                </th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="14"><?= $bilgileri_goster ? $malzemeTeslimi["siparis_tarihi"] : ""; ?></td>
            </tr>
            <tr>
                <th colspan="4" class="fw-bold">TESLİM TARİHİ
                </th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="14"><?= $bilgileri_goster ? $malzemeTeslimi["teslim_tarihi"] : ""; ?></td>
            </tr>
            <tr>
                <th colspan="4" class="fw-bold">VADE TARİHİ
                </th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="14"><?= $bilgileri_goster ? $malzemeTeslimi["vade_tarihi"] : ""; ?></td>
            </tr>
            <?php
            $colspans = array(
                "1",
                "5",
                "3",
                "3",
                "3",
                "3",
                "3",
            );
            ?>
            <tr>
                <th colspan="<?=$colspans[0];?>" class="text-center fw-bold">NO</th>
                <th colspan="<?=$colspans[1];?>" class="text-center fw-bold">ÜRÜN</th>
                <th colspan="<?=$colspans[2];?>" class="text-center fw-bold">ADET</th>
                <th colspan="<?=$colspans[3];?>" class="text-center fw-bold">BİRİM FİYATI</th>
                <th colspan="<?=$colspans[4];?>" class="text-center fw-bold">TUTAR</th>
                <th colspan="<?=$colspans[5];?>" class="text-center fw-bold">KDV</th>
                <th colspan="<?=$colspans[6];?>" class="text-center fw-bold">TOPLAM</th>
            </tr>
            <?php
            $minHeight = "1cm";
            $malzemeTeslimiIslemleri = $bilgileri_goster ? $malzemeTeslimi["islemler"] : [];
            $topTutar = 0;
            $topKdv = 0;
            $count = 0;
            foreach ($malzemeTeslimiIslemleri as $islem) {
                $count++;
                $toplam = $islem["adet"] * $islem["birim_fiyati"];
                $kdv = ($toplam / 100) * $islem["kdv"];

                $topTutar = $topTutar + $toplam;
                $topKdv = $topKdv + $kdv;
                ?>
                <tr style="min-height: <?=$minHeight;?>;">
                    <th colspan="<?=$colspans[0];?>" class="text-center"><?= $count; ?></th>
                    <td colspan="<?=$colspans[1];?>"><?= $islem["isim"]; ?></td>
                    <td colspan="<?=$colspans[2];?>" class="text-center"><?= $islem["adet"]; ?></td>
                    <td colspan="<?=$colspans[3];?>" class="text-center"><?= $islem["birim_fiyati"]; ?> TL</td>
                    <td colspan="<?=$colspans[4];?>" class="text-center"><?= $toplam; ?> TL</td>
                    <td colspan="<?=$colspans[5];?>" class="text-center"><?= $kdv; ?> TL</td>
                    <td colspan="<?=$colspans[6];?>" class="text-center"><?= $toplam + $kdv; ?> TL</td>
                </tr>
                <?php
            }

            $toplamIslemSayisi = 10;
            $gosterilecenIslemSayisi = $toplamIslemSayisi - count($malzemeTeslimiIslemleri);
            for ($i = 0; $i < $gosterilecenIslemSayisi; $i++) {
                $count++;
                ?>
                <tr style="height: <?=$minHeight;?>;">
                    <th colspan="<?=$colspans[0];?>" class="text-center"></th>
                    <td colspan="<?=$colspans[1];?>"></td>
                    <td colspan="<?=$colspans[2];?>" class="text-center"></td>
                    <td colspan="<?=$colspans[3];?>" class="text-center"></td>
                    <td colspan="<?=$colspans[4];?>" class="text-center"></td>
                    <td colspan="<?=$colspans[5];?>" class="text-center"></td>
                    <td colspan="<?=$colspans[6];?>" class="text-center"></td>
                </tr>
                <?php
            }
            $genelToplam = $topTutar + $topKdv;
            $toplamIslem = count($malzemeTeslimiIslemleri);
            ?>
            <tr>
                <th colspan="13">TOPLAM TUTAR</th>
                <td colspan="7" class="text-center">
                    <?= $bilgileri_goster ? ($toplamIslem > 0 ? $topTutar . " TL" : "") : ""; ?></td>
            </tr>
            <tr>
                <th colspan="13">KDV</th>
                <td colspan="7" class="text-center">
                    <?= $bilgileri_goster ? ($toplamIslem > 0 ? $topKdv . " TL" : "") : ""; ?></td>
            </tr>
            <tr>
                <th colspan="13">GENEL TOPLAM</th>
                <td colspan="7" class="text-center">
                    <?= $bilgileri_goster ? ($toplamIslem > 0 ? $genelToplam . " TL" : "") : ""; ?></td>
            </tr>
            <tr>
                <th colspan="10" class="text-center fw-bold">TESLİM EDEN</th>
                <th colspan="10" class="text-center fw-bold">TESLİM ALAN</th>
            </tr>
            <tr>
                <td colspan="4" class="text-center">ADI SOYADI</td>
                <td colspan="6" class="text-center"><?= $bilgileri_goster ? $malzemeTeslimi["teslim_eden"] : ""; ?></td>
                <td colspan="4" class="text-center">ADI SOYADI</td>
                <td colspan="6" class="text-center"><?= $bilgileri_goster ? $malzemeTeslimi["teslim_alan"] : ""; ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">İMZASI</td>
                <td colspan="6" class="text-center"></td>
                <td colspan="4" class="text-center">İMZASI</td>
                <td colspan="6" class="text-center"></td>
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
</body>

</html>