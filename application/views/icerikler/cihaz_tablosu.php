<?php $this->load->view("inc/datatables_scripts"); ?>
<style>
  .modal.modal-fullscreen .modal-dialog {
    width: 100vw;
    height: 100vh;
    margin: 0;
    padding: 0;
    max-width: none;
  }

  .modal.modal-fullscreen .modal-content {
    height: auto;
    height: 100vh;
    border-radius: 0;
    border: none;
  }

  .modal.modal-fullscreen .modal-body {
    overflow-y: auto;
  }
</style>
<script>
  function medyalariYukle(id) {
    $.post('<?= base_url("medyalar"); ?>/' + id, {}, function(data) {
      $("#list-medyalar-" + id).html(data);
    });
  }
</script>
<?php
$tur_belirtildimi = isset($tur) ? true : false;
$cihazTuruGizle = isset($cihazTuruGizle) ? $cihazTuruGizle : false;
$silButonuGizle = isset($silButonuGizle) ? $silButonuGizle : false;
echo '<div id="cihazTablosu" class="table-responsive">';
echo '<table id="cihaz_tablosu" class="table table-bordered mt-2">
<thead>
    <tr>
        <th scope="col">Cihaz Kodu</th>
        <th scope="col">Müşteri Adı</th>
        <th scope="col"' . ($cihazTuruGizle ? ' style="display:none;"' : '') . '>Cihaz Türü</th>
        <th scope="col">Cihaz Marka / Modeli</th>
        <th scope="col">Güncel Durum</th>
        <th scope="col">Teslim Durumu</th>
        <th scope="col">Detaylar</th>
    </tr>
</thead>
<tbody id="cihazlar">';
$teslim_durumu_1 = 'Teslim Edildi';
$teslim_durumu_renkli_1 = '<span class="text-success">' . $teslim_durumu_1 . '</span>';
$teslim_durumu_0 = 'Teslim Edilmedi';
$teslim_durumu_renkli_0 = '<span class="text-danger">' . $teslim_durumu_0 . '</span>';
$sonCihazID = 0;
$tabloOrnek = '<tr id="cihaz{id}" onClick="$(this).removeClass(\\\'bg-success\\\')" class="{class}">
  <th scope="row">{id}</th>
  <td id="{id}MusteriAdi">{musteri_adi}</td>
  <td  id="{id}CihazTuru"' . ($cihazTuruGizle ? ' style="display:none;"' : '') . '>{cihaz_turu}</td>
  <td id="{id}Cihaz">{cihaz} {cihaz_modeli}</td>
  <td id="{id}CihazGuncelDurumu">{guncel_durum}</td>
  <td id="{id}CihazTeslimDurumu">{teslim_edildi2}</td>
  <td class="text-center">
    <button class="btn btn-info text-white" data-toggle="modal" data-target="#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '{id}">Detaylar</button>
  </td>
