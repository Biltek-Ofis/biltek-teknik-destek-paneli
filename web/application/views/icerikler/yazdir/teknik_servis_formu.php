<?php
echo '<!DOCTYPE html>
<html lang="tr">

<head>';
$this->load->view("inc/meta");
$bilgileri_goster = FALSE;
if(isset($cihaz)){
    $bilgileri_goster = TRUE;
}

echo '<title>TEKNİK SERVİS FORMU' . ($bilgileri_goster ? " ".$cihaz->id : ""). '</title>';

$this->load->view("inc/eski/styles");
$this->load->view("inc/eski/scripts");
$this->load->view("inc/style_yazdir_tablo");
$this->load->view("inc/styles_important");
$alan_musteri = "";
$guncelle = FALSE;
if(isset($_GET["alan"])){
    $alan_musteri = $_GET["alan"];
}
if(isset($_GET["guncelle"])){
    $guncelle = TRUE;
}
if($bilgileri_goster && $guncelle){
    $cihaz->teslim_alan = $alan_musteri;
    $this->Cihazlar_Model->cihazDuzenle($cihaz->id, array(
        "teslim_alan" => $alan_musteri,
    ), 0, FALSE);
}

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
    $(document).ready(function() {
        window.print();
    });
    ';
function donusturOnclick($oge)
{
  return str_replace("'","\'",trim(preg_replace('/\s\s+/', '<br>', $oge)));
}
if($bilgileri_goster){
    echo '
    function tsFormuYazdir(){
        $.post(\'' . base_url("cihazyonetimi/teslimAlanDuzenle/".$cihaz->id) .'\', {alan: \''.donusturOnclick($cihaz->teslim_alan).'\'}, function(data) {
            self.close();
        }).fail(function(response) {
            self.close();
        });
    }';
}
    echo 'function tsBosFormuYazdir(){
       self.close();
    }
    </script>
</head>';

echo '<body onafterprint="'. ($bilgileri_goster ? 'tsFormuYazdir()' : 'tsBosFormuYazdir()').'" class="ozel_tema_yok">
    <table class="table table-bordered table-sm w-100">
        <tbody>
            <tr>
                <td style="border:0 !important;" class="align-middle p-2" colspan="14" rowspan="8"><img height="110" src="' . base_url("dist/img/logo.png") . '" /></td>
            </tr>
            <tr>
                <th style="border:0 !important;" class="text-end h5 fw-bold pr-3" colspan="6">No: ' . ($bilgileri_goster ? $cihaz->servis_no : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"). '</th>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="6"></td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3">Giriş Tarihi: </td>
                <td style="border:0 !important;" colspan="3">' . ($bilgileri_goster ? $cihaz->tarih : ""). '</td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3">Bildirim Tarihi: </td>
                <td style="border:0 !important;" colspan="3">' . ($bilgileri_goster ? $cihaz->bildirim_tarihi : ""). '</td>
            </tr>
            <tr style="border:0 !important;">
                <td style="border:0 !important;" colspan="3">Çıkış Tarihi: </td>
                <td style="border:0 !important;" colspan="3">' . ($bilgileri_goster ? $cihaz->cikis_tarihi : ""). '</td>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr>
                <td style="border:0 !important;" colspan="3"></td>
            </tr>
            <tr>
                <td colspan="20" class="text-center fw-bold">TEKNİK SERVİS FORMU</td>
            </tr>
            <tr>
                <td colspan="20" class="text-center fw-bold">GENEL BİLGİLER</td>
            </tr>
            <tr>
                <td colspan="8" class="fw-bold">MÜŞTERİ ADI SOYADI</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->musteri_adi : "") . '</td>
            </tr>
            <tr>
                <td colspan="8">ADRESİ</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->adres : "") . '</td>
            </tr>
            <tr>
                <td colspan="8">GSM</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->telefon_numarasi : "") . '</td>
            </tr>
            <tr>
                <td colspan="8" class="fw-bold">CİHAZIN MARKASI</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->cihaz : "") . '</td>
            </tr>
            <tr>
                <td colspan="8" class="fw-bold">MODELİ</th>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->cihaz_modeli : "") . '</td>
            </tr>
            <tr>
                <td colspan="8" class="fw-bold">Cihazın Seri Numarası</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->seri_no : "") . '</td>
            </tr>
            <tr style="height: 80px !important;">
                <td colspan="8">BELİRTİLEN ARIZA AÇIKLAMASI</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->ariza_aciklamasi : "") . '</td>
            </tr>

            <tr>
                <td colspan="8">TESLİM ALINANLAR</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' . ($bilgileri_goster ? $cihaz->teslim_alinanlar : "") . '</td>
            </tr>
            <tr>
                <td colspan="20" class="text-center fw-bold">YAPILACAK İŞLEM</td>
            </tr>
            <tr>
                <td colspan="8" class="fw-bold">' . $this->Islemler_Model->servisTuru(1) . '</td>
                <td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){

    if ($cihaz->servis_turu == 1) {
        echo '<i class="fas fa-check"></i>';
    }
}
echo '</td>
<td colspan="8" class="fw-bold">' . $this->Islemler_Model->servisTuru(2) . '</td>
<td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->servis_turu == 2) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
            </tr>
            <tr>
            <td colspan="8" class="fw-bold">' . $this->Islemler_Model->servisTuru(3) . '</td>
            <td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->servis_turu == 3) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
