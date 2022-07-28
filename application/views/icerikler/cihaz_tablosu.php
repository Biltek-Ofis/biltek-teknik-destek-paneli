<script src="<?= base_url("plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
<script src="<?= base_url("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"); ?>"></script>
<script src="<?= base_url("plugins/datatables-responsive/js/dataTables.responsive.min.js"); ?>"></script>
<script src="<?= base_url("plugins/datatables-responsive/js/responsive.bootstrap4.min.js"); ?>"></script>

<script>
  function yazdir(id) {
    teknikServisFormuPencere = window.open('<?= base_url("cihaz/teknik_servis_formu"); ?>/' + id, 'teknikServisFormuPencere' + id, 'status=1');
    $(teknikServisFormuPencere).ready(function() {
      teknikServisFormuPencere.print();
    });
  }
  $(document).ready(function() {
    //window.print();
  });
  $(function() {
    $('#cihaz_tablosu').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "oLanguage": {
        "sSearch": "Ara",
        "sInfo": "Toplam _TOTAL_ cihazdan _START_ ile _END_ arası gösteriliyor.",
        "sInfoEmpty": "0 sonuç gösteriliyor.",
        "sInfoFiltered": "(toplam _MAX_ cihaz içinden)",
        "sZeroRecords": "Aramayla eşleşen cihaz bulunamadı.",
        "oPaginate": {
          "sFirst": "İlk",
          "sPrevious": "Önceki",
          "sLast": "Son",
          "sNext": "Sonraki",
        },
      },
    });
  });
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
        <th scope="col">Detaylar</th>
    </tr>
</thead>
<tbody id="cihazlar">';
$teslim_durumu_1 = 'Teslim Edildi';
$teslim_durumu_renkli_1 = '<span class="text-success">' . $teslim_durumu_1 . '</span>';
$teslim_durumu_0 = 'Teslim Edilmedi';
$teslim_durumu_renkli_0 = '<span class="text-danger">' . $teslim_durumu_0 . '</span>';
$cihazEklendi = false;
$sonCihazID = 0;
$tabloOrnek = '<tr id="cihaz{id}" onClick="$(this).removeClass(\\\'bg-success\\\')" class="{class}">
  <th scope="row">{id}</th>
  <td id="{id}MusteriAdi">{musteri_adi}</td>
  <td  id="{id}CihazTuru"' . ($cihazTuruGizle ? ' style="display:none;"' : '') . '>{cihaz_turu}</td>
  <td id="{id}Cihaz">{cihaz} {cihaz_modeli}</td>
  <td class="text-center">
    <button class="btn btn-info text-white" data-toggle="modal" data-target="#cihazDetayModal{id}">Detaylar</button>
  </td>
</tr>';
$ilkOgeGenislik = "40%";
$ikinciOgeGenislik = "60%";
$dortluIlkOgeGenislik = "40%";
$dortluIkinciOgeGenislik = "20%";
$dortluUcuncuOgeGenislik = "20%";
$dortluDorduncuOgeGenislik = "20%";
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
              <a class="list-group-item list-group-item-action active" id="list-genel-bilgiler-{id}-list" data-toggle="list" href="#list-genel-bilgiler-{id}" role="tab" aria-controls="genel-bilgiler-{id}">Genel Bilgiler</a>
              <a class="list-group-item list-group-item-action" id="list-cihaz-bilgileri-{id}-list" data-toggle="list" href="#list-cihaz-bilgileri-{id}" role="tab" aria-controls="cihaz-bilgileri-{id}">Cihaz Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-teknik-servis-bilgileri-{id}-list" data-toggle="list" href="#list-teknik-servis-bilgileri-{id}" role="tab" aria-controls="teknik-servis-bilgileri-{id}">Teknik Servis Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-aksesuar-bilgileri-{id}-list" data-toggle="list" href="#list-aksesuar-bilgileri-{id}" role="tab" aria-controls="aksesuar-bilgileri-{id}">Aksesuar Bilgileri</a>
              <a class="list-group-item list-group-item-action" id="list-yapilan-islemler-{id}-list" data-toggle="list" href="#list-yapilan-islemler-{id}" role="tab" aria-controls="yapilan-islemler-{id}">Yapılan İşlemler</a>
            </div>
          </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-genel-bilgiler-{id}" role="tabpanel" aria-labelledby="list-genel-bilgiler-{id}-list">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Giriş Tarihi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{tarih}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Teslim Durumu:</span></li>
                  <li id="{id}TeslimDurumu" class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{teslim_edildi}</li>
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
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Hasar Türü:</span></span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{cihazdaki_hasar}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Yapılan Hasar Tespiti:</span></span></li>
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
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">{yapilan_islem_aciklamasi}</li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $dortluIlkOgeGenislik . ';"><span class="font-weight-bold">Malzeme/İşçilik</span></li>
                  <li class="list-group-item" style="width:' . $dortluIkinciOgeGenislik . ';"><span class="font-weight-bold">Miktar</span></li>
                  <li class="list-group-item" style="width:' . $dortluUcuncuOgeGenislik . ';"><span class="font-weight-bold">Birim Fiyatı</span></li>
                  <li class="list-group-item" style="width:' . $dortluDorduncuOgeGenislik . ';"><span class="font-weight-bold">Tutar</span></li>
                </ul>
                <div id="yapilanIslem{id}">
                  {yapilan_islemler}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <a href="#" class="btn {teslim_durumu_class} text-white" data-toggle="modal" data-target="#cihazTeslimEdildiModal{id}"><i class="fas {teslim_durumu_icon}"></i> {teslim_edildi_btn}</a>
      <a href="' . base_url("cihaz") . '/{id}" class="btn btn-primary">Düzenle</a>
      <a href="#" onclick="yazdir({id})" class="btn btn-dark text-white">Yazdır</a>
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
<li class="list-group-item" style="width:' . $dortluIlkOgeGenislik . ';">{islem}</li>
<li class="list-group-item" style="width:' . $dortluIkinciOgeGenislik . ';">{miktar}</li>
<li class="list-group-item" style="width:' . $dortluUcuncuOgeGenislik . ';">{fiyat} TL</li>
<li class="list-group-item" style="width:' . $dortluDorduncuOgeGenislik . ';">{toplam_islem_fiyati} TL</li>
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
$cihazDetayModalOrnek = $this->Islemler_Model->trimle($cihazDetayModalOrnek);
$cihazTeslimEdildiModalOrnek = $this->Islemler_Model->trimle($cihazTeslimEdildiModalOrnek);
$cihazSilModalOrnek = $this->Islemler_Model->trimle($cihazSilModalOrnek);
$this->load->model("Cihazlar_Model");
$cihazlar = $tur_belirtildimi ? $this->Cihazlar_Model->cihazlarTekTur($tur) : $this->Cihazlar_Model->cihazlar();

