<?php
$tur_belirtildimi = isset($tur) ? true : false;
$cihazTuruGizle = isset($cihazTuruGizle) ? $cihazTuruGizle : false;
$silButonuGizle = isset($silButonuGizle) ? $silButonuGizle : false;
echo '<div id="cihazTablosu" class="table-responsive">';
echo '<table class="table table-bordered">
<thead>
    <tr>
        <th class="d-none d-lg-table-cell" scope="col">Cihaz Kodu</th>
        <th scope="col">Müşteri Adı</th>
        <th scope="col"' . ($cihazTuruGizle ? ' style="display:none;"' : '') . '>Cihaz Türü</th>
        <th scope="col">Cihaz</th>
        <th class="d-none d-lg-table-cell" scope="col">Giriş Tarihi</th>
        <th scope="col" colspan="2">İşlem</th>
    </tr>
</thead>
<tbody id="cihazlar">';
$teslim_durumu_1 = "Teslim Edildi";
$teslim_durumu_0 = "Kontrol Ediliyor";
$cihazEklendi = false;
$sonCihazID = 0;
$tabloOrnek = '<tr id="cihaz{id}" onClick="$(this).removeClass(\\\'success\\\')" class="{class}"><th class="d-none d-lg-table-cell" scope="row">{id}</th><td id="{id}MusteriAdi">{musteri_adi}</td><td  id="{id}CihazTuru"' . ($cihazTuruGizle ? ' style="display:none;"' : '') . '>{cihaz_turu}</td><td id="{id}Cihaz">{cihaz}</td><td id="{id}Tarih" class="d-none d-lg-table-cell">{tarih}</td><td class="text-center"';
$tabloOrnek .= $silButonuGizle ? ' colspan="2"' : '';
$tabloOrnek .= '><button class="btn btn-info text-white" data-toggle="modal" data-target="#cihazDetayModal{id}">Detaylar</button></td>';
$tabloOrnek .= $silButonuGizle ? '' : '<td class="text-center"><button class="btn btn-danger text-white" data-toggle="modal" data-target="#cihaziSilModal{id}">Sil</button></td>';
$tabloOrnek .= '</tr>';
$cihazDetayModalOrnek = '<div class="modal fade" id="cihazDetayModal{id}" tabindex="-1" role="dialog" aria-labelledby="cihazDetayModal{id}Label" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="cihazDetayModal{id}Label">Cihaz Detayları</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Detaylar eklenecek</div><div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">Kapat</button></div></div></div></div>';
$cihazSilModalOrnek = $silButonuGizle ? '' : '<div class="modal fade" id="cihaziSilModal{id}" tabindex="-1" role="dialog" aria-labelledby="cihaziSilModal{id}Label" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="cihaziSilModal{id}Label">Cihaz Silme İşlemini Onaylayın</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Bu cihazı silmek istediğinize emin misiniz?</div><div class="modal-footer"><a href="' . base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/cihazSil/" . ($tur_belirtildimi ? $tur : "")) . '/{id}" class="btn btn-success">Evet</a><a class="btn btn-danger" data-dismiss="modal">Hayır</a></div></div></div></div>';
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
    "{cihaz_turu}",
    "{cihaz}",
    "{tarih}",
  );

  $yeniler = array(
    "",
    "",
    $cihaz->id,
    $cihaz->musteri_adi,
    $cihaz->cihaz_turu,
    $cihaz->cihaz,
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
    return str.replaceAll("{class}", "success").replaceAll("{id}", value.id).replaceAll("{musteri_adi}", value.musteri_adi).replaceAll("{cihaz_turu}", value.cihaz_turu).replaceAll("{cihaz}", value.cihaz).replaceAll("{tarih}", value.tarih);
  }
  setInterval(() => {
    $.get('<?= base_url("cihaz_yonetimi/silinenCihazlariBul"); ?>', {}, function(data) {
      $.each(JSON.parse(data), function(index, value) {
        $("#cihaz" + value.cihaz_id).remove();
      });
    });
    $.get('<?= base_url(($tur_belirtildimi ? "cihazlar" : "cihaz_yonetimi") . "/cihazlarTumuJQ/" . ($tur_belirtildimi ? $tur : "")); ?>', {}, function(data) {
      sayac = 0;
      $.each(JSON.parse(data), function(index, value) {
        if (value.silindi == 1) {
          $("#cihaz" + value.id).remove();
        } else {
          sonCihazID = value.id;
          sayac++;
        }
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