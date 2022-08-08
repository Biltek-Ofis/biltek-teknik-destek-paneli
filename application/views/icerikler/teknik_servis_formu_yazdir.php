<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("inc/meta"); ?>

    <title>TEKNİK SERVİS FORMU <?= $cihaz->id; ?></title>

    <?php $this->load->view("inc/styles"); ?>
    <?php $this->load->view("inc/scripts"); ?>
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

            .table thead tr td {
                border: 0 !important;
                padding: 0 !important;
                height: 0 !important;
                -webkit-print-color-adjust: exact;
            }

            .table tbody tr td {
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                padding: 2px;
                -webkit-print-color-adjust: exact;
            }

            .list-group .list-group-item {
                height: 20px !important;
                line-height: 20px !important;
                border: 0 !important;
            }
        }
    </style>
    <style>
        .table thead tr td {
            border: 0 !important;
            padding: 0 !important;
            height: 0 !important;
        }

        .list-group .list-group-item {
            height: 20px !important;
            line-height: 20px !important;
            border: 0 !important;
        }

        .table tbody tr td {
            border-width: 1px !important;
            border-style: solid !important;
            border-color: black !important;
            padding: 2px;
        }
    </style>
</head>

<body onafterprint="self.close()">
    <table class="table table-bordered table-sm w-100">
        <tbody>
            <tr>
                <td style="border:0 !important;" class="align-middle p-2" colspan="14" rowspan="8"><img height="110" src="<?= base_url("dist/img/logo.png"); ?>" /></td>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3">Giriş Tarihi: </td>
                <td style="border:0 !important;" colspan="3"><?= $cihaz->tarih; ?></td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3">Bildirim Tarihi: </td>
                <td style="border:0 !important;" colspan="3"><?= $cihaz->bildirim_tarihi; ?></td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3">Çıkış Tarihi: </td>
                <td style="border:0 !important;" colspan="3"><?= $cihaz->cikis_tarihi; ?></td>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr>
                <td colspan="20" class="text-center font-weight-bold">TEKNİK SERVİS FORMU</td>
            </tr>
            <tr>
                <td colspan="20" class="text-center font-weight-bold">GENEL BİLGİLER</td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">MÜŞTERİ ADI SOYADI</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->musteri_adi; ?></td>
            </tr>
            <tr>
                <td colspan="8">ADRESİ</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->adres; ?></td>
            </tr>
            <tr>
                <td colspan="8">GSM & E-Mail</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->gsm_mail; ?></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">CİHAZIN MARKASI</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->cihaz; ?></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">MODELİ</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->cihaz_modeli; ?></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">Cihazın Seri Numarası</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->seri_no; ?></td>
            </tr>
            <tr style="height: 80px !important;">
                <td colspan="8">BELİRTİLEN ARIZA AÇIKLAMASI</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->ariza_aciklamasi; ?></td>
            </tr>

            <tr>
                <td colspan="20" class="text-center font-weight-bold">YAPILACAK İŞLEM</td>
            </tr>
            <tr>
                <td colspan="8"></td>
                <td colspan="2" class="text-center"></td>
                <td colspan="4" class="text-center font-weight-bold">Aksesuar</tH>
                <td colspan="3" class="text-center"><?= $this->Islemler_Model->hasarDurumu(2); ?></td>
                <td colspan="3" class="text-center"><?= $this->Islemler_Model->hasarDurumu(3); ?></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold"><?= $this->Islemler_Model->servisTuru(1); ?></td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->servis_turu == 1) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="4" class="text-center">TAŞIMA ÇANTASI</td>
                <td colspan="3" class="text-center align-middle"><?php if ($cihaz->tasima_cantasi == 1) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="3" class="text-center align-middle"><?php if ($cihaz->tasima_cantasi == 2) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold"><?= $this->Islemler_Model->servisTuru(2); ?></td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->servis_turu == 2) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="4" class="text-center">SARJ ADAPTÖRÜ</td>
                <td colspan="3" class="text-center align-middle"><?php if ($cihaz->sarj_adaptoru == 1) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="3" class="text-center align-middle"><?php if ($cihaz->sarj_adaptoru == 2) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold"><?= $this->Islemler_Model->servisTuru(3); ?></td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->servis_turu == 3) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="4" class="text-center">PİL</td>
                <td colspan="3" class="text-center align-middle"><?php if ($cihaz->pil == 1) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="3" class="text-center align-middle"><?php if ($cihaz->pil == 2) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold"><?= $this->Islemler_Model->servisTuru(4); ?></td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->servis_turu == 4) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="4" class="text-center">DİĞER</td>
                <td colspan="6" class="text-center"><?= $cihaz->diger_aksesuar; ?></td>
            </tr>
            <tr style="height: 80px !important;">
                <td colspan="8">YAPILAN İŞLEM AÇIKLAMASI</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10"><?= $cihaz->yapilan_islem_aciklamasi; ?></td>
            </tr>
            <tr>
                <td colspan="8">YEDEKLİ İŞLEM</td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->yedek_durumu == 1) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="8">YEDEKSİZ İŞLEM</td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->yedek_durumu == 2) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="20" class="text-center font-weight-bold">MAKİNA ÜZERİNDE GELEN AKSESUAR VE MAKİNE DURUMU</td>
            </tr>
            <?php
            $hasarli_durumlar_rowspan = 5;
            if ($cihaz->i_ad_1 != "" || $cihaz->i_ad_2 != "" || $cihaz->i_ad_3 != "" || $cihaz->i_ad_4 != "" || $cihaz->i_ad_5 != "") {
                $hasarli_durumlar_rowspan = 0;
                if ($cihaz->i_ad_1 != "") {
                    $hasarli_durumlar_rowspan++;
                }
                if ($cihaz->i_ad_2 != "") {
                    $hasarli_durumlar_rowspan++;
                }
                if ($cihaz->i_ad_3 != "") {
                    $hasarli_durumlar_rowspan++;
                }
                if ($cihaz->i_ad_4 != "") {
                    $hasarli_durumlar_rowspan++;
                }
                if ($cihaz->i_ad_5 != "") {
                    $hasarli_durumlar_rowspan++;
                }
            }
            ?>
            <tr>
                <td colspan="10" rowspan="<?= $hasarli_durumlar_rowspan + 2; ?>" class="text-center font-weight-bold">HASARLI DURUMLAR</td>
                <td colspan="4" class="text-center font-weight-bold">MALZEME/İŞÇİLİK</td>
                <td colspan="1" class="text-center font-weight-bold">MİKTAR</td>
                <td colspan="1" class="text-center font-weight-bold">BİRİM FİYATI</td>
                <td colspan="2" class="text-center font-weight-bold">TUTAR</td>
                <td colspan="2" class="text-center font-weight-bold">KDV</td>
            </tr>
            <?php
            $toplam = "";
            $kdv = "";
            $genel_toplam = "";
            if ($cihaz->i_ad_1 != "" || $cihaz->i_ad_2 != "" || $cihaz->i_ad_3 != "" || $cihaz->i_ad_4 != "" || $cihaz->i_ad_5 != "") {
                $toplam = 0;
                $kdv = 0;
                if ($cihaz->i_ad_1 != "") {
                    $toplam_islem_fiyati_1 =  $cihaz->i_miktar_1 * $cihaz->i_birim_fiyat_1;
                    $kdv_1 = ceil(($toplam_islem_fiyati_1 / 100) * $cihaz->i_kdv_1);
                    echo '<tr>
                <td colspan="4">' . $cihaz->i_ad_1  . '</td>
                <td colspan="1" class="text-center">' . $cihaz->i_miktar_1 . '</td>
                <td colspan="1" class="text-center">' .  $cihaz->i_birim_fiyat_1 . ' TL</td>
                <td colspan="2" class="text-center">' . $toplam_islem_fiyati_1 . ' TL</td>
                <td colspan="2" class="text-center">' . ($kdv_1 > 0 ? $kdv_1 . ' TL (' . $cihaz->i_kdv_1 . '%)': "").'</td>
            </tr>';
                    $toplam = $toplam + $toplam_islem_fiyati_1;
                    $kdv = $kdv + $kdv_1;
                }
                if ($cihaz->i_ad_2 != "") {
                    $toplam_islem_fiyati_2 =  $cihaz->i_miktar_2 * $cihaz->i_birim_fiyat_2;
                    $kdv_2 = ceil(($toplam_islem_fiyati_2 / 100) * $cihaz->i_kdv_2);
                    echo '<tr>
                <td colspan="4">' . $cihaz->i_ad_2  . '</td>
                <td colspan="1" class="text-center">' . $cihaz->i_miktar_2 . '</td>
                <td colspan="1" class="text-center">' .  $cihaz->i_birim_fiyat_2 . ' TL</td>
                <td colspan="2" class="text-center">' . $toplam_islem_fiyati_2 . ' TL</td>
                <td colspan="2" class="text-center">' . ($kdv_2 > 0 ? $kdv_2 . ' TL (' . $cihaz->i_kdv_2 . '%)': "").'</td>
            </tr>';
                    $toplam = $toplam + $toplam_islem_fiyati_2;
                    $kdv = $kdv + $kdv_2;
                }
                if ($cihaz->i_ad_3 != "") {
                    $toplam_islem_fiyati_3 =  $cihaz->i_miktar_3 * $cihaz->i_birim_fiyat_3;
                    $kdv_3 = ceil(($toplam_islem_fiyati_3 / 100) * $cihaz->i_kdv_3);
                    echo '<tr>
                <td colspan="4">' . $cihaz->i_ad_3  . '</td>
                <td colspan="1" class="text-center">' . $cihaz->i_miktar_3 . '</td>
                <td colspan="1" class="text-center">' .  $cihaz->i_birim_fiyat_3 . ' TL</td>
                <td colspan="2" class="text-center">' . $toplam_islem_fiyati_3 . ' TL</td>
                <td colspan="2" class="text-center">' . ($kdv_3 > 0 ? $kdv_3 . ' TL (' . $cihaz->i_kdv_3 . '%)': "").'</td>
            </tr>';
                    $toplam = $toplam + $toplam_islem_fiyati_3;
                    $kdv = $kdv + $kdv_3;
                }
                if ($cihaz->i_ad_4 != "") {
                    $toplam_islem_fiyati_4 = $cihaz->i_miktar_4 * $cihaz->i_birim_fiyat_4;
                    $kdv_4 = ceil(($toplam_islem_fiyati_4 / 100) * $cihaz->i_kdv_4);
                    echo '<tr>
                <td colspan="4">' . $cihaz->i_ad_4  . '</td>
                <td colspan="1" class="text-center">' . $cihaz->i_miktar_4 . '</td>
                <td colspan="1" class="text-center">' .  $cihaz->i_birim_fiyat_4 . ' TL</td>
                <td colspan="2" class="text-center">' . $toplam_islem_fiyati_4 . ' TL</td>
                <td colspan="2" class="text-center">' . ($kdv_4 > 0 ? $kdv_4 . ' TL (' . $cihaz->i_kdv_4 . '%)': "").'</td>
            </tr>';
                    $toplam = $toplam + $toplam_islem_fiyati_4;
                    $kdv = $kdv + $kdv_4;
                }
                if ($cihaz->i_ad_5 != "") {
                    $toplam_islem_fiyati_5 =  $cihaz->i_miktar_5 * $cihaz->i_birim_fiyat_5;
                    $kdv_5 = ceil(($toplam_islem_fiyati_5 / 100) * $cihaz->i_kdv_5);
                    echo '<tr>
                <td colspan="4">' . $cihaz->i_ad_5  . '</td>
                <td colspan="1" class="text-center">' . $cihaz->i_miktar_5 . '</td>
                <td colspan="1" class="text-center">' .  $cihaz->i_birim_fiyat_5 . ' TL</td>
                <td colspan="2" class="text-center">' . $toplam_islem_fiyati_5 . ' TL</td>
                <td colspan="2" class="text-center">' . ($kdv_5 > 0 ? $kdv_5 . ' TL (' . $cihaz->i_kdv_5 . '%)': "").'</td>
            </tr>';
                    $toplam = $toplam + $toplam_islem_fiyati_5;
                    $kdv = $kdv + $kdv_5;
                }
                $genel_toplam = $toplam + $kdv;
            } else {
                for ($i = 0; $i < 5; $i++) {
                    echo '<tr style="height:20px;">
                    <td colspan="4"></td>
                    <td colspan="1" class="text-center"></td>
                    <td colspan="1" class="text-center"></td>
                    <td colspan="2" class="text-center"></td>
                    <td colspan="2" class="text-center"></td>
                </tr>';
                }
            }
            ?>
            <tr>
                <td colspan="8">TOPLAM</td>
                <td colspan="2" class="text-center"><?= $toplam; ?> TL</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">ÇİZİK</td>
                <td colspan="2" class="text-center">KIRIK</td>
                <td colspan="2" class="text-center">ÇATLAK</td>
                <td colspan="4" class="text-center">DİĞER</td>
                <td colspan="8">KDV</td>
                <td colspan="2" class="text-center"><?= $kdv > 0 ? $kdv . " TL" : ""; ?></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->cihazdaki_hasar == 1) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></i></td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->cihazdaki_hasar == 2) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="2" class="text-center align-middle"><?php if ($cihaz->cihazdaki_hasar == 3) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="4" class="text-center align-middle"><?php if ($cihaz->cihazdaki_hasar == 4) {
                                                                        echo '<i class="fas fa-check"></i>';
                                                                    } ?></td>
                <td colspan="8">GENEL TOPLAM</td>
                <td colspan="2" class="text-center"><?= $genel_toplam; ?> TL</td>
            </tr>
            <tr>
                <td colspan="7" class="text-center font-weight-bold">TESLİM ALAN</td>
                <td colspan="7" class="text-center font-weight-bold">TESLİM EDEN</td>
                <td colspan="6" class="text-center font-weight-bold">TEKNİK SORUMLU</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">ADI</td>
                <td colspan="4" class="text-center"></td>
                <td colspan="3" class="text-center">ADI</td>
                <td colspan="4" class="text-center"></td>
                <td colspan="3" class="text-center">ADI</td>
                <td colspan="3" class="text-center"></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">SOYADI</td>
                <td colspan="4" class="text-center"></td>
                <td colspan="3" class="text-center">SOYADI</td>
                <td colspan="4" class="text-center"></td>
                <td colspan="3" class="text-center">SOYADI</td>
                <td colspan="3" class="text-center"></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">İMZASI</td>
                <td colspan="4" class="text-center"></td>
                <td colspan="3" class="text-center">İMZASI</td>
                <td colspan="4" class="text-center"></td>
                <td colspan="3" class="text-center">İMZASI</td>
                <td colspan="3" class="text-center"></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">NOT</td>
                <td colspan="17" class="text-center">
                    Yukarıdaki Markası, Modeli, Seri Numarası ve Genel Durumu belirtilen cihazın bakım - onarımı yerinde / serviste yapılarak <span class="font-weight-bold">ÇALIŞIR / İADE</span> şeklinde teslim edilmiştir. Daha sonra oluşacak arızalardan <span class="font-weight-bold">ŞİRKETİMİZ</span> sorumlu değildir. <span class="font-weight-bold h5">Servis hizmet süresi en fazla 20 (yirmi) iş günüdür. Onarım tamamlandığı bilgisinin müşteriye beyanından sonra 90 (doksan) gün içerisinde teslim alınmayan cihazlardan şirketimiz sorumlu değildir.</span> Yukarıda Marka / Modeli verilen cihazlardaki programların her türlü sorumluluğu müşteriye ait olup sahte yazılımlardan <span class="font-weight-bold">ŞİRKETİMİZ</span> sorumlu değildir. Lisansı olmayan hiçbir yazılım firmamız tarafından sisteme yüklenmez. Servis formu ibrazı ile sadece cihaz kaydı yaptıran kişiye teslim edilebilir. Onun dışında Kimlik Fotokobisi ve cihazı kaydettiren kişinin onay yazısı ile ilgili kişiye teslim edilebilir. Onarım için servise getirilen cihazların arıza tespiti yapıldıktan sonra onarıma onay verilmemişse {arıza_tespit_ucreti} tutarında arıza tespit ücreti alınır.<br>
                    BİLDİRİLEN DOSYALAR DIŞINDAKİ, HDD BOZUKLUKLARINDAN DOLAYI VE VİRÜSLERDEN DOLAYI BOZULMUŞ VERİ KAYIPLARINDAN ŞİRKETİMİZ SORUMLU DEĞİLDİR.<br>
                    MEYDANA GELEBİLECEK VERİ KAYIPLARINDAN ŞİRKETİMİZ SORUMLU DEĞİLDİR. YEDEKLEME İŞLEMİ ÜCRETE TABİDİR.
                </td>
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