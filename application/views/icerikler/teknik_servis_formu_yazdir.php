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
        }
    </style>
    <style>
        .table thead tr td {
            border: 0 !important;
            padding: 0 !important;
            height: 0 !important;
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
                <td colspan="20" class="text-center font-weight-bold">TEKNİK SERVİS FORMU</td>
            </tr>
            <tr>
                <td colspan="20" class="text-center font-weight-bold">GENEL BİLGİLER</td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">MÜŞTERİ ADI SOYADI</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Müşteri Adı Test</td>
            </tr>
            <tr>
                <td colspan="8">ADRESİ</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Adres Test</td>
            </tr>
            <tr>
                <td colspan="8">GSM & E-Mail</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">GSM & E-Mail Test</td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">CİHAZIN MARKA / MODELİ</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Marka Model Test</td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">Cihazın Seri Numarası</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Seri No Test</td>
            </tr>
            <tr>
                <td colspan="8">BELİRTİLEN ARIZA AÇIKLAMASI</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Açıklama Test</td>
            </tr>

            <tr>
                <td colspan="20" class="text-center font-weight-bold">YAPILACAK İŞLEM</td>
            </tr>
            <tr>
                <td colspan="8"></td>
                <td colspan="2" class="text-center"></td>
                <td colspan="4" class="text-center font-weight-bold">AKSESUAR</tH>
                <td colspan="3" class="text-center">HASARLI</td>
                <td colspan="3" class="text-center">HASARSIZ</td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">GARANTİ KAPSAMINDA BAKIM/ONARIM</td>
                <td colspan="2" class="text-center align-middle"><i class="fas fa-check"></i></td>
                <td colspan="4" class="text-center">TAŞIMA ÇANTASI</td>
                <td colspan="3" class="text-center align-middle"></td>
                <td colspan="3" class="text-center align-middle"><i class="fas fa-check"></i></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">ANLAŞMALI KAPSAMINDA BAKIM/ONARIM</td>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="4" class="text-center">SARJ ADAPTÖRÜ</td>
                <td colspan="3" class="text-center align-middle"></td>
                <td colspan="3" class="text-center align-middle"><i class="fas fa-check"></i></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">ÜCRETLİ BAKIM/ONARIM</td>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="4" class="text-center">PİL</td>
                <td colspan="3" class="text-center align-middle"></td>
                <td colspan="3" class="text-center align-middle"><i class="fas fa-check"></i></td>
            </tr>
            <tr>
                <td colspan="8" class="font-weight-bold">ÜCRETLİ ARIZA TESPİTİ</td>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="4" class="text-center">DİĞER</td>
                <td colspan="6" class="text-center"></td>
            </tr>
            <tr>
                <td colspan="8">YAPILAN İŞLEM AÇIKLAMASI</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Açıklama Testt</td>
            </tr>
            <tr>
                <td colspan="8">YEDEKLİ İŞLEM</td>
                <td colspan="2" class="text-center align-middle"><i class="fas fa-check"></i></td>
                <td colspan="10">BİLDİRİLEN DOSYALAR DIŞINDAKİ, HDD BOZUKLUKLARINDAN DOLAYI VE VİRÜSLERDEN DOLAYI BOZULMUŞ VERİ KAYIPLARINDAN ŞİRKETİMİZ SORUMLU DEĞİLDİR.</td>
            </tr>
            <tr>
                <td colspan="8">YEDEKSİZ İŞLEM</td>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="10">BU ŞIKKIN İŞARETLENMESİ DURUMUNDA MEYDANA GELEBİLECEK VERİ KAYIPLARINDAN ŞİRKETİMİZ SORUMLU DEĞİLDİR. YEDEKLEME ÜCRETE TABİDİR.</td>
            </tr>
            <tr>
                <td colspan="20" class="text-center font-weight-bold">MAKİNA ÜZERİNDE GELEN AKSESUAR VE MAKİNE DURUMU</td>
            </tr>
            <tr>
                <td colspan="10" rowspan="7" class="text-center font-weight-bold">HASARLI DURUMLARDA İŞARETLENECEK</td>
                <td colspan="5" class="text-center font-weight-bold">MALZEME/İŞÇİLİK</td>
                <td colspan="1" class="text-center font-weight-bold">MİKTAR</td>
                <td colspan="2" class="text-center font-weight-bold">FİYAT</td>
                <td colspan="2" class="text-center font-weight-bold">TUTAR</td>
            </tr>
            <tr>
                <td colspan="5">Test Malzeme 1</td>
                <td colspan="1" class="text-center">2</td>
                <td colspan="2" class="text-center">300 TL</td>
                <td colspan="2" class="text-center">600 TL</td>
            </tr>
            <tr>
                <td colspan="5">Test Malzeme 2</td>
                <td colspan="1" class="text-center">2</td>
                <td colspan="2" class="text-center">400 TL</td>
                <td colspan="2" class="text-center">800 TL</td>
            </tr>
            <tr>
                <td colspan="5">Test Malzeme 3</td>
                <td colspan="1" class="text-center">3</td>
                <td colspan="2" class="text-center">300 TL</td>
                <td colspan="2" class="text-center">900 TL</td>
            </tr>
            <tr>
                <td colspan="5">Test Malzeme 4</td>
                <td colspan="1" class="text-center">5</td>
                <td colspan="2" class="text-center">300 TL</td>
                <td colspan="2" class="text-center">1500 TL</td>
            </tr>
            <tr>
                <td colspan="5">Test Malzeme 5</td>
                <td colspan="1" class="text-center">3</td>
                <td colspan="2" class="text-center">10000 TL</td>
                <td colspan="2" class="text-center">30000 TL</td>
            </tr>
            <tr>
                <td colspan="8">TOPLAM</td>
                <td colspan="2" class="text-center">33800 TL</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">ÇİZİK</td>
                <td colspan="2" class="text-center">KIRIK</td>
                <td colspan="2" class="text-center">ÇATLAK</td>
                <td colspan="4" class="text-center">DİĞER</td>
                <td colspan="8">KDV (%18)</td>
                <td colspan="2" class="text-center">6084 TL</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center align-middle"><i class="fas fa-check"></i></td>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="4" class="text-center align-middle"></td>
                <td colspan="8">GENEL TOPLAM</td>
                <td colspan="2" class="text-center">39884 TL</td>
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
                <td colspan="17" class="text-center">Yukarıdaki Markası, Modeli, Seri Numarası ve Genel Durumu belirtilen cihazın bakım - onarımı yerinde / serviste yapılarak <span class="font-weight-bold">ÇALIŞIR / İADE</span> şeklinde teslim edilmiştir. Daha sonra oluşacak arızalardan <span class="font-weight-bold">ŞİRKETİMİZ</span> sorumlu değildir. Servis hizmet süresi en fazla <span class="font-weight-bold">20 (yirmi)</span> iş günüdür. Onarım tamamlandığı bilgisinin müşteriye beyanından sonra <span class="font-weight-bold">90 (doksan)</span> gün içerisinde teslim alınmayan cihazlardan şirketimiz sorumlu değildir. Yukarıda Marka / Modeli verilen cihazlardaki programların her türlü sorumluluğu müşteriye ait olup sahte yazılımlardan <span class="font-weight-bold">ŞİRKETİMİZ</span> sorumlu değildir. Lisansı olmayan hiçbir yazılım firmamız tarafından sisteme yüklenmez. Servis formu ibrazı ile sadece cihaz kaydı yaptıran kişiye teslim edilebilir. Onun dışında Kimlik Fotokobisi ve cihazı kaydettiren kişinin onay yazısı ile ilgili kişiye teslim edilebilir. Onarım için servise getirilen cihazların arıza tespiti yapıldıktan sonra onarıma onay verilmemişse {arıza_tespit_ucreti} tutarında arıza tespit ücreti alınır.</td>
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