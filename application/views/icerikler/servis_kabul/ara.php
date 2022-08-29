<?php
defined('BASEPATH') or exit('No direct script access allowed');

echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Servis Kabul</title>';
$this->load->view("inc/meta");
$this->load->view("inc/styles");
echo '<link rel="stylesheet" href="' . base_url("plugins/icheck-bootstrap/icheck-bootstrap.min.css") . '">';
$this->load->view("inc/scripts");
if (strlen($servis_no)) {
} else {
  echo '<script>
    $(document).ready(function(){
        var servis_no = $("#servis_no");
        $("#ara").on("click", function(){
            var servis_no_val = servis_no.val();
            if(servis_no_val.length > 0){
                window.location.href = "' . base_url("serviskabul") . '/" + servis_no_val;
            }else{
                $("#uyari").show();
            }
        });
        servis_no.keyup(function(){
            $("#uyari").hide();
        });
    });
    </script>';
}
echo '</head>';
if (strlen($servis_no)) {
  $ilkOgeGenislik = "40%";
  $ikinciOgeGenislik = "60%";
  $besliIlkOgeGenislik = "40%";
  $besliIkinciOgeGenislik = "10%";
  $besliUcuncuOgeGenislik = "10%";
  $besliDorduncuOgeGenislik = "20%";
  $besliBesinciOgeGenislik = "20%";
  echo '<body>';
  $cihazBul = $this->Cihazlar_Model->servisNo($servis_no);
  if ($cihazBul->num_rows() > 0) {
    $cihaz = $this->Cihazlar_Model->cihazVerileriniDonustur($cihazBul->result())[0];

    $yapilanIslemToplamEskiArray = array(
      "{toplam_aciklama}",
      "{toplam_fiyat}"
    );
    $yapilanIslemEskiArray = array(
      "{islem}",
      "{miktar}",
      "{fiyat}",
      "{toplam_islem_fiyati}",
      "{toplam_islem_kdv}",
      "{kdv_orani}"
    );
    $yapilanIslemlerSatiriBos = '<ul class="list-group">
            <li class="list-group-item text-center">Şuanda yapılmış bir işlem yok.</li>
        </ul>';
    $yapilanIslemlerSatiri = '<ul class="list-group list-group-horizontal">
            <li class="list-group-item" style="width:' . $besliIlkOgeGenislik . ';">{islem}</li>
            <li class="list-group-item" style="width:' . $besliIkinciOgeGenislik . ';">{miktar}</li>
            <li class="list-group-item" style="width:' . $besliUcuncuOgeGenislik . ';">{fiyat} TL</li>
            <li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';">{toplam_islem_fiyati} TL</li>
            <li class="list-group-item" style="width:' . $besliBesinciOgeGenislik . ';">{toplam_islem_kdv} TL ({kdv_orani}%)</li>
        </ul>';
    $yapilanIslemToplam = '<ul class="list-group list-group-horizontal">
            <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">{toplam_aciklama}</span></li>
            <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';"><span class="font-weight-bold">{toplam_fiyat} TL</span></li>
        </ul>';
    $yapilanİslemler = "";
    $toplam_fiyat = 0;
    $kdv = 0;
    if ($cihaz->i_ad_1 != "" || $cihaz->i_ad_2 != "" || $cihaz->i_ad_3 != "" || $cihaz->i_ad_4 != "" || $cihaz->i_ad_5 != "") {
      $kdv = 0;
      if ($cihaz->i_ad_1 != "") {
        $toplam_islem_fiyati_1 = $cihaz->i_birim_fiyat_1 * $cihaz->i_miktar_1;
        $kdv_1 = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_1 / 100) * $cihaz->i_kdv_1);
        $yapilanIslemYeniArray_1 = array(
          $cihaz->i_ad_1,
          $cihaz->i_miktar_1,
          $cihaz->i_birim_fiyat_1,
          $toplam_islem_fiyati_1,
          $kdv_1,
          $cihaz->i_kdv_1
        );
        $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_1;
        $kdv = $kdv + $kdv_1;
        $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_1, $yapilanIslemlerSatiri);
      }
      if ($cihaz->i_ad_2 != "") {
        $toplam_islem_fiyati_2 = $cihaz->i_birim_fiyat_2 * $cihaz->i_miktar_2;
        $kdv_2 = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_2 / 100) * $cihaz->i_kdv_2);
        $yapilanIslemYeniArray_2 = array(
          $cihaz->i_ad_2,
          $cihaz->i_miktar_2,
          $cihaz->i_birim_fiyat_2,
          $toplam_islem_fiyati_2,
          $kdv_2,
          $cihaz->i_kdv_2
        );
        $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_2;
        $kdv = $kdv + $kdv_2;
        $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_2, $yapilanIslemlerSatiri);
      }
      if ($cihaz->i_ad_3 != "") {
        $toplam_islem_fiyati_3 = $cihaz->i_birim_fiyat_3 * $cihaz->i_miktar_3;
        $kdv_3 = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_3 / 100) * $cihaz->i_kdv_3);
        $yapilanIslemYeniArray_3 = array(
          $cihaz->i_ad_3,
          $cihaz->i_miktar_3,
          $cihaz->i_birim_fiyat_3,
          $toplam_islem_fiyati_3,
          $kdv_3,
          $cihaz->i_kdv_3
        );
        $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_3;
        $kdv = $kdv + $kdv_3;
        $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_3, $yapilanIslemlerSatiri);
      }
      if ($cihaz->i_ad_4 != "") {
        $toplam_islem_fiyati_4 = $cihaz->i_birim_fiyat_4 * $cihaz->i_miktar_4;
        $kdv_4 = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_4 / 100) * $cihaz->i_kdv_4);
        $yapilanIslemYeniArray_4 = array(
          $cihaz->i_ad_4,
          $cihaz->i_miktar_4,
          $cihaz->i_birim_fiyat_4,
          $toplam_islem_fiyati_4,
          $kdv_4,
          $cihaz->i_kdv_4
        );
        $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_4;
        $kdv = $kdv + $kdv_4;
        $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_4, $yapilanIslemlerSatiri);
      }
      if ($cihaz->i_ad_5 != "") {
        $toplam_islem_fiyati_5 = $cihaz->i_birim_fiyat_5 * $cihaz->i_miktar_5;
        $kdv_5 = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_5 / 100) * $cihaz->i_kdv_5);
        $yapilanIslemYeniArray_5 = array(
          $cihaz->i_ad_5,
          $cihaz->i_miktar_5,
          $cihaz->i_birim_fiyat_5,
          $toplam_islem_fiyati_5,
          $kdv_5,
          $cihaz->i_kdv_5
        );
        $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_5;
        $kdv = $kdv + $kdv_5;
        $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_5, $yapilanIslemlerSatiri);
      }
      if ($cihaz->i_ad_6 != "") {
        $toplam_islem_fiyati_6 = $cihaz->i_birim_fiyat_6 * $cihaz->i_miktar_6;
        $kdv_6 = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_6 / 100) * $cihaz->i_kdv_6);
        $yapilanIslemYeniArray_6 = array(
          $cihaz->i_ad_6,
          $cihaz->i_miktar_6,
          $cihaz->i_birim_fiyat_6,
          $toplam_islem_fiyati_6,
          $kdv_6,
          $cihaz->i_kdv_6
        );
        $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_6;
        $kdv = $kdv + $kdv_6;
        $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_6, $yapilanIslemlerSatiri);
      }
    } else {
      $yapilanİslemler = $yapilanIslemlerSatiriBos;
    }
    $yapilanIslemToplamYeni = array(
      "Toplam",
      $toplam_fiyat
    );
    $yapilanIslemToplamKDVYeni = array(
      "KDV",
      $kdv
    );
    $yapilanIslemGenelToplamYeni  = array(
      "Genel Toplam",
      $toplam_fiyat + $kdv
    );
    $toplam = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamYeni, $yapilanIslemToplam);
    $kdv = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamKDVYeni, $yapilanIslemToplam);
    $genel_toplam = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemGenelToplamYeni, $yapilanIslemToplam);
    $yapilanİslemler .= $toplam . $kdv . $genel_toplam;
    echo '<div class="row">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-genel-bilgiler-' . $cihaz->id . '-list" data-toggle="list" href="#list-genel-bilgiler-' . $cihaz->id . '" role="tab" aria-controls="genel-bilgiler-' . $cihaz->id . '">Genel Bilgiler</a>
            <a class="list-group-item list-group-item-action" id="list-cihaz-bilgileri-' . $cihaz->id . '-list" data-toggle="list" href="#list-cihaz-bilgileri-' . $cihaz->id . '" role="tab" aria-controls="cihaz-bilgileri-' . $cihaz->id . '">Cihaz Bilgileri</a>
            <a class="list-group-item list-group-item-action" id="list-teknik-servis-bilgileri-' . $cihaz->id . '-list" data-toggle="list" href="#list-teknik-servis-bilgileri-' . $cihaz->id . '" role="tab" aria-controls="teknik-servis-bilgileri-' . $cihaz->id . '">Teknik Servis Bilgileri</a>
            <a class="list-group-item list-group-item-action" id="list-yapilan-islemler-' . $cihaz->id . '-list" data-toggle="list" href="#list-yapilan-islemler-' . $cihaz->id . '" role="tab" aria-controls="yapilan-islemler-' . $cihaz->id . '">Yapılan İşlemler</a>
            <a class="list-group-item list-group-item-action" id="list-medyalar-' . $cihaz->id . '-list" data-toggle="list" href="#list-medyalar-' . $cihaz->id . '" role="tab" aria-controls="medyalar-' . $cihaz->id . '">Medyalar</a>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-genel-bilgiler-' . $cihaz->id . '" role="tabpanel" aria-labelledby="list-genel-bilgiler-' . $cihaz->id . '-list">
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Cihaz Kodu:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'ServisNo2">' . $cihaz->servis_no . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Müşteri Kodu:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'MusteriKod">' . $cihaz->musteri_kod . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Müşteri Adı:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'MusteriAdi2">' . $cihaz->musteri_adi . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Adresi:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'MusteriAdres">' . $cihaz->adres . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">GSM:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'MusteriGSM2">' . $cihaz->telefon_numarasi . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Giriş Tarihi:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'Tarih2">' . $cihaz->tarih . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Bildirim Tarihi:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'BildirimTarihi">' . $cihaz->bildirim_tarihi . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Çıkış Tarihi:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';"><span id="' . $cihaz->id . 'CikisTarihi">' . $cihaz->cikis_tarihi . '</span></li>
              </ul>
            </div>
            <div class="tab-pane fade" id="list-cihaz-bilgileri-' . $cihaz->id . '" role="tabpanel" aria-labelledby="list-cihaz-bilgileri-' . $cihaz->id . '-list">
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Cihaz Türü:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'CihazTuru2">' . $cihaz->cihaz_turu . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Markası:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'CihazMarka">' . $cihaz->cihaz . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Modeli:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'CihazModeli">' . $cihaz->cihaz_modeli . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Seri No:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'SeriNo">' . $cihaz->seri_no . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Teslim Alınanlar:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'TeslimAlinanlar">' . $cihaz->teslim_alinanlar . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Cihaz Şifresi:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'CihazSifresi">' . $cihaz->cihaz_sifresi . '</li>
              </ul>
            </div>
            <div class="tab-pane fade" id="list-teknik-servis-bilgileri-' . $cihaz->id . '" role="tabpanel" aria-labelledby="list-teknik-servis-bilgileri-' . $cihaz->id . '-list">
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Teslim Alınmadan Önce Belirlenen Hasar Türü:</span></span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'CihazdakiHasar">' . $this->Islemler_Model->cihazdakiHasar($cihaz->cihazdaki_hasar) . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Teslim Alınmadan Önce Yapılan Hasar Tespiti:</span></span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'HasarTespiti">' . $cihaz->hasar_tespiti . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Arıza Açıklaması:</span></span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'ArizaAciklamasi">' . $cihaz->ariza_aciklamasi . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Servis Türü:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'ServisTuru">' . $this->Islemler_Model->servisTuru($cihaz->servis_turu) . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Yedek Alınacak mı?:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'YedekDurumu">' . $this->Islemler_Model->evetHayir($cihaz->yedek_durumu) . '</li>
              </ul>
            </div>
            <div class="tab-pane fade" id="list-yapilan-islemler-' . $cihaz->id . '" role="tabpanel" aria-labelledby="list-yapilan-islemler-' . $cihaz->id . '-list">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Güncel Durum:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'GuncelDurum2">' . $this->Islemler_Model->cihazDurumu($cihaz->guncel_durum) . '</li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Sorumlu Personel:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'Sorumlu2">' . $cihaz->sorumlu . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Yapılan İşlem Açıklaması:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'yapilanIslemAciklamasi">' . $cihaz->yapilan_islem_aciklamasi . '</li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $besliIlkOgeGenislik . ';"><span class="font-weight-bold">Malzeme/İşçilik</span></li>
                <li class="list-group-item" style="width:' . $besliIkinciOgeGenislik . ';"><span class="font-weight-bold">Miktar</span></li>
                <li class="list-group-item" style="width:' . $besliUcuncuOgeGenislik . ';"><span class="font-weight-bold">Birim Fiyatı</span></li>
                <li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';"><span class="font-weight-bold">Tutar</span></li>
                <li class="list-group-item" style="width:' . $besliBesinciOgeGenislik . ';"><span class="font-weight-bold">kdv</span></li>
              </ul>
              <div id="yapilanIslem' . $cihaz->id . '">
                ' . $yapilanİslemler . '
              </div>
            </div>
            <div class="tab-pane fade" id="list-medyalar-' . $cihaz->id . '" role="tabpanel" aria-labelledby="list-medyalar-' . $cihaz->id . '-list">';
    $this->load->view("icerikler/medyalar", array("id" => $cihaz->id));
    echo '</div>
          </div>
        </div>
      </div>';
  } else {
    echo '<style type="text/css">

        ::selection { background-color: #E13300; color: white; }
        ::-moz-selection { background-color: #E13300; color: white; }
        
        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }
        
        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }
        
        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }
        
        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }
        
        #container {
            margin: 10px;
            padding: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }
        
        p {
            margin: 12px 15px 12px 15px;
        }
        </style>
        <div id="container">
		<h1>' . $servis_no . ' Servis numarasına ait cihaz bulunamadı.</h1>
        Lütfen servis numaranızı kontrol edip tekrar deneyin.
        <div class="w-100 m-0 p-0">
          <div class="row m-0 p-0 d-flex justify-content-end">
            <a href="javascript:history.go(-1);" class="btn btn-danger me-2 mb-2">
              Geri
            </a>
          </div>
        </div>
	    </div>';
  }

  echo '</body>';
} else {
  echo '<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="' . FIRMA_URL . ' target="_blank" class="h1 w-100 text-center"><img height="100" src="' . base_url("dist/img/logo.png") . '"/></a>
            </div>
            <div class="card-body">
            <div id="uyari" class="alert alert-danger" style="display:none;" role="alert">Lütfen bir servis numarası girin.</div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-laptop"></span>
                        </div>
                    </div>
                    <input type="text" id="servis_no" name="servis_no" class="form-control" placeholder="Servis Numarası">
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-4">
                        <button id="ara" type="submit" class="btn btn-primary btn-block">Ara</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>';
}
echo '</html>';
