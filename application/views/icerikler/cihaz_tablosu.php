<?php $this->load->view("inc/datatables_scripts");
echo '<style>
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
';
$this->load->view("inc/style_tablo");

$sorumlu_belirtildimi = isset($suankiPersonel) ? true : false;
$silButonuGizle = isset($silButonuGizle) ? $silButonuGizle : false;

$cihazDetayBtnOnclick = 'detayModaliGoster(\\\'{id}\\\',\\\'{servis_no}\\\',\\\'{takip_no}\\\',\\\'{musteri_kod}\\\',\\\'{musteri_adi_onclick}\\\',\\\'{adres_onclick}\\\',\\\'{telefon_numarasi}\\\',\\\'{tarih}\\\',\\\'{bildirim_tarihi}\\\',\\\'{cikis_tarihi}\\\',\\\'{guncel_durum_onclick}\\\',\\\'{guncel_durum_sayi}\\\',\\\'{cihaz_turu_onclick}\\\',\\\'{cihaz_onclick}\\\',\\\'{cihaz_modeli_onclick}\\\',\\\'{seri_no_onclick}\\\',\\\'{teslim_alinanlar_onclick}\\\',\\\'{cihaz_sifresi_onclick}\\\',\\\'{cihazdaki_hasar_onclick}\\\',\\\'{hasar_tespiti_onclick}\\\',\\\'{ariza_aciklamasi_onclick}\\\',\\\'{servis_turu_onclick}\\\',\\\'{yedek_durumu}\\\',\\\'{sorumlu_onclick}\\\',\\\'{yapilan_islem_aciklamasi_onclick}\\\',\\\'{tahsilat_sekli_onclick}\\\',\\\'{fatura_durumu_onclick}\\\',\\\'{fis_no_onclick}\\\')';
$cihazDetayBtnOnclick = $this->Islemler_Model->trimle($cihazDetayBtnOnclick);

echo '<script>
  var suankiCihaz = 0;
  var yonetici = '.($this->Kullanicilar_Model->yonetici() ? "true" : "false").';
  function butonDurumu(guncel_durum){
    if(guncel_durum < ' . (count($this->Islemler_Model->cihazDurumu) - 1) . ' || yonetici){      
      $("#duzenleBtn").show();
      $("#silBtn").show();
    }else{
      $("#duzenleBtn").hide();
      $("#silBtn").hide();
    }
  }
  function medyalariYukle(id) {
    $.post("' . base_url("medyalar") . '/" + id, {}, function(data) {
      $("#list-medyalar").html(data);
    });
  }
  function silModaliGoster(id, servis_no, musteri_adi){
    $("#silOnayBtn").attr("href", "' . base_url(($sorumlu_belirtildimi ? "cihazlarim" : "cihazyonetimi") . "/cihazSil") . '/" + id);

    $("#ServisNo4").html(servis_no);
    $("#MusteriAdi3").html(musteri_adi);

    $("#cihaziSilModal").modal("show");
  }
  function detayModaliGoster(id, servis_no, takip_no, musteri_kod, musteri_adi, adres, telefon_numarasi, tarih, bildirim_tarihi, cikis_tarihi, guncel_durum, guncel_durum_sayi, cihaz_turu, cihaz, cihaz_modeli, seri_no, teslim_alinanlar, cihaz_sifresi, cihazdaki_hasar, hasar_tespiti, ariza_aciklamasi, servis_turu, yedek_durumu, sorumlu, yapilan_islem_aciklamasi, tahsilat_sekli, fatura_durumu, fis_no) {
    /*<button id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Btn{id}" class="btn btn-info text-white" onClick="' . $cihazDetayBtnOnclick . '">Detaylar</button>*/
    suankiCihaz = id;
    butonDurumu(guncel_durum_sayi);

    $("#ServisNo2, #ServisNo3").html(servis_no);
    $("#TakipNo").html(takip_no);
    $("#MusteriKod").html(musteri_kod);
    $("#MusteriAdi2").html(musteri_adi);
    $("#MusteriAdres").html(adres);
    $("#MusteriGSM2").html(telefon_numarasi);
    $("#Tarih").html(tarih);
    $("#BildirimTarihi").html(bildirim_tarihi);
    $("#CikisTarihi").html(cikis_tarihi);
    $("#GuncelDurum2").html(guncel_durum);

    $("#CihazTuru2").html(cihaz_turu);
    $("#CihazMarka").html(cihaz);
    $("#CihazModeli").html(cihaz_modeli);
    $("#SeriNo").html(seri_no);
    $("#TeslimAlinanlar").html(teslim_alinanlar);
    $("#CihazSifresi").html(cihaz_sifresi);

    $("#CihazdakiHasar").html(cihazdaki_hasar);
    $("#HasarTespiti").html(hasar_tespiti);
    $("#ArizaAciklamasi").html(ariza_aciklamasi);
    $("#ServisTuru").html(servis_turu);
    $("#YedekDurumu").html(yedek_durumu);

    $("#Sorumlu2").html(sorumlu);
    $("#yapilanIslemAciklamasi").html(yapilan_islem_aciklamasi);
    $("#TahsilatSekli").html(tahsilat_sekli);
    $("#faturaDurumu").html(fatura_durumu);
    $("#fisNo").html(fis_no);

    $("#duzenleBtn").attr("href", "' . base_url("cihaz") . '/" + id);
    $("#serviskabulBtn").attr("onclick", "servisKabulYazdir(" + id + ")");
    $("#barkoduYazdirBtn").attr("onclick", "barkoduYazdir(" + id + ")");
    $("#formuYazdirBtn").attr("onclick", "formuYazdir(" + id + ")");
    $("#silBtn").attr("onclick", "silModaliGoster(\'" + id + "\',\'" + servis_no + "\',\'" + musteri_adi + "\')");



    $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").modal("show");

    cihazBilgileriniGetir();
  }
