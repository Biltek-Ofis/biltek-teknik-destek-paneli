<?php
defined('BASEPATH') or exit('No direct script access allowed');

echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">';
$ayarlar = $this->Ayarlar_Model->getir();
    echo '    
    <title>Cihaz Durumu'.(isset($ayarlar->site_basligi) ? " - " . $ayarlar->site_basligi : "").'</title>';
$this->load->view("inc/meta");
$this->load->view("inc/styles");
echo '<link rel="stylesheet" href="' . base_url("plugins/icheck-bootstrap/icheck-bootstrap.min.css") . '">';
$this->load->view("inc/scripts");
if (strlen($takip_numarasi) == 0) {
  echo '<script>
    $(document).ready(function(){
        var takip_numarasi = $("#takip_numarasi");
        $("#ara").on("click", function(){
            var takip_numarasi_val = takip_numarasi.val();
            if(takip_numarasi_val.length > 0){
                window.location.href = "' . base_url("cihazdurumu") . '/" + takip_numarasi_val;
            }else{
                $("#uyari").show();
            }
        });
        takip_numarasi.keyup(function(){
            $("#uyari").hide();
        });
    });
    </script>';
}
echo '</head>';
if (strlen($takip_numarasi) > 0) {
  $hataMesaji = '
  <div id="container">
  <h1>' . $takip_numarasi .' Takip numarasına ait cihaz bulunamadı.</h1>
  Lütfen servis numaranızı kontrol edip tekrar deneyin.
  <div class="w-100 m-0 p-0">
    <div class="row m-0 p-0 d-flex justify-content-end">
      <a href="javascript:history.go(-1);" class="btn btn-danger me-2 mb-2">
        Geri
      </a>
    </div>
  </div>
  </div>';
  $ilkOgeGenislik = "40%";
  $ikinciOgeGenislik = "60%";
  $besliIlkOgeGenislik = "20%";
  $besliIkinciOgeGenislik = "20%";
  $besliUcuncuOgeGenislik = "20%";
  $besliDorduncuOgeGenislik = "20%";
  $besliBesinciOgeGenislik = "20%";
  echo '<body>';
  echo '<style type="text/css">
  
  ::selection { background-color: #E13300; color: white; }
  ::-moz-selection { background-color: #E13300; color: white; }
  
  body {
      background-color: #fff;
      margin: 40px;
      font: 18px/25px normal Helvetica, Arial, sans-serif;
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
  </style>';
  $cihazBul = $this->Cihazlar_Model->takipNumarasi($takip_numarasi);
  if ($cihazBul->num_rows() > 0) {
    $cihaz = $this->Cihazlar_Model->cihazVerileriniDonustur($cihazBul->result())[0];
 
    echo '<div class="container">
    <div class="row w-100 m-0 p-0">
      <div class="col-12">
        <div id="list-cihaz-bilgileri-' . $cihaz->id . '" role="tabpanel" aria-labelledby="list-cihaz-bilgileri-' . $cihaz->id . '-list">
          <ul class="list-group list-group-horizontal">
            <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Servis No:</span></li>
            <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'ServisNo2">' . $cihaz->servis_no . '</li>
          </ul>
          <ul class="list-group list-group-horizontal">
            <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Takip No:</span></li>
            <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'TakipNo">' . $cihaz->takip_numarasi . '</li>
          </ul>
          <ul class="list-group list-group-horizontal">
            <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Müşteri Bilgileri:</span></li>
            <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'ServisNo2">' . $cihaz->musteri_adi . '</li>
          </ul>
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
            <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Arıza Açıklaması:</span></span></li>
            <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'ArizaAciklamasi">' . $cihaz->ariza_aciklamasi . '</li>
          </ul>
          <ul class="list-group list-group-horizontal">
            <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Servis Türü:</span></li>
            <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'ServisTuru">' . $this->Islemler_Model->servisTuru($cihaz->servis_turu) . '</li>
          </ul>
          <ul class="list-group list-group-horizontal">
              <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Güncel Durum:</span></li>
              <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="' . $cihaz->id . 'GuncelDurum2">'.$cihaz->guncel_durum_text.'</li>
          </ul>
        </div>
      </div>
      </div>
    </div>';
  } else {
    echo  $hataMesaji;
  }

  echo '</body>';
} else {
  $ayarlar = $this->Ayarlar_Model->getir();
  echo '<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="' . $ayarlar->firma_url . ' target="_blank" class="h1 w-100 text-center"><img height="100" src="' . base_url("dist/img/logo.png") . '"/></a>
            </div>
            <div class="card-body">
            <div id="uyari" class="alert alert-danger" style="display:none;" role="alert">Lütfen bir servis numarası girin.</div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-laptop"></span>
                        </div>
                    </div>
                    <input type="text" id="takip_numarasi" name="takip_numarasi" class="form-control" placeholder="Takip Numarası">
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