<td colspan="8" class="fw-bold">' . $this->Islemler_Model->servisTuru(4) . '</td>
<td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->servis_turu == 4) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
                
            </tr>
            <tr style="height: 80px !important;">
                <td colspan="8">YAPILAN İŞLEM AÇIKLAMASI</td>
                <td colspan="2" class="text-center">:</td>
                <td colspan="10">' .($bilgileri_goster ? $cihaz->yapilan_islem_aciklamasi : ""). '</td>
            </tr>
            <tr>
                <td colspan="8">YEDEKLİ İŞLEM</td>
                <td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->yedek_durumu == 1) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
                <td colspan="8">YEDEKSİZ İŞLEM</td>
                <td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->yedek_durumu == 2) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="20" class="text-center fw-bold">MAKİNA ÜZERİNDE GELEN AKSESUAR VE MAKİNE DURUMU</td>
            </tr>';
$hasarli_durumlar_rowspan = $bilgileri_goster ? (count($cihaz->islemler) > 5 ? count($cihaz->islemler) : 5) : 5;

echo '
            <tr>
                <td colspan="10" rowspan="' . ($hasarli_durumlar_rowspan + 3) . '" class="text-center fw-bold">HASARLI DURUMLAR</td>
                <td colspan="4" class="text-center fw-bold">MALZEME/İŞÇİLİK</td>
                <td colspan="1" class="text-center fw-bold">MİKTAR</td>
                <td colspan="1" class="text-center fw-bold">BİRİM FİYATI</td>
                <td colspan="2" class="text-center fw-bold">TUTAR</td>
                <td colspan="2" class="text-center fw-bold">KDV</td>
            </tr>';
$toplam = 0;
$kdv = 0;
$genel_toplam = 0;
if($bilgileri_goster){
if (count($cihaz->islemler) > 0) {
    foreach($cihaz->islemler as $islem){
        $toplam_islem_fiyati_suan =  $islem->miktar * $islem->birim_fiyat;
        $kdv_suan = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_suan / 100) * $islem->kdv);
        echo '<tr>
                <td colspan="4">' . $islem->ad  . '</td>
                <td colspan="1" class="text-center">' . $islem->miktar . '</td>
                <td colspan="1" class="text-center">' .  $islem->birim_fiyat . '</td>
                <td colspan="2" class="text-center">' . $toplam_islem_fiyati_suan . '</td>';
        echo '<td colspan="2" class="text-center">' . ($kdv_suan > 0 ? $kdv_suan : "") . '</td>';
        //echo '<td colspan="2" class="text-center">' . ($kdv_suan > 0 ? $kdv_suan . ' (' . $islem->kdv . '%)' : "") . '</td>';
        echo '
            </tr>';
        $toplam = $toplam + $toplam_islem_fiyati_suan;
        $kdv = $kdv + $kdv_suan;
    }
    if(count($cihaz->islemler) < 5){
        for ($i = 0; $i < (5 - count($cihaz->islemler)); $i++) {
            echo '<tr style="height:20px;">
                        <td colspan="4"></td>
                        <td colspan="1" class="text-center"></td>
                        <td colspan="1" class="text-center"></td>
                        <td colspan="2" class="text-center"></td>
                        <td colspan="2" class="text-center"></td>
                    </tr>';
        }
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

}else{
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
echo '<tr>
                <td colspan="8">TOPLAM</td>
                <td colspan="2" class="text-center">' . ($toplam > 0 ? $toplam . " TL" : "") . '</td>
            </tr>
            <tr>
                <td colspan="8">KDV</td>
                <td colspan="2" class="text-center">' . ($kdv > 0 ? $kdv . " TL" : "") . '</td>
            </tr>
            <tr>  
                <td colspan="2" class="text-center">ÇİZİK</td>
                <td colspan="2" class="text-center">KIRIK</td>
                <td colspan="2" class="text-center">ÇATLAK</td>
                <td colspan="4" class="text-center">DİĞER</td>
                <td colspan="8">GENEL TOPLAM</td>
                <td colspan="2" class="text-center">' . ($genel_toplam > 0 ? $genel_toplam . " TL" : "") . '</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->cihazdaki_hasar == 1) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</i></td>
                                <td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->cihazdaki_hasar == 2) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
                                <td colspan="2" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->cihazdaki_hasar == 3) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
                                <td colspan="4" class="text-center align-middle">';