</script>';
echo '<div id="cihazTablosu" class="table-responsive">';
echo '<table id="cihaz_tablosu" class="table table-bordered mt-2">
<thead>
    <tr>
        <th scope="col">Servis No</th>
        <th scope="col">Müşteri Adı</th>
        <th scope="col">GSM</th>
        <th scope="col">Tür</th>
        <th scope="col">Cihaz</th>
        <th scope="col">Giriş Tarihi</th>
        <th scope="col">Güncel Durum</th>
        <th scope="col">Sorumlu Personel</th>
        <th scope="col">Detaylar</th>
    </tr>
</thead>
<tbody id="cihazlar">';
$sonCihazID = 0;

$tabloOrnek = '<tr id="cihaz{id}" class="{class}" onClick="$(\\\'#{id}Yeni\\\').remove()">
  <th scope="row" id="{id}ServisNo">{servis_no}</th>
  <td><span id="{id}MusteriAdi">{musteri_adi}</span>{yeni}</td>
  <td id="{id}MusteriGSM">{telefon_numarasi}</td>
  <td id="{id}CihazTuru">{cihaz_turu}</td>
  <td id="{id}Cihaz">{cihaz} {cihaz_modeli}</td>
  <td id="{id}Tarih2">{tarih2}</td>
  <td id="{id}GuncelDurum">{guncel_durum}</td>
  <td id="{id}Sorumlu">{sorumlu}</td>
  <td class="text-center">
    <button id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Btn{id}" class="btn btn-info text-white" onClick="' . $cihazDetayBtnOnclick . '">Detaylar</button>
  </td>
