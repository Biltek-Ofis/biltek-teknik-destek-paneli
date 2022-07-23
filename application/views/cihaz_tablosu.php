<?php
$tur_belirtildimi = isset($tur) ? true : false;
$cihaz_turu_gizle = isset($cihaz_turu_gizle) ? $cihaz_turu_gizle : false;
echo '<div id="cihazTablosu" class="table-responsive">';
echo '<table class="table table-bordered">
<thead>
    <tr>
        <th scope="col">Cihaz Kodu</th>
        <th scope="col">Müşteri Adı</th>
        <th scope="col"'.($cihaz_turu_gizle ? ' style="display:none;"':'').'>Cihaz Türü</th>
        <th class="d-none d-lg-table-cell" scope="col">Cihaz</th>
        <th>Teslim Durumu</th>
        <th class="d-none d-lg-table-cell" scope="col">Giriş Tarihi</th>
        <th scope="col" colspan="2">İşlem</th>
    </tr>
</thead>
<tbody id="cihazlar">';
$teslim_durumu_1 = "Teslim Edildi";
$teslim_durumu_0 = "Kontrol Ediliyor";
$cihazEklendi = false;
$sonCihazID = 0;
$tabloOrnek = '<tr id="cihaz{id}" onClick="$(this).removeClass(\\\'success\\\')" class="{class}"><th scope="row">{id}</th><td id="{id}MusteriAdi">{musteri_adi}</td><td  id="{id}CihazTuru"'.($cihaz_turu_gizle ? ' style="display:none;"':'').'>{cihaz_turu}</td><td id="{id}Cihaz" class="d-none d-lg-table-cell">{cihaz}</td><td id="{id}TeslimDurumu">{teslim_durumu}</td><td id="{id}Tarih" class="d-none d-lg-table-cell">{tarih}</td><td><a href="#" class="btn btn-info text-white">Görüntüle</a></td><td><a href="#"  class="btn btn-danger text-white ms-2" data-bs-toggle="modal" data-bs-target="#cihazıSilModal{id}">Sil</a></td></tr>';
$cihazModalOrnek = '<div class="modal fade" id="cihazıSilModal{id}" tabindex="-1" aria-labelledby="cihazıSilModal{id}Label" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="cihazıSilModal{id}Label">Cihaz Silme İşlemini Onaylayın</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body">Bu cihazı silmek istediğinize emin misiniz?</div><div class="modal-footer"><a href="'.base_url(($tur_belirtildimi ? "cihazlar" : "anasayfa")."/cihazSil/".($tur_belirtildimi ? $tur : "")).'/{id}" type="button" class="btn btn-success">Evet</a><a href="#" type="button" class="btn btn-danger" data-bs-dismiss="modal">Hayır</a></div></div></div></div>';
$this->load->model("Anasayfa_Model");
$cihazlar = $tur_belirtildimi ? $this->Anasayfa_Model->cihazlarTekTur($tur):$this->Anasayfa_Model->cihazlar(); 
foreach ($cihazlar as $cihaz) {
    if($cihazEklendi == false){
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
      "{teslim_durumu}",
      "{tarih}",
    );
    
    $yeniler = array(
      "",
      "",
      $cihaz->id,
      $cihaz->musteri_adi,
      $cihaz->cihaz_turu,
      $cihaz->cihaz,
      $cihaz->teslim_edildi == 1 ? $teslim_durumu_1 : $teslim_durumu_0,
      $cihaz->tarih,
    );
    $tablo = str_replace($eskiler, $yeniler, $tabloOrnek);
    $cihazModal = str_replace($eskiler, $yeniler, $cihazModalOrnek);
    echo $tablo.$cihazModal;
}
echo '
</tbody>
</table>';
echo '</div>';

    echo '<div id="cihazlarUyari" class="alert alert-success" style="';
    if(count($cihazlar) > 0){
      echo 'display:none;';
    }
    echo ' role="alert">
    Bu Kategoride Cihaz Yok
</div>';
?>
<script type="text/javascript">
  let sonCihazID = <?=$sonCihazID;?>;
  setInterval(() => {
    $.get('<?=base_url("anasayfa/silinenCihazlariBul");?>' , {}, function (data) {
      $.each(JSON.parse(data), function( index, value ) {
        $("#cihaz"+value.cihaz_id).remove();
      });
    });
    $.get('<?=base_url(($tur_belirtildimi ? "cihazlar" : "anasayfa")."/cihazlarTumuJQ/".($tur_belirtildimi ? $tur : ""));?>', {}, function (data) {
      sayac = 0;
      $.each(JSON.parse(data), function( index, value ) {
        if(value.silindi == 1){
          $("#cihaz"+value.id).remove();
        }else{
          sonCihazID = value.id;
          sayac++;
        }
        $("#"+value.id+"TeslimDurumu").text(value.teslim_edildi == 1 ? "<?=$teslim_durumu_1;?>" : "<?=$teslim_durumu_0;?>");
      });
      if(sayac == 0){
        $("#cihazlarUyari").show();
      }
    });
    $.get('<?=base_url(($tur_belirtildimi ? "cihazlar" : "anasayfa")."/cihazlarJQ/".($tur_belirtildimi ? $tur."/" : ""));?>'+ sonCihazID , {}, function (data) {
      $.each(JSON.parse(data), function( index, value ) {
        $("#cihazlarUyari").hide();
        $("#cihaz"+value.id).remove();
        let tabloOrnek = '<?=$tabloOrnek;?>';
        let modalOrnek = '<?=$cihazModalOrnek;?>'
        var tablo = tabloOrnek.replaceAll("{class}", "success").replaceAll("{id}", value.id).replaceAll("{musteri_adi}", value.musteri_adi).replaceAll("{cihaz_turu}", value.cihaz_turu).replaceAll("{cihaz}", value.cihaz).replaceAll("{teslim_durumu}", value.teslim_edildi == 1 ? "<?=$teslim_durumu_1;?>" : "<?=$teslim_durumu_0;?>").replaceAll("{tarih}", value.tarih);
        var modal = modalOrnek.replaceAll("{class}", "success").replaceAll("{id}", value.id).replaceAll("{musteri_adi}", value.musteri_adi).replaceAll("{cihaz_turu}", value.cihaz_turu).replaceAll("{cihaz}", value.cihaz).replaceAll("{teslim_durumu}", value.teslim_edildi == 1 ? "<?=$teslim_durumu_1;?>" : "<?=$teslim_durumu_0;?>").replaceAll("{tarih}", value.tarih);
        $("#cihazlar").prepend(tablo);
        $("#cihazTablosu").prepend(modal);
      });
    });
  }, 5000);
</script>