$eskiler = array(
  "\\",
  "{class}",
  "{id}",
  "{musteri_adi}",
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
  "{tarih}",
  "{yapilan_islemler}",
  "{teslim_edildi_btn}",
  "{teslim_durumu_uyari}",
  "{teslim_durumu_id}",
  "{teslim_durumu_class}",
  "{teslim_durumu_icon}",
);
foreach ($cihazlar as $cihaz) {
  if ($cihazEklendi == false) {
    $sonCihazID = $cihaz->id;
    $cihazEklendi = true;
  }
  $yapilanIslemToplamEskiArray = array(
    "{toplam_aciklama}",
    "{toplam_fiyat}",
  );
  $yapilanIslemEskiArray = array(
    "{islem}",
    "{miktar}",
    "{fiyat}",
    "{toplam_islem_fiyati}",
  );
  $yapilanİslemler = "";
  $yapilanIslemlerModel = $this->Cihazlar_Model->yapilanIslemler($cihaz->id);
  $toplam_fiyat = 0;
  if ($yapilanIslemlerModel->num_rows() > 0) {
    foreach ($yapilanIslemlerModel->result() as $yapilanIslemModel) {
      $toplam_islem_fiyati = $yapilanIslemModel->birim_fiyati * $yapilanIslemModel->miktar;
      $yapilanIslemYeniArray = array(
        $yapilanIslemModel->islem,
        $yapilanIslemModel->miktar,
        $yapilanIslemModel->birim_fiyati,
        $toplam_islem_fiyati,
      );
      $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati;
      $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray, $yapilanIslemlerSatiri);
    }
  } else {
    $yapilanİslemler = $yapilanIslemlerSatiriBos;
  }
  $yapilanIslemToplamYeni = array(
    "Toplam",
    $toplam_fiyat,
  );
  $kdv = $toplam_fiyat * 0.18;
  $yapilanIslemToplamKDVYeni = array(
    "KDV (%18)",
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
    $cihaz->tarih,
    $yapilanİslemler,
    $cihaz->teslim_edildi == 1 ? $teslim_durumu_0 : $teslim_durumu_1,
    $cihaz->teslim_edildi == 1 ? "Bu cihazı teslim edilmedi olarak işaretlemek istediğinize emin misiniz?" : "Bu cihazı teslim edildi olarak işaretlemek istediğinize emin misiniz?",
    $cihaz->teslim_edildi == 1 ? 0 : 1,
    $cihaz->teslim_edildi == 1 ? "btn-danger" : "btn-success",
    $cihaz->teslim_edildi == 1 ? "fa-times" : "fa-check",
  );
  $tablo = str_replace($eskiler, $yeniler, $tabloOrnek);
  $cihazTeslimEdildiModal = str_replace($eskiler, $yeniler, $cihazTeslimEdildiModalOrnek);
  $cihazSilModal = str_replace($eskiler, $yeniler, $cihazSilModalOrnek);
  $cihazDetayModal = str_replace($eskiler, $yeniler, $cihazDetayModalOrnek);
  echo $tablo . $cihazDetayModal . $cihazSilModal  . $cihazTeslimEdildiModal;
  $this->load->view("icerikler/yapilan_islemler_js", array(
    "id" => $cihaz->id,
    "yapilanIslemlerSatiri" => $yapilanIslemlerSatiri,
    "yapilanIslemlerSatiriBos" => $yapilanIslemlerSatiriBos,
    "yapilanIslemToplam" => $yapilanIslemToplam,
  ));
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
  <?php
  $yapilanIslemToplamYeni2 = array(
    "Toplam",
    "0",
  );
  $yapilanIslemToplamKDVYeni2 = array(
    "KDV (%18)",
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

  function hasarDurumu(id) {
    switch (id) {
      case 1:
        return '<?= $this->Islemler_Model->hasarDurumu(1); ?>';
      case 2:
        return '<?= $this->Islemler_Model->hasarDurumu(2); ?>';
      case 3:
        return '<?= $this->Islemler_Model->hasarDurumu(3); ?>';
      default:
        return '<?= $this->Islemler_Model->hasarDurumu(1); ?>'
    }
  }

  function evetHayir(id) {
    switch (id) {
      case 1:
        return '<?= $this->Islemler_Model->evetHayir(1); ?>';
      case 0:
        return '<?= $this->Islemler_Model->evetHayir(0); ?>';

      default:
        return '<?= $this->Islemler_Model->evetHayir(0); ?>'
    }
  }

  function cihazdakiHasar(id) {
    switch (id) {
      case 1:
        return '<?= $this->Islemler_Model->cihazdakiHasar(1); ?>';
      case 2:
        return '<?= $this->Islemler_Model->cihazdakiHasar(2); ?>';
      case 3:
        return '<?= $this->Islemler_Model->cihazdakiHasar(3); ?>';
      case 4:
        return '<?= $this->Islemler_Model->cihazdakiHasar(4); ?>';
      default:
        return '<?= $this->Islemler_Model->cihazdakiHasar(0); ?>';
    }
  }

  function donustur(str, value) {
    return str.
    replaceAll("{class}", "bg-success")
      .replaceAll("{id}", value.id)
      .replaceAll("{musteri_adi}", value.musteri_adi)
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
      .replaceAll("{tarih}", value.tarih)
      .replaceAll("{yapilan_islemler}", '<?= $yapilanIslemlerSatiriBos . $toplam2 . $kdv2 . $genel_toplam2; ?>')
      .replaceAll("{teslim_edildi_btn}", value.teslim_edildi == 1 ? '<?= $teslim_durumu_0; ?>' : '<?= $teslim_durumu_1; ?>')
      .replaceAll("{teslim_durumu_uyari}", value.teslim_edildi == 1 ? "Bu cihazı teslim edilmedi olarak işaretlemek istediğinize emin misiniz?" : "Bu cihazı teslim edildi olarak işaretlemek istediğinize emin misiniz?")
      .replaceAll("{teslim_durumu_id}", value.teslim_edildi == 1 ? 0 : 1)
      .replaceAll("{teslim_durumu_class}", value.teslim_edildi == 1 ? "btn-danger" : "btn-success")
      .replaceAll("{teslim_durumu_icon}", value.teslim_edildi == 1 ? "fa-times" : "fa-check");
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
        $("#" + value.id + "TeslimDurumu").html(value.teslim_edildi == 1 ? '<?= $teslim_durumu_renkli_1; ?>' : '<?= $teslim_durumu_renkli_0; ?>');
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
        let detayModalOrnek = '<?= $cihazDetayModalOrnek; ?>';
        let cihazTeslimEdildiModalOrnek = '<?= $cihazTeslimEdildiModalOrnek; ?>';
        let silModalOrnek = '<?= $cihazSilModalOrnek; ?>';

        var tablo = donustur(tabloOrnek, value);
        var detayModal = donustur(detayModalOrnek, value);
        var cihazTeslimEdildiModal = donustur(cihazTeslimEdildiModalOrnek, value);
        var silmodal = donustur(silModalOrnek, value);
        $("#cihazlar").prepend(tablo);
        $.post('<?= base_url("cihazlar/yapilanIslemlerJS"); ?>/' + value.id, {
          "yapilanIslemlerSatiri": '<?= $yapilanIslemlerSatiri; ?>',
          "yapilanIslemlerSatiriBos": '<?= $yapilanIslemlerSatiriBos; ?>',
          "yapilanIslemToplam": '<?= $yapilanIslemToplam; ?>',
        }, function(data) {
          $("#cihazTablosu").prepend(data);
        });
        $("#cihazTablosu").prepend(cihazTeslimEdildiModal);
        $("#cihazTablosu").prepend(silmodal);
        $("#cihazTablosu").prepend(detayModal);
      });
    });
  }, 5000);
</script>