</tr>';
$ilkOgeGenislik = "40%";
$ikinciOgeGenislik = "60%";
$besliIlkOgeGenislik = "40%";
$besliIkinciOgeGenislik = "10%";
$besliUcuncuOgeGenislik = "10%";
$besliDorduncuOgeGenislik = "20%";
$besliBesinciOgeGenislik = "20%";
$cihazDetayOrnek = '
<script>
$(document).ready(function(){
  $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").on("hide.bs.modal", function(e) {
    history.replaceState("", document.title, window.location.pathname);
  });
});
</script>
<div class="modal modal-fullscreen fade" id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . '" tabindex="-1" role="dialog" aria-labelledby="' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Label">Cihaz Detayları <span id="ServisNo3"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-genel-bilgiler" role="tabpanel" aria-labelledby="list-genel-bilgiler-list">
                <!-- Genel Bilgiler -->
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:100%;"><h3>Genel Bilgiler</h3></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Servis No:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="ServisNo2"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Takip No:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="TakipNo"></li>
                </ul>
                <!--<ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Müşteri Kodu:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="MusteriKod"></li>
                </ul>-->
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Müşteri Adı:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="MusteriAdi2"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Adresi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="MusteriAdres"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">GSM:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="MusteriGSM2"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Giriş Tarihi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="Tarih"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Bildirim Tarihi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="BildirimTarihi"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Çıkış Tarihi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';"><span id="CikisTarihi"></span></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Güncel Durum:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="GuncelDurum2"></li>
                </ul>
                <!-- Cihaz Bilgileri -->
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:100%;"><h3>Cihaz Bilgileri</h3></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Cihaz Türü:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="CihazTuru2"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Markası:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="CihazMarka"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Modeli:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="CihazModeli"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Seri No:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="SeriNo"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Teslim Alınanlar:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="TeslimAlinanlar"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Cihaz Şifresi:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="CihazSifresi"></li>
                </ul>
                <!-- Teknik Servis Bilgileri -->
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:100%;"><h3>Teknik Servis Bilgileri</h3></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Teslim Alınmadan Önce Belirlenen Hasar Türü:</span></span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="CihazdakiHasar"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Teslim Alınmadan Önce Yapılan Hasar Tespiti:</span></span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="HasarTespiti"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold"><span class="font-weight-bold">Arıza Açıklaması:</span></span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="ArizaAciklamasi"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Servis Türü:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="ServisTuru"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Yedek Alınacak mı?:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="YedekDurumu"></li>
                </ul>
                <!-- Yapılan İşlemler -->
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:100%;"><h3>Yapılan İşlemler</h3></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Sorumlu Personel:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="Sorumlu2"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Yapılan İşlem Açıklaması:</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="yapilanIslemAciklamasi"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $besliIlkOgeGenislik . ';"><span class="font-weight-bold">Malzeme/İşçilik</span></li>
                  <li class="list-group-item" style="width:' . $besliIkinciOgeGenislik . ';"><span class="font-weight-bold">Miktar</span></li>
                  <li class="list-group-item" style="width:' . $besliUcuncuOgeGenislik . ';"><span class="font-weight-bold">Birim Fiyatı</span></li>
                  <li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';"><span class="font-weight-bold">Tutar</span></li>
                  <li class="list-group-item" style="width:' . $besliBesinciOgeGenislik . ';"><span class="font-weight-bold">KDV</span></li>
                </ul>
                <div id="yapilanIslem">
                  
                </div>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Tahsilat Şekli</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="TahsilatSekli"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Fatura Durumu</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="faturaDurumu"></li>
                </ul>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Fiş No</span></li>
                  <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="fisNo"></li>
                </ul>
                <!-- Medyalar -->
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item" style="width:100%;"><h3>Medyalar</h3></li>
                </ul>
                
                <ul class="list-group list-group-horizontal">
                  <li id="list-medyalar" class="list-group-item" style="width:100%;"></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <a id="duzenleBtn" href="#" style="{display_kilit}" class="btn btn-primary">Düzenle</a>
      <a id="serviskabulBtn" href="#" class="btn btn-dark text-white">Servis Kabul Formunu Yazdır</a>
      <a id="barkoduYazdirBtn" href="#" class="btn btn-dark text-white">Barkodu Yazdır</a>
      <a id="formuYazdirBtn" href="#" class="btn btn-dark text-white">Formu Yazdır</a>
      ' . ($silButonuGizle ? '' : '<a id="silBtn" href="#" style="{display_kilit}" class="btn btn-danger text-white">Sil</a>') . '
      <a href="#" class="btn btn-secondary" data-dismiss="modal">Kapat</a>
      </div>
    </div>
  </div>
</div>';

$cihazSilModalOrnek = $silButonuGizle ? '' : '<div class="modal fade" id="cihaziSilModal" tabindex="-1" role="dialog" aria-labelledby="cihaziSilModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cihaziSilModalLabel">Cihaz Silme İşlemini Onaylayın</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Bu cihazı (<span id="ServisNo4"></span> - <span id="MusteriAdi3"></span>) silmek istediğinize emin misiniz?
      </div>
      <div class="modal-footer">
        <a id="silOnayBtn" href="#" class="btn btn-success">Evet</a>
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
$cihazSilModalOrnek = $this->Islemler_Model->trimle($cihazSilModalOrnek);
$this->load->model("Cihazlar_Model");
$cihazlar = $sorumlu_belirtildimi ? $this->Cihazlar_Model->cihazlarTekPersonel($suankiPersonel) : $this->Cihazlar_Model->cihazlar();

