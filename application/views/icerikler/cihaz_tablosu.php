<?php
$tur_belirtildimi = isset($tur) ? true : false;
$cihazTuruGizle = isset($cihazTuruGizle) ? $cihazTuruGizle : false;
$silButonuGizle = isset($silButonuGizle) ? $silButonuGizle : false;
echo '<div id="cihazTablosu" class="table-responsive">';
echo '<table class="table table-bordered">
<thead>
    <tr>
        <th scope="col">Cihaz Kodu</th>
        <th scope="col">Müşteri Adı</th>
        <th scope="col"' . ($cihazTuruGizle ? ' style="display:none;"' : '') . '>Cihaz Türü</th>
        <th scope="col">Cihaz Modeli</th>
        <th scope="col">Giriş Tarihi</th>
        <th scope="col" colspan="2">İşlem</th>
    </tr>
</thead>
<tbody id="cihazlar">';
$teslim_durumu_1 = "Teslim Edildi";
$teslim_durumu_0 = "Kontrol Ediliyor";
$cihazEklendi = false;
$sonCihazID = 0;
$tabloOrnek = '<tr id="cihaz{id}" onClick="$(this).removeClass(\\\'bg-success\\\')" class="{class}">
  <th scope="row">{id}</th>
  <td id="{id}MusteriAdi">{musteri_adi}</td>
  <td  id="{id}CihazTuru"' . ($cihazTuruGizle ? ' style="display:none;"' : '') . '>{cihaz_turu}</td>
  <td id="{id}Cihaz">{cihaz}</td>
  <td id="{id}Tarih">{tarih}</td>
  <td class="text-center"'.($silButonuGizle ? ' colspan="2"' : '').'>
    <button class="btn btn-info text-white" data-toggle="modal" data-target="#cihazDetayModal{id}">Detaylar</button>
  </td>
  '.($silButonuGizle ? '' : '<td class="text-center"><button class="btn btn-danger text-white" data-toggle="modal" data-target="#cihaziSilModal{id}">Sil</button></td>').'