if($bilgileri_goster){
if ($cihaz->cihazdaki_hasar == 4) {
    echo '<i class="fas fa-check"></i>';
}
}
echo '</td>
            <td colspan="5">TAHSİLAT ŞEKLİ</td>
            <td colspan="5" class="text-center">' . ($bilgileri_goster ? $cihaz->tahsilat_sekli : "") . '</td>

            </tr>
            <tr>
                <td colspan="7" class="text-center fw-bold">TESLİM EDEN</td>
                <td colspan="7" class="text-center fw-bold">TESLİM ALAN</td>
                <td colspan="6" class="text-center fw-bold">TEKNİK SORUMLU</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">ADI SOYADI</td>
                <td colspan="4" class="text-center">' . ($bilgileri_goster ? $cihaz->teslim_eden : "") . '</td>
                <td colspan="3" class="text-center">ADI SOYADI</td>
                <td colspan="4" class="text-center">'. ($bilgileri_goster ? $cihaz->teslim_alan : "") . '</td>
                <td colspan="3" class="text-center">ADI SOYADI</td>
                <td colspan="3" class="text-center">'. ($bilgileri_goster ? $cihaz->sorumlu : "") . '';

/* echo $cihaz->sorumlu;*/
$imza_konum = "";
if($bilgileri_goster){
    $imza_konum = $cihaz->imza_dosyasi;
    if($cihaz->imza_yerel == 1 && strlen(trim($cihaz->imza_dosyasi)) > 0){
        $imza_konum = base_url($cihaz->imza_dosyasi);
    }
}
echo '</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">İMZASI</td>
                <td colspan="4" class="text-center"></td>
                <td colspan="3" class="text-center">İMZASI</td>
                <td colspan="4" class="text-center">'.(strlen($imza_konum) > 0 ? '<img width="110" height="30" src="'.$imza_konum.'"/>' : "").'</td>
                <td colspan="3" class="text-center">İMZASI</td>
                <td colspan="3" class="text-center"></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">NOT</td>
                <td colspan="17" class="text-center">
                    Yukarıdaki Markası, Modeli, Seri Numarası ve Genel Durumu belirtilen cihazın bakım - onarımı yerinde / serviste yapılarak <span class="fw-bold">ÇALIŞIR / İADE</span> şeklinde teslim edilmiştir. Daha sonra oluşacak arızalardan <span class="fw-bold">ŞİRKETİMİZ</span> sorumlu değildir. <span class="fw-bold">Servis hizmet süresi en fazla 20 (yirmi) iş günüdür. Onarım tamamlandığı bilgisinin müşteriye beyanından sonra 90 (doksan) gün içerisinde teslim alınmayan cihazlardan şirketimiz sorumlu değildir.</span><!-- Yukarıda Marka / Modeli verilen cihazlardaki programların her türlü sorumluluğu müşteriye ait olup sahte yazılımlardan <span class="fw-bold">ŞİRKETİMİZ</span> sorumlu değildir. Lisansı olmayan hiçbir yazılım firmamız tarafından sisteme yüklenmez. Servis formu ibrazı ile sadece cihaz kaydı yaptıran kişiye teslim edilebilir. Onun dışında Kimlik Fotokobisi ve cihazı kaydettiren kişinin onay yazısı ile ilgili kişiye teslim edilebilir. Onarım için servise getirilen cihazların arıza tespiti yapıldıktan sonra onarıma onay verilmemişse {arıza_tespit_ucreti} tutarında arıza tespit ücreti alınır. BİLDİRİLEN DOSYALAR DIŞINDAKİ, HDD BOZUKLUKLARINDAN DOLAYI VE VİRÜSLERDEN DOLAYI BOZULMUŞ VERİ KAYIPLARINDAN ŞİRKETİMİZ SORUMLU DEĞİLDİR. MEYDANA GELEBİLECEK VERİ KAYIPLARINDAN ŞİRKETİMİZ SORUMLU DEĞİLDİR. YEDEKLEME İŞLEMİ ÜCRETE TABİDİR.-->
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

</html>';