$eskiler = array(
  "\\",
  "{yeni}",
  "{class}",
  "{display_kilit}",
  "{servis_no}",
  "{takip_no}",
  "{id}",
  "{musteri_adi}",
  "{musteri_kod}",
  "{adres}",
  "{telefon_numarasi}",
  "{cihaz_turu}",
  "{sorumlu}",
  "{cihaz}",
  "{cihaz_modeli}",
  "{seri_no}",
  "{teslim_alinanlar}",
  "{cihaz_sifresi}",
  "{hasar_tespiti}",
  "{cihazdaki_hasar}",
  "{ariza_aciklamasi}",
  "{servis_turu}",
  "{yedek_durumu}",
  "{yapilan_islem_aciklamasi}",
  "{tarih}",
  "{tarih2}",
  "{bildirim_tarihi}",
  "{cikis_tarihi}",
  "{guncel_durum}",
  "{guncel_durum_sayi}",
  "{tahsilat_sekli}",
  "{fatura_durumu}",
  "{fis_no}",
  "{yapilan_islemler}",
  "{musteri_adi_onclick}",
  "{adres_onclick}",
  "{guncel_durum_onclick}",
  "{cihaz_turu_onclick}",
  "{cihaz_onclick}",
  "{cihaz_modeli_onclick}",
  "{teslim_alinanlar_onclick}",
  "{cihaz_sifresi_onclick}",
  "{cihazdaki_hasar_onclick}",
  "{hasar_tespiti_onclick}",
  "{ariza_aciklamasi_onclick}",
  "{servis_turu_onclick}",
  "{sorumlu_onclick}",
  "{yapilan_islem_aciklamasi_onclick}",
  "{tahsilat_sekli_onclick}",
  "{fatura_durumu_onclick}",
  "{fis_no_onclick}"
);

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
function donusturOnclick($oge)
{
  return str_replace("'","\'",trim(preg_replace('/\s\s+/', '<br>', $oge)));
}
$sayac = 0;
foreach ($cihazlar as $cihaz) {
  if ($sayac == 0) {
    $sonCihazID = $cihaz->id;
  }
  $sayac++;
  $yapilanİslemler = "";
  $toplam_fiyat = 0;
  $kdv = 0;
  if (count($cihaz->islemler) > 0) {
    foreach($cihaz->islemler as $islem){
      $toplam_islem_fiyati_suan = $islem->birim_fiyat * $islem->miktar;
      $kdv_suan = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_suan / 100) * $islem->kdv);
      $yapilanIslemYeniArray_suan = array(
        $islem->ad,
        $islem->kdv,
        $islem->birim_fiyat,
        $toplam_islem_fiyati_suan,
        $kdv_suan,
        $islem->kdv
      );
      $toplam_fiyat = $toplam_fiyat + $toplam_islem_fiyati_suan;
      $kdv = $kdv + $kdv_suan;
      $yapilanİslemler .= str_replace($yapilanIslemEskiArray, $yapilanIslemYeniArray_suan, $yapilanIslemlerSatiri);
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
  $yeniler = array(
    "",
    "",
    $this->Islemler_Model->cihazDurumuClass($cihaz->guncel_durum),
    (($cihaz->guncel_durum == count($this->Islemler_Model->cihazDurumu) - 1) && !$this->Kullanicilar_Model->yonetici()) ? "display:none;" : "",
    $cihaz->servis_no,
    $cihaz->takip_numarasi,
    $cihaz->id,
    $cihaz->musteri_adi,
    isset($cihaz->musteri_kod) ? $cihaz->musteri_kod : "Yok",
    $cihaz->adres,
    $cihaz->telefon_numarasi,
    $cihaz->cihaz_turu,
    $cihaz->sorumlu,
    $cihaz->cihaz,
    $cihaz->cihaz_modeli,
    $cihaz->seri_no,
    $cihaz->teslim_alinanlar,
    $cihaz->cihaz_sifresi,
    $cihaz->hasar_tespiti,
    $this->Islemler_Model->cihazdakiHasar($cihaz->cihazdaki_hasar),
    $cihaz->ariza_aciklamasi,
    $this->Islemler_Model->servisTuru($cihaz->servis_turu),
    $this->Islemler_Model->evetHayir($cihaz->yedek_durumu),
    $cihaz->yapilan_islem_aciklamasi,
    $cihaz->tarih,
    $this->Islemler_Model->tarihDonusturSiralama($cihaz->tarih),
    $cihaz->bildirim_tarihi,
    $cihaz->cikis_tarihi,
    $this->Islemler_Model->cihazDurumu($cihaz->guncel_durum),
    $cihaz->guncel_durum,
    $this->Islemler_Model->tahsilatSekli($cihaz->tahsilat_sekli),
    $this->Islemler_Model->faturaDurumu($cihaz->fatura_durumu),
    $cihaz->fis_no,
    $yapilanİslemler,
    donusturOnclick($cihaz->musteri_adi),
    donusturOnclick($cihaz->adres),
    donusturOnclick($this->Islemler_Model->cihazDurumu($cihaz->guncel_durum)),
    donusturOnclick($cihaz->cihaz_turu),
    donusturOnclick($cihaz->cihaz),
    donusturOnclick($cihaz->cihaz_modeli),
    donusturOnclick($cihaz->teslim_alinanlar),
    donusturOnclick($cihaz->cihaz_sifresi),
    donusturOnclick($this->Islemler_Model->cihazdakiHasar($cihaz->cihazdaki_hasar)),
    donusturOnclick($cihaz->hasar_tespiti),
    donusturOnclick($cihaz->ariza_aciklamasi),
    donusturOnclick($this->Islemler_Model->servisTuru($cihaz->servis_turu)),
    donusturOnclick($cihaz->sorumlu),
    donusturOnclick($cihaz->yapilan_islem_aciklamasi),
    donusturOnclick($this->Islemler_Model->tahsilatSekli($cihaz->tahsilat_sekli)),
    donusturOnclick($this->Islemler_Model->faturaDurumu($cihaz->fatura_durumu)),
    donusturOnclick($cihaz->fis_no)
  );
  $tablo = str_replace($eskiler, $yeniler, $tabloOrnek);
  echo $tablo;
}
echo '
</tbody>
</table>';
echo '</div>';