s</tr>';
$ilkOgeGenislik = "40%";
$ikinciOgeGenislik = "60%";
$cihazDetayModalOrnek = '<div class="modal fade" id="cihazDetayModal{id}" tabindex="-1" role="dialog" aria-labelledby="cihazDetayModal{id}Label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cihazDetayModal{id}Label">Cihaz Detayları</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
              <a class="list-group-item list-group-item-action active" id="list-genel-bilgiler-list" data-toggle="list" href="#list-genel-bilgiler" role="tab" aria-controls="genel-bilgiler">Genel Bilgiler</a>
              <a class="list-group-item list-group-item-action" id="list-cihaz-bilgileri-list" data-toggle="list" href="#list-cihaz-bilgileri" role="tab" aria-controls="cihaz-bilgileri">Cihaz Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-teknik-servis-bilgileri-list" data-toggle="list" href="#list-teknik-servis-bilgileri" role="tab" aria-controls="teknik-servis-bilgileri">Teknik Servis Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-aksesuar-bilgileri-list" data-toggle="list" href="#list-aksesuar-bilgileri" role="tab" aria-controls="aksesuar-bilgileri">Aksesuar Bilgileri</a>
            </div>
          </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-genel-bilgiler" role="tabpanel" aria-labelledby="list-genel-bilgiler-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Giriş Tarihi:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{tarih}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Müşteri Adı:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{musteri_adi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Adresi:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{adres}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">GSM & E-Mail:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{gsm_mail}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">TEL-FAKS:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{tel_faks}</li>
                </ul>
              </div>
              <div class="tab-pane fade" id="list-cihaz-bilgileri" role="tabpanel" aria-labelledby="list-cihaz-bilgileri-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Cihaz Türü:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{cihaz_turu}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Marka / Modeli:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{cihaz}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Seri No:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{seri_no}</li>
                </ul>
              </div>
              <div class="tab-pane fade" id="list-teknik-servis-bilgileri" role="tabpanel" aria-labelledby="list-teknik-servis-bilgileri-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Teslim Durum:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{teslim_edildi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold"><span class="font-weight-bold">Arıza Açıklaması:</span></span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{ariza_aciklamasi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Servis Türü:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{servis_turu}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Yedek Alınacak mı?:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{yedek_durumu}</li>
                </ul>
              </div>
              <div class="tab-pane fade" id="list-aksesuar-bilgileri" role="tabpanel" aria-labelledby="list-aksesuar-bilgileri-list">
              
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Taşıma Çantası:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{tasima_cantasi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Sarj Adaptörü:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{sarj_adaptoru}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Pil:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{pil}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:'.$ilkOgeGenislik.';"><span class="font-weight-bold">Diğer:</span></li>
                  <li class="list-group-item" style="width:'.$ikinciOgeGenislik.';">{diger_aksesuar}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
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
$tabloOrnek = $this->Islemler_Model->trimle($tabloOrnek);
$cihazDetayModalOrnek = $this->Islemler_Model->trimle($cihazDetayModalOrnek);
$cihazSilModalOrnek = $this->Islemler_Model->trimle($cihazSilModalOrnek);
$this->load->model("Cihazlar_Model");
$cihazlar = $tur_belirtildimi ? $this->Cihazlar_Model->cihazlarTekTur($tur) : $this->Cihazlar_Model->cihazlar();
foreach ($cihazlar as $cihaz) {
  if ($cihazEklendi == false) {
    $sonCihazID = $cihaz->id;
    $cihazEklendi = true;
  }
  $eskiler = array(
    "\\",
    "{class}",
    "{id}",
    "{musteri_adi}",
    "{adres}",
    "{gsm_mail}",
    "{tel_faks}",
    "{cihaz_turu}",
    "{cihaz}",
    "{seri_no}",
    "{ariza_aciklamasi}",
    "{servis_turu}",
    "{yedek_durumu}",
    "{tasima_cantasi}",
    "{sarj_adaptoru}",
    "{pil}",
    "{diger_aksesuar}",
    "{teslim_edildi}",
    "{tarih}",
  );

  $yeniler = array(
    "",
    "",
    $cihaz->id,
    $cihaz->musteri_adi,
    $cihaz->adres,
    $cihaz->gsm_mail,
    $cihaz->tel_faks,
    $cihaz->cihaz_turu,
    $cihaz->cihaz,
    $cihaz->seri_no,
    $cihaz->ariza_aciklamasi,
    $cihaz->servis_turu,
    $cihaz->yedek_durumu,
    $cihaz->tasima_cantasi,
    $cihaz->sarj_adaptoru,
    $cihaz->pil,
    $cihaz->diger_aksesuar,
    $cihaz->teslim_edildi == 1 ? $teslim_durumu_1 : $teslim_durumu_0,
    $cihaz->tarih,
  );
  $tablo = str_replace($eskiler, $yeniler, $tabloOrnek);
  $cihazSilModal = str_replace($eskiler, $yeniler, $cihazSilModalOrnek);
  $cihazDetayModal = str_replace($eskiler, $yeniler, $cihazDetayModalOrnek);
  echo $tablo . $cihazSilModal . $cihazDetayModal;
}
echo '
</tbody>
</table>';
echo '</div>';

echo '<div id="cihazlarUyari" class="alert alert-success" style="';
if (count($cihazlar) > 0) {
  echo 'display:none;';
}
echo ' role="alert">
    Bu Kategoride Cihaz Yok
</div>';
?>
<script type="text/javascript">
  let sonCihazID = <?= $sonCihazID; ?>;
  function donustur(str, value){
    return str.
    replaceAll("{class}", "bg-success")
    .replaceAll("{id}", value.id)
    .replaceAll("{musteri_adi}", value.musteri_adi)
    .replaceAll("{adres}", value.adres)
    .replaceAll("{gsm_mail}", value.gsm_mail)
    .replaceAll("{tel_faks}", value.tel_faks)
    .replaceAll("{cihaz_turu}", value.cihaz_turu)
    .replaceAll("{cihaz}", value.cihaz)
    .replaceAll("{seri_no}", value.seri_no)
    .replaceAll("{ariza_aciklamasi}", value.ariza_aciklamasi)
    .replaceAll("{servis_turu}", value.servis_turu)
    .replaceAll("{yedek_durumu}", value.yedek_durumu)
    .replaceAll("{tasima_cantasi}", value.tasima_cantasi)
    .replaceAll("{sarj_adaptoru}", value.sarj_adaptoru)
    .replaceAll("{pil}", value.pil)
    .replaceAll("{diger_aksesuar}", value.diger_aksesuar)
    .replaceAll("{teslim_edildi}", value.teslim_edildi)
    .replaceAll("{tarih}", value.tarih);
  }
  setInterval(() => {
    $.get('<?= base_url("cihaz_yonetimi/silinenCihazlariBul"); ?>', {}, function(data) {
      $.each(JSON.parse(data), function(index, value) {
        $("#cihaz" + value.id).remove();
      });
    });
    $.get('<?= base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/cihazlarTumuJQ/" . ($tur_belirtildimi ? $tur : "")); ?>', {}, function(data) {
      sayac = 0;
      $.each(JSON.parse(data), function(index, value) {
        sonCihazID = value.id;
        sayac++;
        //$("#" + value.id + "TeslimDurumu").text(value.teslim_edildi == 1 ? "<?= $teslim_durumu_1; ?>" : "<?= $teslim_durumu_0; ?>");
      });
      if (sayac == 0) {
        $("#cihazlarUyari").show();
      }
    });

    $.get('<?= base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/cihazlarJQ/" . ($tur_belirtildimi ? $tur . "/" : "")); ?>' + sonCihazID, {}, function(data) {
      $.each(JSON.parse(data), function(index, value) {
        $("#cihazlarUyari").hide();
        $("#cihaz" + value.id).remove();
        let tabloOrnek = '<?= $tabloOrnek; ?>';
        let silModalOrnek = '<?= $cihazSilModalOrnek; ?>';
        let detayModalOrnek = '<?= $cihazDetayModalOrnek; ?>';
        
        var tablo = donustur(tabloOrnek, value);
        var silmodal = donustur(silModalOrnek, value);
        var detayModal = donustur(detayModalOrnek, value);
        $("#cihazlar").prepend(tablo);
        $("#cihazTablosu").prepend(silmodal);
        $("#cihazTablosu").prepend(detayModal);
      });
    });
  }, 5000);
</script>