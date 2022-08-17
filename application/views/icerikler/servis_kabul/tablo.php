<?php
echo '<script>
$(document).ready(function(){ 
    ' . $barcode_script . '
});
</script>';
echo '<table class="table col-5">
<thead>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
    <tr col="1"></tr>
</thead>
<tbody>';


echo '<tr>
<td style="border:0 !important;" class="align-middle text-center" colspan="6">SERVİS KABUL FORMU</td>
<td class="alt_cizgi" colspan="6">https://www.biltekbilgisayar.com.tr</td>
</tr>
<tr>
<td style="border:0 !important;" class="align-middle p-2" colspan="6" rowspan="3"><img height="45" src="' . base_url("dist/img/logo.png") . '" /></td>
</tr>
<tr>
<td class="alt_cizgi" colspan="6">(544) 297 0992</td>
</tr>
<tr>
<td style="border:0 !important;" colspan="6">Giriş Tarihi: ' . $cihaz->tarih . '</td>
</tr>
<tr>
<th colspan="3" class="align-middle">Servis No:</th>
<td colspan="3" class="align-middle">' . $cihaz->servis_no . '</td>
<td colspan="6" class="align-middle m-auto text-center">' . $barcode_div . '</td>
</tr>
<tr>
<th colspan="3">Onarım Türü:</th>
<td colspan="9">' . $this->Islemler_Model->servisTuru($cihaz->servis_turu) . '</td>
</tr>
<tr>
<th colspan="3">Müşteri:</th>
<td colspan="9">' . $cihaz->musteri_adi . '</td>
</tr>
<tr>
<th colspan="3">Telefon & Email:</th>
<td colspan="9">' . $cihaz->gsm_mail . '</td>
</tr>
<tr>
<th colspan="3">Cihaz Tipi:</th>
<td colspan="3">' . $cihaz->cihaz_turu . '</td>
<th colspan="3">Marka:</th>
<td colspan="3">' . $cihaz->cihaz . '</td>
</tr>
<tr>
<th colspan="3">Seri No:</th>
<td colspan="3">' . $cihaz->seri_no . '</td>
<th colspan="3">Model:</th>
<td colspan="3">' . $cihaz->cihaz_modeli . '</td>
</tr>
<tr>
<th colspan="3">Arıza:</th>
<td colspan="9">' . $cihaz->ariza_aciklamasi . '</td>
</tr>
<tr>
<th colspan="4">Teslim Alınmadan Önce Yapılan Hasar Tespiti:</th>
<td colspan="8">' . $cihaz->hasar_tespiti . '</td>
</tr>
<tr>
<th colspan="3">Teknik Sorumlu:</th>
<td colspan="8">';

$sorumlu_personel = $this->Kullanicilar_Model->tekKullaniciIsım($cihaz->sorumlu);

if (isset($sorumlu_personel)) {
    //echo $sorumlu_personel->id . ' - ';
}
$cihaz->sorumlu;
echo '</tr>
<tr>
<th class="text-center" colspan="12">Aksesuarlar</th>
</tr>';
$aksesuar_sayisi = 0;
if ($cihaz->tasima_cantasi != 0) {
    $aksesuar_sayisi++;

    echo '<tr>
<th colspan="3">Taşıma Çantası:</th>
<td colspan="9">' . $this->Islemler_Model->hasarDurumu($cihaz->tasima_cantasi) . '</td>
</tr>';
}
if ($cihaz->sarj_adaptoru != 0) {
    $aksesuar_sayisi++;

    echo '<tr>
<th colspan="3">Sarj Adaptörü:</th>
<td colspan="9">' . $this->Islemler_Model->hasarDurumu($cihaz->sarj_adaptoru) . '</td>
</tr>';
}
if ($cihaz->pil != 0) {
    $aksesuar_sayisi++;
    echo '
<tr>
<th colspan="3">Pil:</th>
<td colspan="9">' . $this->Islemler_Model->hasarDurumu($cihaz->pil) . '</td>
</tr>';
}
if ($aksesuar_sayisi == 0) {
    echo '
<tr>
<td>Cihaz ile birlikte teslim edilen aksesuar yok.</td>
</tr>';
}
echo '
<tr>
<th colspan="6">Teslim Alan</th>
<th colspan="6">Teslim Eden</th>
</tr>
<tr>
<th colspan="6">Ad Soyad:</th>
<th colspan="6">Ad Soyad:</th>
</tr>
<tr>
<th colspan="6">İmza:</th>
<th colspan="6">İmza:</th>
</tr>';
echo '</tbody>
</table>';
