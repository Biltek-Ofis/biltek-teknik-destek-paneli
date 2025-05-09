<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("inc/meta"); ?>

    <title>TEKNİK SERVİS FORMU</title>

    <?php $this->load->view("inc/styles"); ?>
    <?php $this->load->view("inc/scripts"); ?>
    <?php $this->load->view("inc/styles_important");?>
</head>

<body>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th colspan="20" class="text-center">TEKNİK SERVİS FORMU</th>
            </tr>
            <tr>
                <th colspan="20" class="text-center">GENEL BİLGİLER</th>
            </tr>
            <tr>
                <th colspan="8">MÜŞTERİ ADI SOYADI</th>
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
                <th colspan="8">TEL-FAKS</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">TEL-FAKS Test</td>
            </tr>
            <tr>
                <th colspan="8">CİHAZIN MARKA / MODELİ</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Marka Model Test</td>
            </tr>
            <tr>
                <th colspan="8">Cihazın Seri Numarası</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Seri No Test</td>
            </tr>
            <tr>
                <td colspan="8">BELİRTİLEN ARIZA AÇIKLAMASI</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">Açıklama Test</td>
            </tr>
            
            <tr>
                <th colspan="20" class="text-center">YAPILACAK İŞLEM</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <td colspan="2" class="text-center"></td>
                <tH colspan="4" class="text-center">AKSESUAR</tH>
                <td colspan="3" class="text-center">HASARLI</td>
                <td colspan="3" class="text-center">HASARSIZ</td>
            </tr>
            <tr>
                <th colspan="8">GARANTİ KAPSAMINDA BAKIM/ONARIM</th>
                <td colspan="2" class="text-center align-middle"><i class="fas fa-check"></i></td>
                <td colspan="4" class="text-center">TAŞIMA ÇANTASI</td>
                <td colspan="3" class="text-center align-middle"></td>
                <td colspan="3" class="text-center align-middle"><i class="fas fa-check"></i></td>
            </tr>
            <tr>
                <th colspan="8">ANLAŞMALI KAPSAMINDA BAKIM/ONARIM</th>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="4" class="text-center">SARJ ADAPTÖRÜ</td>
                <td colspan="3" class="text-center align-middle"></td>
                <td colspan="3" class="text-center align-middle"><i class="fas fa-check"></i></td>
            </tr>
            <tr>
                <th colspan="8">ÜCRETLİ BAKIM/ONARIM</th>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="4" class="text-center">PİL</td>
                <td colspan="3" class="text-center align-middle"></td>
                <td colspan="3" class="text-center align-middle"><i class="fas fa-check"></i></td>
            </tr>
            <tr>
                <th colspan="8">ÜCRETLİ ARIZA TESPİTİ</th>
                <td colspan="2" class="text-center align-middle"></td>
                <td colspan="4" class="text-center">DİĞER</td>
                <td colspan="6" class="text-center"></td>
            </tr>
            <tr>
                <td colspan="8">YAPILAN İŞLEM AÇIKLAMASI</td>
                <td colspan="2" rowspan="3" class="text-center">:</td>
                <td colspan="10" rowspan="3">Açıklama Test</td>
            </tr>
            <tr>
                <td colspan="8"></td>
            </tr>
            <tr>
                <td colspan="8"></td>
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
                <th colspan="20" class="text-center">MAKİNA ÜZERİNDE GELEN AKSESUAR VE MAKİNE DURUMU</th>
            </tr>
            <tr>
                <th colspan="10" rowspan="7" class="text-center">HASARLI DURUMLARDA İŞARETLENECEK</th>
                <th colspan="5" class="text-center">MALZEME/İŞÇİLİK</th>
                <th colspan="1" class="text-center">MİKTAR</th>
                <th colspan="2" class="text-center">FİYAT</th>
                <th colspan="2" class="text-center">TUTAR</th>
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
                <th colspan="7" class="text-center">TESLİM ALAN</th>
                <th colspan="7" class="text-center">TESLİM EDEN</th>
                <th colspan="6" class="text-center">TEKNİK SORUMLU</th>
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
                <td colspan="17" class="text-center">Yukarıdaki Markası, Modeli, Seri Numarası ve Genel Durumu belirtilen cihazın bakım - onarımı yerinde / serviste yapılarak <span class="fw-bold">ÇALIŞIR / İADE</span> şeklinde teslim edilmiştir. Daha sonra oluşacak arızalardan <span class="fw-bold">ŞİRKETİMİZ</span> sorumlu değildir. Servis hizmet süresi en fazla <span class="fw-bold">20 (yirmi)</span> iş günüdür. Onarım tamamlandığı bilgisinin müşteriye beyanından sonra <span class="fw-bold">90 (doksan)</span> gün içerisinde teslim alınmayan cihazlardan şirketimiz sorumlu değildir. Yukarıda Marka / Modeli verilen cihazlardaki programların her türlü sorumluluğu müşteriye ait olup sahte yazılımlardan <span class="fw-bold">ŞİRKETİMİZ</span> sorumlu değildir. Lisansı olmayan hiçbir yazılım firmamız tarafından sisteme yüklenmez. Servis formu ibrazı ile sadece cihaz kaydı yaptıran kişiye teslim edilebilir. Onun dışında Kimlik Fotokobisi ve cihazı kaydettiren kişinin onay yazısı ile ilgili kişiye teslim edilebilir. Onarım için servise getirilen cihazların arıza tespiti yapıldıktan sonra onarıma onay verilmemişse {arıza_tespit_ucreti} tutarında arıza tespit ücreti alınır.</td>
            </tr>
        </tbody>
        <thead>
            <tr>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
            </tr>
        </thead>
    </table>
</body>

</html>