echo '<script type="text/javascript">
  let sonCihazID = ' . $sonCihazID . ';';

$yapilanIslemToplamYeni2 = array(
  "Toplam",
  "0"
);
$yapilanIslemToplamKDVYeni2 = array(
  "KDV",
  "0"
);
$yapilanIslemGenelToplamYeni2  = array(
  "Genel Toplam",
  "0"
);
$toplam2 = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamYeni2, $yapilanIslemToplam);
$kdv2 = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemToplamKDVYeni2, $yapilanIslemToplam);
$genel_toplam2 = str_replace($yapilanIslemToplamEskiArray, $yapilanIslemGenelToplamYeni2, $yapilanIslemToplam);


echo '
  function servisTuru(id) {
    id = parseInt(id);
    switch (id) {
      case 1:
        return \'' . $this->Islemler_Model->servisTuru(1) . '\';
      case 2:
        return \'' . $this->Islemler_Model->servisTuru(2) . '\';
      case 3:
        return \'' . $this->Islemler_Model->servisTuru(3) . '\';
      case 4:
        return \'' . $this->Islemler_Model->servisTuru(4) . '\';
      default:
        return \'' . $this->Islemler_Model->servisTuru(3) . '\'
    }
  }';
echo '
  function hasarDurumu(id) {
    id = parseInt(id);
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

echo '
  function evetHayir(id) {
    id = parseInt(id);
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

echo '
  function cihazdakiHasar(id) {
    id = parseInt(id);
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

echo '
  function cihazDurumu(id) {
    id = parseInt(id);
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
  echo '
      function tahsilatSekli(id) {
        id = parseInt(id);
        switch (id) {';
  for ($i = 0; $i < count($this->Islemler_Model->tahsilatSekli); $i++) {
    echo '
          case ' . $i . ':
            return "' . $this->Islemler_Model->tahsilatSekli[$i] . '";';
  }
  echo '
          default:
            return "' . $this->Islemler_Model->tahsilatSekli[0] . '";
        }
      }';
      echo '
          function faturaDurumu(id) {
            id = parseInt(id);
            switch (id) {';
      for ($i = 0; $i < count($this->Islemler_Model->faturaDurumu); $i++) {
        echo '
              case ' . $i . ':
                return "' . $this->Islemler_Model->faturaDurumu[$i] . '";';
      }
      echo '
              default:
                return "' . $this->Islemler_Model->faturaDurumu[0] . '";
            }
          }';

echo '
  function cihazDurumuClass(id) {
    id = parseInt(id);
    switch (id) {';
for ($i = 0; $i < count($this->Islemler_Model->cihazDurumuClass); $i++) {
  echo '
      case ' . $i . ':
        return "' . $this->Islemler_Model->cihazDurumuClass[$i] . '";';
}
echo '
      default:
        return "' . $this->Islemler_Model->cihazDurumuClass[0] . '";
    }
  }';


echo 'function tarihDonusturSiralama(tarih) {
    var gun = tarih.slice(0, 2);
    var ay = tarih.slice(3, 5);
    var yil = tarih.slice(6, 10);
    var saat = tarih.slice(11, 16);
    return gun + "." + ay + "." + yil + " " + saat ;
  }';

echo '
function donusturOnclick(oge){
  if(oge){
    return oge.replaceAll(/(?:\r\n|\r|\n)/g, "<br>").replaceAll("\'", "\\\\\'");
  }else{
    return "";
  }
}
function donustur(str, value) {
    return str.
    replaceAll("{yeni}", \' <span id="\' + value.id + \'Yeni" class="badge badge-danger">Yeni</span>\')
      .replaceAll("{class}", cihazDurumuClass(value.guncel_durum))
      .replaceAll("{display_kilit}", value.guncel_durum == ' . (count($this->Islemler_Model->cihazDurumu) - 1) . ' ? "display:none;" : "")
      .replaceAll("{servis_no}", value.servis_no)
      .replaceAll("{id}", value.id)
      .replaceAll("{musteri_adi}", value.musteri_adi)
      .replaceAll("{musteri_kod}", value.musteri_kod ? value.musteri_kod : "Yok")
      .replaceAll("{adres}", value.adres)
      .replaceAll("{telefon_numarasi}", value.telefon_numarasi)
      .replaceAll("{cihaz_turu}", value.cihaz_turu)
      .replaceAll("{sorumlu}", value.sorumlu)
      .replaceAll("{cihaz}", value.cihaz)
      .replaceAll("{cihaz_modeli}", value.cihaz_modeli)
      .replaceAll("{seri_no}", value.seri_no)
      .replaceAll("{teslim_alinanlar}", value.teslim_alinanlar)
      .replaceAll("{cihaz_sifresi}", value.cihaz_sifresi)
      .replaceAll("{hasar_tespiti}", value.hasar_tespiti)
      .replaceAll("{cihazdaki_hasar}", cihazdakiHasar(value.cihazdaki_hasar))
      .replaceAll("{ariza_aciklamasi}", value.ariza_aciklamasi)
      .replaceAll("{servis_turu}", servisTuru(value.servis_turu))
      .replaceAll("{yedek_durumu}", evetHayir(value.yedek_durumu))
      .replaceAll("{yapilan_islem_aciklamasi}", value.yapilan_islem_aciklamasi)
      .replaceAll("{tarih}", value.tarih)
      .replaceAll("{tarih2}", tarihDonusturSiralama(value.tarih))
      .replaceAll("{bildirim_tarihi}", value.bildirim_tarihi)
      .replaceAll("{cikis_tarihi}", value.cikis_tarihi)
      .replaceAll("{guncel_durum}", cihazDurumu(value.guncel_durum))
      .replaceAll("{guncel_durum_sayi}", value.guncel_durum)
      .replaceAll("{tahsilat_sekli}", tahsilatSekli(value.tahsilat_sekli))
      .replaceAll("{fatura_durumu}", faturaDurumu(value.fatura_durumu))
      .replaceAll("{fis_no}", value.fis_no)
      .replaceAll("{yapilan_islemler}", \'' . $yapilanIslemlerSatiriBos . $toplam2 . $kdv2 . $genel_toplam2 . '\')
      .replaceAll("{musteri_adi_onclick}", donusturOnclick(value.musteri_adi))
      .replaceAll("{adres_onclick}", donusturOnclick(value.adres))
      .replaceAll("{guncel_durum_onclick}", donusturOnclick(cihazDurumu(value.guncel_durum)))
      .replaceAll("{cihaz_turu_onclick}", donusturOnclick(value.cihaz_turu))
      .replaceAll("{cihaz_onclick}", donusturOnclick(value.cihaz))
      .replaceAll("{cihaz_modeli_onclick}", donusturOnclick(value.cihaz_modeli))
      .replaceAll("{teslim_alinanlar_onclick}", donusturOnclick(value.teslim_alinanlar))
      .replaceAll("{cihaz_sifresi_onclick}", donusturOnclick(value.cihaz_sifresi))
      .replaceAll("{cihazdaki_hasar_onclick}", donusturOnclick(cihazdakiHasar(value.cihazdaki_hasar)))
      .replaceAll("{hasar_tespiti_onclick}", donusturOnclick(value.hasar_tespiti))
      .replaceAll("{ariza_aciklamasi_onclick}", donusturOnclick(value.ariza_aciklamasi))
      .replaceAll("{servis_turu_onclick}", donusturOnclick(servisTuru(value.servis_turu)))
      .replaceAll("{sorumlu_onclick}", donusturOnclick(value.sorumlu))
      .replaceAll("{yapilan_islem_aciklamasi_onclick}", donusturOnclick(value.yapilan_islem_aciklamasi))
      .replaceAll("{tahsilat_sekli_onclick}", donusturOnclick(tahsilatSekli(value.tahsilat_sekli)))
      .replaceAll("{fatura_durumu_onclick}", donusturOnclick(faturaDurumu(value.fatura_durumu)))
      .replaceAll("{fis_no_onclick}", donusturOnclick(value.fis_no))
      ;
  }';
echo 'function tarihiFormatla(tarih12){
  return (tarih12 < 10) ? "0" + tarih12 : tarih12;
}';
echo 'function cihazBilgileriniGetir(){
  if(suankiCihaz > 0){
    $.get(\'' . base_url("cihazyonetimi/tekCihazJQ") . '/\' + suankiCihaz + \'\', {}, function(data) {
      $.each(JSON.parse(data), function(index, value) {
        const cihazVarmi = document.querySelectorAll(
          "#cihaz" + value.id
        ).length > 0;
        if (cihazVarmi) {
          butonDurumu(value.guncel_durum);
          var toplam = 0;
          var kdv = 0;
          var yapilanIslemler = "";
          var islemlerSatiri = \'' . $yapilanIslemlerSatiri . '\';
          var islemlerSatiriBos = \'' . $yapilanIslemlerSatiriBos . '\';
          if(Object.keys(value.islemler).length > 0){
            jQuery.each(value.islemler, function(i, islem) {
              var yapilan_islem_tutari_suan = islem.birim_fiyat * islem.miktar;
              toplam = toplam + yapilan_islem_tutari_suan;
              var kdv_suan = ((yapilan_islem_tutari_suan / 100) * islem.kdv);
              kdv = kdv + kdv_suan;
              yapilanIslemler += islemlerSatiri
                .replaceAll("{islem}", islem.ad)
                .replaceAll("{miktar}", islem.miktar)
                .replaceAll("{fiyat}", islem.birim_fiyat)
                .replaceAll("{toplam_islem_fiyati}", yapilan_islem_tutari_suan)
                .replaceAll("{toplam_islem_kdv}", parseFloat(kdv_suan).toFixed(2))
                .replaceAll("{kdv_orani}", islem.kdv);
            });
          } else {
            var yapilanIslemler = islemlerSatiriBos;
          }
          var yapilanIslemToplam = \'' . $yapilanIslemToplam . '\';
          var toplamDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "Toplam").replaceAll("{toplam_fiyat}", parseFloat(toplam).toFixed(2));
          var kdvDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "KDV").replaceAll("{toplam_fiyat}", parseFloat(kdv).toFixed(2));
          var genelToplamDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "Genel Toplam").replaceAll("{toplam_fiyat}", parseFloat(toplam + kdv).toFixed(2));
          yapilanIslemler += toplamDiv + kdvDiv + genelToplamDiv;
          $("#yapilanIslem").html(yapilanIslemler);
          $("#ServisNo2").html(value.servis_no);
          $("#TakipNo").html(value.takip_numarasi);
          $("#MusteriKod").html(value.musteri_kod ? value.musteri_kod : "Yok");
          $("#MusteriAdi2").html(value.musteri_adi);
          $("#MusteriAdres").html(value.adres);
          $("#MusteriGSM2").html(value.telefon_numarasi);
          $("#Tarih").html(value.tarih);
          $("#BildirimTarihi").html(value.bildirim_tarihi);
          $("#CikisTarihi").html(value.cikis_tarihi);
          $("#GuncelDurum2").html(cihazDurumu(value.guncel_durum));
          $("#CihazTuru2").html(value.cihaz_turu);
          $("#CihazMarka").html(value.cihaz);
          $("#CihazModeli").html(value.cihaz_modeli);
          $("#SeriNo").html(value.seri_no);
          $("#TeslimAlinanlar").html(value.teslim_alinanlar);
          $("#CihazSifresi").html(value.cihaz_sifresi);
          $("#CihazdakiHasar").html(cihazdakiHasar(value.cihazdaki_hasar));
          $("#HasarTespiti").html(value.hasar_tespiti);
          $("#ArizaAciklamasi").html(value.ariza_aciklamasi);
          $("#ServisTuru").html(servisTuru(value.servis_turu));
          $("#YedekDurumu").html(evetHayir(value.yedek_durumu));
          $("#Sorumlu2").html(value.sorumlu);
          $("#yapilanIslemAciklamasi").html(value.yapilan_islem_aciklamasi);
          $("#TahsilatSekli").html(tahsilatSekli(value.tahsilat_sekli));
          $("#faturaDurumu").html(faturaDurumu(value.fatura_durumu));
          $("#fisNo").html(value.fis_no);
          medyalariYukle(value.id);
        }
      });
    }); 
  }
}';
echo '$(document).ready(function() {
    var tabloDiv = "#cihaz_tablosu";
    var cihazDurumuSiralama = [ 
      ';
for ($i = 0; $i < count($this->Islemler_Model->cihazDurumu); $i++) {
  echo '"' . $this->Islemler_Model->cihazDurumu[$i] . '"';
  if ($i < count($this->Islemler_Model->cihazDurumu) - 1) {
    echo ',';
  }
}
echo '
    ];
    $.fn.dataTable.ext.type.detect.unshift( function ( data ) {
      if (typeof data !== "undefined") {
          if ( data != null )  {
              var i=0;
              while ( cihazDurumuSiralama[i] ) {
                  if ( isNaN(data) ) {
                      if ( data.search( cihazDurumuSiralama[i] ) > -1 )   {
                          return "priority";
                      }
                  }
                  i++;
              }
          }
      }
      return null;
    });
    $.extend( $.fn.dataTable.ext.type.order, {
      "priority-pre": function ( name ) {
          var cihazDurumuSiralamaNo;
          ';
for ($i = 0; $i < count($this->Islemler_Model->cihazDurumuSiralama); $i++) {

  echo ($i > 0 ? "else " : "") . 'if (name == "' . $this->Islemler_Model->cihazDurumu[$i] . '") {
              cihazDurumuSiralamaNo = ' . $this->Islemler_Model->cihazDurumuSiralama[$i] . ';
            }';
}
echo '
          return cihazDurumuSiralamaNo;
      },
      "priority-asc": function ( a, b ) {
              return a - b;
      },
      "priority-desc": function ( a, b ) {
              return b - a;
      },
      "date-tr-pre": function ( name ) {
        var gun = parseInt(name.slice(0, 2));
        gun = tarihiFormatla(gun);
        var ay = parseInt(name.slice(3, 5));
        ay = tarihiFormatla(ay);
        var yil = parseInt(name.slice(6, 10));
        var saat = parseInt(name.slice(11, 13));
        saat = tarihiFormatla(saat);
        var dakika = parseInt(name.slice(14, 16));
        dakika = tarihiFormatla(dakika);
        return parseInt(yil + "" + ay + "" + gun + "" + saat + "" + dakika);
      },
      "date-tr-asc": function ( name ) {
        return a - b;
      },
      "date-tr-desc": function ( name ) {
        return b - a;
      }
    });
    var cihazlarTablosu = $(tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari("[[ 6, \"asc\" ], [ 5, \"desc\" ]]", "true", ' "aoColumns": [
      null,
      null,
      null,
      null,
      null,
      { "sType": "date-tr" },
      null,
      null,
      null
    ],') . ');
    setInterval(() => {
      cihazBilgileriniGetir();
      $.get(\'' . base_url("cihazyonetimi/silinenCihazlariBul") . '\', {}, function(data) {
        $.each(JSON.parse(data), function(index, value) {
          const cihazVarmi = document.querySelectorAll(
            "#cihaz" + value.id
          ).length > 0;
          if (cihazVarmi) {
            cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
          }
        });
      });
      $.get(\'' . base_url("cihazyonetimi" . "/cihazlarTumuJQ/") . '\', {}, function(data) {
        sayac = 0;
        $.each(JSON.parse(data), function(index, value) {
          if (sayac == 0) {
            sonCihazID = value.id;
          }
          sayac++;
          const cihazVarmi = document.querySelectorAll(
            "#cihaz" + value.id
          ).length > 0;
          if (cihazVarmi) {
            let cihazDetayBtnOnclick = \'' . $cihazDetayBtnOnclick . '\';
            const cihazDetayBtn = donustur(cihazDetayBtnOnclick, value);
            $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Btn" + value.id).attr("onClick", cihazDetayBtn);
            console.log("Çalıştı");
            $("#cihaz" + value.id).attr(\'class\', \'\');
            $("#cihaz" + value.id).addClass(cihazDurumuClass(value.guncel_durum));
            $("#" + value.id + "ServisNo, #" + value.id + "ServisNo3").html(value.servis_no);
            $("#" + value.id + "MusteriAdi").html(value.musteri_adi);
            $("#" + value.id + "CihazTuru").html(value.cihaz_turu);
            $("#" + value.id + "Sorumlu").html(value.sorumlu);
            $("#" + value.id + "Cihaz").html(value.cihaz + " " + value.cihaz_modeli);
            $("#" + value.id + "GuncelDurum").html(cihazDurumu(value.guncel_durum));
            $("#" + value.id + "MusteriGSM").html(value.telefon_numarasi);
            $("#" + value.id + "Tarih2").html(tarihDonusturSiralama(value.tarih));';
if ($sorumlu_belirtildimi) {
  $kullaniciBilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
  echo '
            if(value.sorumlu != "' . $kullaniciBilgileri["ad_soyad"] . '"){
              cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
            }';
}
echo '
          }
        });
      });

      $.get(\'' . base_url(($sorumlu_belirtildimi ? "cihazlarim" : "cihazyonetimi") . "/cihazlarJQ/") . '\' + sonCihazID, {}, function(data) {
        $.each(JSON.parse(data), function(index, value) {
          const cihazVarmi = document.querySelectorAll(
            "#cihaz" + value.id
          ).length > 0;
          if (!cihazVarmi) {
            //cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
            let tabloOrnek = \'' . $tabloOrnek . '\';
            
            const tablo = donustur(tabloOrnek, value);
            cihazlarTablosu.row.add($(tablo)).draw();
            //$("#cihazlar").prepend(tablo);
          }
        });
      });
    }, 5000);
  });
</script>';
echo $cihazDetayOrnek;
echo $cihazSilModalOrnek;