</tr>';
$ilkOgeGenislik = "40%";
$ikinciOgeGenislik = "60%";
$besliIlkOgeGenislik = "40%";
$besliIkinciOgeGenislik = "10%";
$besliUcuncuOgeGenislik = "10%";
$besliDorduncuOgeGenislik = "20%";
$besliBesinciOgeGenislik = "20%";
$cihazDetayOrnek = '<div class="modal modal-fullscreen fade" id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . '{id}" tabindex="-1" role="dialog" aria-labelledby="' . $this->Cihazlar_Model->cihazDetayModalAdi() . '{id}Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . '{id}Label">Cihaz Detayları</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
              <a class="list-group-item list-group-item-action active" id="list-genel-bilgiler-{id}-list" data-toggle="list" href="#list-genel-bilgiler-{id}" role="tab" aria-controls="genel-bilgiler-{id}">Genel Bilgiler</a>
              <a class="list-group-item list-group-item-action" id="list-cihaz-bilgileri-{id}-list" data-toggle="list" href="#list-cihaz-bilgileri-{id}" role="tab" aria-controls="cihaz-bilgileri-{id}">Cihaz Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-teknik-servis-bilgileri-{id}-list" data-toggle="list" href="#list-teknik-servis-bilgileri-{id}" role="tab" aria-controls="teknik-servis-bilgileri-{id}">Teknik Servis Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-aksesuar-bilgileri-{id}-list" data-toggle="list" href="#list-aksesuar-bilgileri-{id}" role="tab" aria-controls="aksesuar-bilgileri-{id}">Aksesuar Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-yapilan-islemler-{id}-list" data-toggle="list" href="#list-yapilan-islemler-{id}" role="tab" aria-controls="yapilan-islemler-{id}">Yapılan İşlemler</a>
              <a class="list-group-item list-group-item-action" id="list-medyalar-{id}-list" data-toggle="list" href="#list-medyalar-{id}" role="tab" aria-controls="medyalar-{id}">Medyalar</a>
            </div>
          </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-genel-bilgiler-{id}" role="tabpanel" aria-labelledby="list-genel-bilgiler-{id}-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Cihaz Kodu:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{id}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Müşteri Kodu:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{musteri_kod}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Müşteri Adı:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{musteri_adi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Adresi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{adres}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">GSM & E-Mail:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{gsm_mail}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Giriş Tarihi:</span></li>
                  <li id="{id}Tarih" class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{tarih}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Bildirim Tarihi:</span></li>
                  <li id="{id}BildirimTarihi" class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{bildirim_tarihi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Çıkış Tarihi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';"><span id="{id}CikisTarihi">{cikis_tarihi}</span> <a href="' . base_url() . '/cihaz_yonetimi/cikisTarihi/{id}" class="text-link">(Güncelle)</a></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Güncel Durum:</span></li>
                  <li id="{id}GuncelDurum" class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{guncel_durum}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Teslim Durumu:</span></li>
                  <li id="{id}TeslimDurumu" class="list-group-item" style="width:' . $ikinciOgeGenislik . ';"><span id="{id}TeslimDurumuText">{teslim_edildi}</span> <a href="#" class="text-link" data-toggle="modal" data-target="#cihazTeslimEdildiModal{id}">(Değiştir)</a></li>
                </ul>
              </div>
              <div class="tab-pane fade" id="list-cihaz-bilgileri-{id}" role="tabpanel" aria-labelledby="list-cihaz-bilgileri-{id}-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Cihaz Türü:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{cihaz_turu}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Markası:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{cihaz}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Modeli:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{cihaz_modeli}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Seri No:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{seri_no}</li>
                </ul>
              </div>
              <div class="tab-pane fade" id="list-teknik-servis-bilgileri-{id}" role="tabpanel" aria-labelledby="list-teknik-servis-bilgileri-{id}-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Teslim Alınmadan Önce Belirlenen Hasar Türü:</span></span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{cihazdaki_hasar}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Teslim Alınmadan Önce Yapılan Hasar Tespiti:</span></span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{hasar_tespiti}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Arıza Açıklaması:</span></span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{ariza_aciklamasi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Servis Türü:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{servis_turu}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Yedek Alınacak mı?:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{yedek_durumu}</li>
                </ul>
              </div>
              <div class="tab-pane fade" id="list-aksesuar-bilgileri-{id}" role="tabpanel" aria-labelledby="list-aksesuar-bilgileri-{id}-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Taşıma Çantası:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{tasima_cantasi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Sarj Adaptörü:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{sarj_adaptoru}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Pil:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{pil}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Diğer:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{diger_aksesuar}</li>
                </ul>
              </div>
              <div class="tab-pane fade" id="list-yapilan-islemler-{id}" role="tabpanel" aria-labelledby="list-yapilan-islemler-{id}-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Yapılan İşlem Açıklaması:</span></li>
                  <li id="{id}yapilanIslemAciklamasi" class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{yapilan_islem_aciklamasi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $besliIlkOgeGenislik . ';"><span class="font-weight-bold">Malzeme/İşçilik</span></li>
                  <li class="list-group-item" style="width:' . $besliIkinciOgeGenislik . ';"><span class="font-weight-bold">Miktar</span></li>
                  <li class="list-group-item" style="width:' . $besliUcuncuOgeGenislik . ';"><span class="font-weight-bold">Birim Fiyatı</span></li>
                  <li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';"><span class="font-weight-bold">Tutar</span></li>
                  <li class="list-group-item" style="width:' . $besliBesinciOgeGenislik . ';"><span class="font-weight-bold">kdv</span></li>
                </ul>
                <div id="yapilanIslem{id}">
                  {yapilan_islemler}
                </div>
              </div>
              <div class="tab-pane fade" id="list-medyalar-{id}" role="tabpanel" aria-labelledby="list-medyalar-{id}-list">
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <a href="' . base_url("cihaz") . '/{id}" class="btn btn-primary">Düzenle</a>
      <a href="#" onclick="barkoduYazdir({id})" class="btn btn-dark text-white">Barkodu Yazdır</a>
      <a href="#" onclick="formuYazdir({id})" class="btn btn-dark text-white">Formu Yazdır</a>
      ' . ($silButonuGizle ? '' : '<a href="#" class="btn btn-danger text-white" data-toggle="modal" data-target="#cihaziSilModal{id}">Sil</a>') . '
      <a href="#" class="btn btn-secondary" data-dismiss="modal">Kapat</a>
      </div>
    </div>
  </div>
</div>';

$cihazTeslimEdildiModalOrnek = '<div class="modal fade" id="cihazTeslimEdildiModal{id}" tabindex="-1" role="dialog" aria-labelledby="cihazTeslimEdildiModal{id}Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cihazTeslimEdildiModal{id}Label">Teslim Edilme Durumunu Onaylayın</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      {teslim_durumu_uyari}
      </div>
      <div class="modal-footer">
        <a href="' . base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/teslimEdildi/" . ($tur_belirtildimi ? $tur : "")) . '/{id}/{teslim_durumu_id}" class="btn btn-success">Evet</a>
        <a class="btn btn-danger" data-dismiss="modal">Hayır</a>
      </div>
    </div>
  </div>
</div>';

$cihazSilModalOrnek = $silButonuGizle ? '' : '<div class="modal fade" id="cihaziSilModal{id}" tabindex="-1" role="dialog" aria-labelledby="cihaziSilModal{id}Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cihaziSilModal{id}Label">Cihaz Silme İşlemini Onaylayın</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Bu cihazı silmek istediğinize emin misiniz?
      </div>
      <div class="modal-footer">
        <a href="' . base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/cihazSil/" . ($tur_belirtildimi ? $tur : "")) . '/{id}" class="btn btn-success">Evet</a>
        <a class="btn btn-danger" data-dismiss="modal">Hayır</a>
      </div>
    </div>
  </div>
</div>';
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
$yapilanIslemlerSatiriBos = '<ul class="list-group">
<li class="list-group-item text-center">Şuanda yapılmış bir işlem yok.</li>
</ul>';
$yapilanIslemToplam = $this->Islemler_Model->trimle($yapilanIslemToplam);
$yapilanIslemlerSatiri = $this->Islemler_Model->trimle($yapilanIslemlerSatiri);
$yapilanIslemlerSatiriBos = $this->Islemler_Model->trimle($yapilanIslemlerSatiriBos);
$tabloOrnek = $this->Islemler_Model->trimle($tabloOrnek);
$cihazDetayOrnek = $this->Islemler_Model->trimle($cihazDetayOrnek);
$cihazTeslimEdildiModalOrnek = $this->Islemler_Model->trimle($cihazTeslimEdildiModalOrnek);
$cihazSilModalOrnek = $this->Islemler_Model->trimle($cihazSilModalOrnek);
$this->load->model("Cihazlar_Model");
$cihazlar = $tur_belirtildimi ? $this->Cihazlar_Model->cihazlarTekTur($tur) : $this->Cihazlar_Model->cihazlar();

$eskiler = array(
  "\\",
  "{class}",
  "{id}",
  "{musteri_adi}",
  "{musteri_kod}",
  "{adres}",
  "{gsm_mail}",
  "{cihaz_turu}",
  "{cihaz}",
  "{cihaz_modeli}",
  "{seri_no}",
  "{hasar_tespiti}",
  "{cihazdaki_hasar}",
  "{ariza_aciklamasi}",
  "{servis_turu}",
  "{yedek_durumu}",
  "{tasima_cantasi}",
  "{sarj_adaptoru}",
  "{pil}",
  "{diger_aksesuar}",
  "{yapilan_islem_aciklamasi}",
  "{teslim_edildi}",
  "{teslim_edildi2}",
  "{tarih}",
  "{bildirim_tarihi}",
  "{cikis_tarihi}",
  "{guncel_durum}",
  "{yapilan_islemler}",
  "{teslim_durumu_uyari}",
  "{teslim_durumu_id}",
);

$yapilanIslemToplamEskiArray = array(
  "{toplam_aciklama}",
  "{toplam_fiyat}",
);
$yapilanIslemEskiArray = array(
  "{islem}",
  "{miktar}",
  "{fiyat}",
  "{toplam_islem_fiyati}",
  "{toplam_islem_kdv}",
  "{kdv_orani}",
);
$sayac = 0;
foreach ($cihazlar as $cihaz) {
  if ($sayac == count($cihazlar) - 1) {
    $sonCihazID = $cihaz->id;
  }
  $sayac++;
  $yapilanİslemler = "";
  $toplam_fiyat = 0;
  $kdv = 0;
  if ($cihaz->i_ad_1 != "" || $cihaz->i_ad_2 != "" || $cihaz->i_ad_3 != "" || $cihaz->i_ad_4 != "" || $cihaz->i_ad_5 != "") {
    $kdv = 0;
    if ($cihaz->i_ad_1 != "") {
      $toplam_islem_fiyati_1 = $cihaz->i_birim_fiyat_1 * $cihaz->i_miktar_1;
      $kdv_1 = ceil(($toplam_islem_fiyati_1 / 100) * $cihaz->i_kdv_1);
      $yapilanIslemYeniArray_1 = array(
        $cihaz->i_ad_1,
        $cihaz->i_miktar_1,
        $cihaz->i_birim_fiyat_1,
        $toplam_islem_fiyati_1,
        $kdv_1,
        $cihaz->i_kdv_1,
      );
      $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_1;
      $kdv = $kdv + $kdv_1;
      $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_1, $yapilanIslemlerSatiri);
    }
    if ($cihaz->i_ad_2 != "") {
      $toplam_islem_fiyati_2 = $cihaz->i_birim_fiyat_2 * $cihaz->i_miktar_2;
      $kdv_2 = ceil(($toplam_islem_fiyati_2 / 100) * $cihaz->i_kdv_2);
      $yapilanIslemYeniArray_2 = array(
        $cihaz->i_ad_2,
        $cihaz->i_miktar_2,
        $cihaz->i_birim_fiyat_2,
        $toplam_islem_fiyati_2,
        $kdv_2,
        $cihaz->i_kdv_2,
      );
      $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_2;
      $kdv = $kdv + $kdv_2;
      $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_2, $yapilanIslemlerSatiri);
    }
    if ($cihaz->i_ad_3 != "") {
      $toplam_islem_fiyati_3 = $cihaz->i_birim_fiyat_3 * $cihaz->i_miktar_3;
      $kdv_3 = ceil(($toplam_islem_fiyati_3 / 100) * $cihaz->i_kdv_3);
      $yapilanIslemYeniArray_3 = array(
        $cihaz->i_ad_3,
        $cihaz->i_miktar_3,
        $cihaz->i_birim_fiyat_3,
        $toplam_islem_fiyati_3,
        $kdv_3,
        $cihaz->i_kdv_3,
      );
      $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_3;
      $kdv = $kdv + $kdv_3;
      $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_3, $yapilanIslemlerSatiri);
    }
    if ($cihaz->i_ad_4 != "") {
      $toplam_islem_fiyati_4 = $cihaz->i_birim_fiyat_4 * $cihaz->i_miktar_4;
      $kdv_4 = ceil(($toplam_islem_fiyati_4 / 100) * $cihaz->i_kdv_4);
      $yapilanIslemYeniArray_4 = array(
        $cihaz->i_ad_4,
        $cihaz->i_miktar_4,
        $cihaz->i_birim_fiyat_4,
        $toplam_islem_fiyati_4,
        $kdv_4,
        $cihaz->i_kdv_4,
      );
      $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_4;
      $kdv = $kdv + $kdv_4;
      $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_4, $yapilanIslemlerSatiri);
    }
    if ($cihaz->i_ad_5 != "") {
      $toplam_islem_fiyati_5 = $cihaz->i_birim_fiyat_5 * $cihaz->i_miktar_5;
      $kdv_5 = ceil(($toplam_islem_fiyati_5 / 100) * $cihaz->i_kdv_5);
      $yapilanIslemYeniArray_5 = array(
        $cihaz->i_ad_5,
        $cihaz->i_miktar_5,
        $cihaz->i_birim_fiyat_5,
        $toplam_islem_fiyati_5,
        $kdv_5,
        $cihaz->i_kdv_5,
      );
      $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_5;
      $kdv = $kdv + $kdv_5;
      $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_5, $yapilanIslemlerSatiri);
    }
  } else {
    $yapilanİslemler = $yapilanIslemlerSatiriBos;
  }
  $yapilanIslemToplamYeni = array(
    "Toplam",
    $toplam_fiyat,
  );
  $yapilanIslemToplamKDVYeni = array(
    "KDV",
    $kdv,
  );
  $yapilanIslemGenelToplamYeni  = array(
    "Genel Toplam",
    $toplam_fiyat + $kdv,
  );
  $toplam = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamYeni, $yapilanIslemToplam);
  $kdv = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamKDVYeni, $yapilanIslemToplam);
  $genel_toplam = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemGenelToplamYeni, $yapilanIslemToplam);
  $yapilanİslemler .= $toplam . $kdv . $genel_toplam;
  $yeniler = array(
    "",
    "",
    $cihaz->id,
    $cihaz->musteri_adi,
    isset($cihaz->musteri_kod) ? $cihaz->musteri_kod : "Yok",
    $cihaz->adres,
    $cihaz->gsm_mail,
    $cihaz->cihaz_turu,
    $cihaz->cihaz,
    $cihaz->cihaz_modeli,
    $cihaz->seri_no,
    $cihaz->hasar_tespiti,
    $this->Islemler_Model->cihazdakiHasar($cihaz->cihazdaki_hasar),
    $cihaz->ariza_aciklamasi,
    $this->Islemler_Model->servisTuru($cihaz->servis_turu),
    $this->Islemler_Model->evetHayir($cihaz->yedek_durumu),
    $this->Islemler_Model->hasarDurumu($cihaz->tasima_cantasi),
    $this->Islemler_Model->hasarDurumu($cihaz->sarj_adaptoru),
    $this->Islemler_Model->hasarDurumu($cihaz->pil),
    $cihaz->diger_aksesuar,
    $cihaz->yapilan_islem_aciklamasi,
    $cihaz->teslim_edildi == 1 ? $teslim_durumu_renkli_1 : $teslim_durumu_renkli_0,
    $cihaz->teslim_edildi == 1 ? $teslim_durumu_1 : $teslim_durumu_0,
    $cihaz->tarih,
    $cihaz->bildirim_tarihi,
    $cihaz->cikis_tarihi,
    $this->Islemler_Model->cihazDurumu($cihaz->guncel_durum),
    $yapilanİslemler,
    $cihaz->teslim_edildi == 1 ? "Bu cihazı teslim edilmedi olarak işaretlemek istediğinize emin misiniz?" : "Bu cihazı teslim edildi olarak işaretlemek istediğinize emin misiniz?",
    $cihaz->teslim_edildi == 1 ? 0 : 1
  );
  $tablo = str_replace($eskiler, $yeniler, $tabloOrnek);
  $cihazTeslimEdildiModal = str_replace($eskiler, $yeniler, $cihazTeslimEdildiModalOrnek);
  $cihazSilModal = str_replace($eskiler, $yeniler, $cihazSilModalOrnek);
  $cihazDetay = str_replace($eskiler, $yeniler, $cihazDetayOrnek);
  echo $tablo . $cihazDetay . $cihazSilModal  . $cihazTeslimEdildiModal;
?>
  <script>
    medyalariYukle(<?= $cihaz->id; ?>);
  </script>
<?php
}
echo '
</tbody>
</table>';
echo '</div>';
?>
<script type="text/javascript">
  let sonCihazID = <?= $sonCihazID; ?>;
  <?php
  $yapilanIslemToplamYeni2 = array(
    "Toplam",
    "0",
  );
  $yapilanIslemToplamKDVYeni2 = array(
    "KDV",
    "0",
  );
  $yapilanIslemGenelToplamYeni2  = array(
    "Genel Toplam",
    "0",
  );
  $toplam2 = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamYeni2, $yapilanIslemToplam);
  $kdv2 = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamKDVYeni2, $yapilanIslemToplam);
  $genel_toplam2 = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemGenelToplamYeni2, $yapilanIslemToplam);
  ?>

  function servisTuru(id) {
    switch (id) {
      case 1:
        return '<?= $this->Islemler_Model->servisTuru(1); ?>';
      case 2:
        return '<?= $this->Islemler_Model->servisTuru(2); ?>';
      case 3:
        return '<?= $this->Islemler_Model->servisTuru(3); ?>';
      case 4:
        return '<?= $this->Islemler_Model->servisTuru(4); ?>';
      default:
        return '<?= $this->Islemler_Model->servisTuru(3); ?>'
    }
  }
  <?php
  echo '
  function hasarDurumu(id) {
    switch (id) {';
  for ($i = 0; $i < count($this->Islemler_Model->hasarDurumu); $i++) {
    echo '
      case ' . $i . ':
        return "' . $this->Islemler_Model->hasarDurumu[$i] . '";';
  }
  echo '
      default:
        return "' . $this->Islemler_Model->hasarDurumu[0] . '";
    }
  }';
  ?>
  <?php
  echo '
  function evetHayir(id) {
    switch (id) {';
  for ($i = 0; $i < count($this->Islemler_Model->evetHayir); $i++) {
    echo '
      case ' . $i . ':
        return "' . $this->Islemler_Model->evetHayir[$i] . '";';
  }
  echo '
      default:
        return "' . $this->Islemler_Model->evetHayir[0] . '";
    }
  }';
  ?>
  <?php
  echo '
  function cihazdakiHasar(id) {
    switch (id) {';
  for ($i = 0; $i < count($this->Islemler_Model->cihazdakiHasar); $i++) {
    echo '
      case ' . $i . ':
        return "' . $this->Islemler_Model->cihazdakiHasar[$i] . '";';
  }
  echo '
      default:
        return "' . $this->Islemler_Model->cihazdakiHasar[0] . '";
    }
  }';
  ?>
  <?php
  echo '
  function cihazDurumu(id) {
    switch (id) {';
  for ($i = 0; $i < count($this->Islemler_Model->cihazDurumu); $i++) {
    echo '
      case ' . $i . ':
        return "' . $this->Islemler_Model->cihazDurumu[$i] . '";';
  }
  echo '
      default:
        return "' . $this->Islemler_Model->cihazDurumu[0] . '";
    }
  }';
  ?>

  function donustur(str, value) {
    return str.
    replaceAll("{class}", "bg-success")
      .replaceAll("{id}", value.id)
      .replaceAll("{musteri_adi}", value.musteri_adi)
      .replaceAll("{musteri_kod}", value.musteri_kod ? value.musteri_kod : "Yok")
      .replaceAll("{adres}", value.adres)
      .replaceAll("{gsm_mail}", value.gsm_mail)
      .replaceAll("{cihaz_turu}", value.cihaz_turu)
      .replaceAll("{cihaz}", value.cihaz)
      .replaceAll("{cihaz_modeli}", value.cihaz_modeli)
      .replaceAll("{seri_no}", value.seri_no)
      .replaceAll("{hasar_tespiti}", value.hasar_tespiti)
      .replaceAll("{cihazdaki_hasar}", cihazdakiHasar(value.cihazdaki_hasar))
      .replaceAll("{ariza_aciklamasi}", value.ariza_aciklamasi)
      .replaceAll("{servis_turu}", servisTuru(value.servis_turu))
      .replaceAll("{yedek_durumu}", evetHayir(value.yedek_durumu))
      .replaceAll("{tasima_cantasi}", hasarDurumu(value.tasima_cantasi))
      .replaceAll("{sarj_adaptoru}", hasarDurumu(value.sarj_adaptoru))
      .replaceAll("{pil}", hasarDurumu(value.pil))
      .replaceAll("{diger_aksesuar}", value.diger_aksesuar)
      .replaceAll("{yapilan_islem_aciklamasi}", value.yapilan_islem_aciklamasi)
      .replaceAll("{teslim_edildi}", value.teslim_edildi == 1 ? '<?= $teslim_durumu_renkli_1; ?>' : '<?= $teslim_durumu_renkli_0; ?>')
      .replaceAll("{teslim_edildi2}", value.teslim_edildi == 1 ? '<?= $teslim_durumu_1; ?>' : '<?= $teslim_durumu_0; ?>')
      .replaceAll("{tarih}", value.tarih)
      .replaceAll("{bildirim_tarihi}", value.bildirim_tarihi)
      .replaceAll("{cikis_tarihi}", value.cikis_tarihi)
      .replaceAll("{guncel_durum}", cihazDurumu(value.guncel_durum))
      .replaceAll("{yapilan_islemler}", '<?= $yapilanIslemlerSatiriBos . $toplam2 . $kdv2 . $genel_toplam2; ?>')
      .replaceAll("{teslim_durumu_uyari}", value.teslim_edildi == 1 ? "Bu cihazı teslim edilmedi olarak işaretlemek istediğinize emin misiniz?" : "Bu cihazı teslim edildi olarak işaretlemek istediğinize emin misiniz?")
      .replaceAll("{teslim_durumu_id}", value.teslim_edildi == 1 ? 0 : 1);
  }

  $(document).ready(function() {
    var tabloDiv = "#cihaz_tablosu";
    var cihazlarTablosu = $(tabloDiv).DataTable(<?= $this->Islemler_Model->datatablesAyarlari([0, "desc"]); ?>);
    setInterval(() => {
      $.get('<?= base_url("cihaz_yonetimi/silinenCihazlariBul"); ?>', {}, function(data) {
        $.each(JSON.parse(data), function(index, value) {
          cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
        });
      });
      $.get('<?= base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/cihazlarTumuJQ/" . ($tur_belirtildimi ? $tur : "")); ?>', {}, function(data) {
        sayac = 0;
        $.each(JSON.parse(data), function(index, value) {
          sonCihazID = value.id;
          var toplam = 0;
          var kdv = 0;
          var yapilanIslemler = "";
          var islemlerSatiri = '<?= $yapilanIslemlerSatiri; ?>';
          var islemlerSatiriBos = '<?= $yapilanIslemlerSatiriBos; ?>';
          if (value.i_ad_1 || value.i_ad_2 || value.i_ad_3 || value.i_ad_4 || value.i_ad_5) {
            if (value.i_ad_1) {
              var yapilan_islem_tutari_1 = value.i_birim_fiyat_1 * value.i_miktar_1;
              toplam = toplam + yapilan_islem_tutari_1;
              var kdv_1 = Math.ceil((yapilan_islem_tutari_1 / 100) * value.i_kdv_1);
              kdv = kdv + kdv_1;
              yapilanIslemler += islemlerSatiri
                .replaceAll("{islem}", value.i_ad_1)
                .replaceAll("{miktar}", value.i_miktar_1)
                .replaceAll("{fiyat}", value.i_birim_fiyat_1)
                .replaceAll("{toplam_islem_fiyati}", yapilan_islem_tutari_1)
                .replaceAll("{toplam_islem_kdv}", kdv_1)
                .replaceAll("{kdv_orani}", value.i_kdv_1);
            }
            if (value.i_ad_2) {
              var yapilan_islem_tutari_2 = value.i_birim_fiyat_2 * value.i_miktar_2;
              toplam = toplam + yapilan_islem_tutari_2;
              var kdv_2 = Math.ceil((yapilan_islem_tutari_2 / 100) * value.i_kdv_2);
              kdv = kdv + kdv_2;
              yapilanIslemler += islemlerSatiri
                .replaceAll("{islem}", value.i_ad_2)
                .replaceAll("{miktar}", value.i_miktar_2)
                .replaceAll("{fiyat}", value.i_birim_fiyat_2)
                .replaceAll("{toplam_islem_fiyati}", yapilan_islem_tutari_2)
                .replaceAll("{toplam_islem_kdv}", kdv_2)
                .replaceAll("{kdv_orani}", value.i_kdv_2);
            }
            if (value.i_ad_3) {
              var yapilan_islem_tutari_3 = value.i_birim_fiyat_3 * value.i_miktar_3;
              toplam = toplam + yapilan_islem_tutari_3;
              var kdv_3 = Math.ceil((yapilan_islem_tutari_3 / 100) * value.i_kdv_3);
              kdv = kdv + kdv_3;
              yapilanIslemler += islemlerSatiri
                .replaceAll("{islem}", value.i_ad_3)
                .replaceAll("{miktar}", value.i_miktar_3)
                .replaceAll("{fiyat}", value.i_birim_fiyat_3)
                .replaceAll("{toplam_islem_fiyati}", yapilan_islem_tutari_3)
                .replaceAll("{toplam_islem_kdv}", kdv_3)
                .replaceAll("{kdv_orani}", value.i_kdv_3);
            }
            if (value.i_ad_4) {
              var yapilan_islem_tutari_4 = value.i_birim_fiyat_4 * value.i_miktar_4;
              toplam = toplam + yapilan_islem_tutari_4;
              var kdv_4 = Math.ceil((yapilan_islem_tutari_4 / 100) * value.i_kdv_4);
              kdv = kdv + kdv_4;
              yapilanIslemler += islemlerSatiri
                .replaceAll("{islem}", value.i_ad_4)
                .replaceAll("{miktar}", value.i_miktar_4)
                .replaceAll("{fiyat}", value.i_birim_fiyat_4)
                .replaceAll("{toplam_islem_fiyati}", yapilan_islem_tutari_4)
                .replaceAll("{toplam_islem_kdv}", kdv_4)
                .replaceAll("{kdv_orani}", value.i_kdv_4);
            }
            if (value.i_ad_5) {
              var yapilan_islem_tutari_5 = value.i_birim_fiyat_5 * value.i_miktar_5;
              toplam = toplam + yapilan_islem_tutari_5;
              var kdv_5 = Math.ceil((yapilan_islem_tutari_5 / 100) * value.i_kdv_5);
              kdv = kdv + kdv_5;
              yapilanIslemler += islemlerSatiri
                .replaceAll("{islem}", value.i_ad_5)
                .replaceAll("{miktar}", value.i_miktar_5)
                .replaceAll("{fiyat}", value.i_birim_fiyat_5)
                .replaceAll("{toplam_islem_fiyati}", yapilan_islem_tutari_5)
                .replaceAll("{toplam_islem_kdv}", kdv_5)
                .replaceAll("{kdv_orani}", value.i_kdv_5);
            }
          } else {
            var yapilanIslemler = islemlerSatiriBos;
          }
          var yapilanIslemToplam = '<?= $yapilanIslemToplam; ?>';
          var toplamDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "Toplam").replaceAll("{toplam_fiyat}", toplam);
          var kdvDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "KDV").replaceAll("{toplam_fiyat}", kdv);
          var genelToplamDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "Genel Toplam").replaceAll("{toplam_fiyat}", toplam + kdv);
          yapilanIslemler += toplamDiv + kdvDiv + genelToplamDiv;
          $("#yapilanIslem" + value.id).html(yapilanIslemler);

          sayac++;
          $("#" + value.id + "TeslimDurumuText").html(value.teslim_edildi == 1 ? '<?= $teslim_durumu_renkli_1; ?>' : '<?= $teslim_durumu_renkli_0; ?>');
          $("#" + value.id + "CihazTeslimDurumu").html(value.teslim_edildi == 1 ? '<?= $teslim_durumu_1; ?>' : '<?= $teslim_durumu_0; ?>');
          $("#" + value.id + "yapilanIslemAciklamasi").html(value.yapilan_islem_aciklamasi);
          $("#" + value.id + "Tarih").html(value.tarih);
          $("#" + value.id + "BildirimTarihi").html(value.bildirim_tarihi);
          $("#" + value.id + "CikisTarihi").html(value.cikis_tarihi);
          $("#" + value.id + "GuncelDurum").html(cihazDurumu(value.guncel_durum));
          $("#" + value.id + "CihazGuncelDurumu").html(cihazDurumu(value.guncel_durum));
        });
      });

      $.get('<?= base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/cihazlarJQ/" . ($tur_belirtildimi ? $tur . "/" : "")); ?>' + sonCihazID, {}, function(data) {
        $.each(JSON.parse(data), function(index, value) {
          cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
          let tabloOrnek = '<?= $tabloOrnek; ?>';
          let detayModalOrnek = '<?= $cihazDetayOrnek; ?>';
          let cihazTeslimEdildiModalOrnek = '<?= $cihazTeslimEdildiModalOrnek; ?>';
          let silModalOrnek = '<?= $cihazSilModalOrnek; ?>';

          const tablo = donustur(tabloOrnek, value);
          var detayModal = donustur(detayModalOrnek, value);
          var cihazTeslimEdildiModal = donustur(cihazTeslimEdildiModalOrnek, value);
          var silmodal = donustur(silModalOrnek, value);
          cihazlarTablosu.row.add($(tablo)).draw();
          //$("#cihazlar").prepend(tablo);
          $("#cihazTablosu").prepend(cihazTeslimEdildiModal);
          $("#cihazTablosu").prepend(silmodal);
          $("#cihazTablosu").prepend(detayModal);
          medyalariYukle(value.id);
        });
      });
    }, 5000);
  });
</script>