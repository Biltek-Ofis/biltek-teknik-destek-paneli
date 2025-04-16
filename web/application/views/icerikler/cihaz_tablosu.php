<?php $this->load->view("inc/datatables_scripts");

$tema = $this->Ayarlar_Model->kullaniciTema();
echo '<script src="' . base_url("dist/js/cihaz.min.js") . '"></script>
<script src="' . base_url("dist/js/cihazyonetimi.min.js") . '"></script>
<script src="'. base_url("dist/js/qrcode.min.js").'"></script>';

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
$this->Cihazlar_Model->bilgisayardaAcSifirla($this->Kullanicilar_Model->kullaniciBilgileri()["id"]);
$this->load->view("inc/style_tablo");

$sorumlu_belirtildimi = isset($suankiPersonel) ? true : false;
$silButonuGizle = isset($silButonuGizle) ? $silButonuGizle : false;

$cihazDetayBtnOnclick = 'detayModaliGoster(\\\'{id}\\\',\\\'{servis_no}\\\',\\\'{takip_no}\\\',\\\'{musteri_kod}\\\',\\\'{musteri_adi_onclick}\\\',\\\'{teslim_eden_onclick}\\\',\\\'{teslim_alan_onclick}\\\',\\\'{adres_onclick}\\\',\\\'{telefon_numarasi}\\\',\\\'{tarih}\\\',\\\'{bildirim_tarihi}\\\',\\\'{cikis_tarihi}\\\',\\\'{guncel_durum_onclick}\\\',\\\'{guncel_durum_sayi}\\\',\\\'{cihaz_turu_onclick}\\\',\\\'{cihaz_onclick}\\\',\\\'{cihaz_modeli_onclick}\\\',\\\'{seri_no_onclick}\\\',\\\'{teslim_alinanlar_onclick}\\\',\\\'{cihaz_sifresi_onclick}\\\',\\\'{cihaz_deseni_onclick}\\\',\\\'{cihazdaki_hasar_onclick}\\\',\\\'{hasar_tespiti_onclick}\\\',\\\'{ariza_aciklamasi_onclick}\\\',\\\'{servis_turu_onclick}\\\',\\\'{yedek_durumu}\\\',\\\'{sorumlu_onclick}\\\',\\\'{yapilan_islem_aciklamasi_onclick}\\\',\\\'{tahsilat_sekli_onclick}\\\',\\\'{fatura_durumu_onclick}\\\',\\\'{fis_no_onclick}\\\')';
$cihazDetayBtnOnclick = $this->Islemler_Model->trimle($cihazDetayBtnOnclick);
$kaydiKopyalaOnClick = 'kaydiKopyala(\\\'{musteri_kod_onclick}\\\',\\\'{musteri_adi_onclick}\\\',\\\'{adres_onclick}\\\',\\\'{telefon_numarasi}\\\',\\\'{cihaz_turu_val_onclick}\\\',\\\'{cihaz_onclick}\\\',\\\'{cihaz_modeli_onclick}\\\',\\\'{seri_no_onclick}\\\',\\\'{cihaz_sifresi_onclick}\\\',\\\'{sorumlu_val_onclick}\\\')';
$kaydiKopyalaOnClick = $this->Islemler_Model->trimle($kaydiKopyalaOnClick);
$cDurumlari = $this->Cihazlar_Model->cihazDurumlari();
$cTurleri = $this->Cihazlar_Model->cihazTurleri();

echo '<script>
  var bildirim_tarihi_degisti = false;
  if(yeniCihazGirisiAcik === null){
    var yeniCihazGirisiAcik = false;
  }
  if(yeniCihazGirisiAcik === undefined){
    yeniCihazGirisiAcik = false;
  }
  var suankiCihaz = 0;
  var yonetici = '.($this->Kullanicilar_Model->yonetici() ? "true" : "false").';
  var duzenleme_modu = false;
  function detaylariGoster(){

    $("#dt_duzenle").hide();
    $("#dt_duzenle #musteri_adi_liste").html("");
    $("#kaydetBtn").hide();
    $("#iptalBtn").hide();
    $("#dt-goster").show();
    $("#serviskabulBtn").show();
    $("#barkoduYazdirBtn").show();
    $("#kargoBilgisiBtn").show();
    $("#formuYazdirBtn").show();
    if($("#silBtn").hasClass("goster")){
      $("#silBtn").show();
    }
    if($("#duzenleBtn").hasClass("goster")){
      $("#duzenleBtn").show();
    }
    //$("#detaylar_body").scrollTop(0);
    duzenleme_modu = false;
  }
  function duzenleyiGoster(){
    $("#dt-goster").hide();
    $("#dt_duzenle #musteri_adi_liste").html("");
    $("#duzenleBtn").hide();
    $("#serviskabulBtn").hide();
    $("#barkoduYazdirBtn").hide();
    $("#kargoBilgisiBtn").hide();
    $("#formuYazdirBtn").hide();
    $("#silBtn").hide();
    $("#dt_duzenle").show();
    $("#kaydetBtn").show();
    $("#iptalBtn").show();
    
    $("#dt-UploadForm")[0].reset();
    $("#dt-UploadForm #durum").html("");
    $("#dt-UploadForm #yukleme_durumu").html("");
    
    $("#detaylar_body").scrollTop(0);
    duzenleme_modu = true;
  }
  function formKaydet(formDiv, onComplete, bildirim_tarihi){
    var formAction = $(formDiv).attr("action");
    var formData = $(formDiv).serialize();
    if(bildirim_tarihi && !bildirim_tarihi_degisti){
      let params = new URLSearchParams(formData);
      params.delete("bildirim_tarihi");
      formData = params.toString();
    }
    $.post(formAction, formData)
    .done(function(msg){
      try{
        if(bildirim_tarihi){
          bildirim_tarih_durumu_duzenle(false);
        }
        data = $.parseJSON( msg );
        if(data["sonuc"]==1){
          onComplete();
        }else{
          $("#kaydetBtn").prop("disabled", false);
          $("#kaydediliyorModal").modal("hide");
          $("#hata-mesaji").html(data["mesaj"]);
          $("#statusErrorsModal").modal("show");
        }
      }catch(error){
        $("#kaydetBtn").prop("disabled", false);
        $("#kaydediliyorModal").modal("hide");
        $("#hata-mesaji").html(error);
        $("#statusErrorsModal").modal("show");
      }
    })
    .fail(function(xhr, status, error) {
      $("#kaydetBtn").prop("disabled", false);
      $("#kaydediliyorModal").modal("hide");
      $("#hata-mesaji").html(error);
      $("#statusErrorsModal").modal("show");
    });
  }
  function detaylariKaydet(){
    $("#dt_duzenle #musteri_adi_liste").html("");
    $("#kaydediliyorModal").modal("show");
    $("#kaydetBtn").prop("disabled", true);
    formKaydet("#dt_duzenleForm", function(){
      formKaydet("#dt-YapilanIslemlerForm", function(){
        $("#kaydetBtn").prop("disabled", false);
        cihazBilgileriniGetir();
        $("#kaydediliyorModal").modal("hide");
        detaylariGoster();
        $("#basarili-mesaji").html("Bilgiler başarıyla kaydedildi.");
        basariliModalGoster();
      }, true);
    }, false);
  }
    function cihazKilitle(guncelDurum){
      guncelDurum = parseInt(guncelDurum);
      switch (guncelDurum) {';
      foreach($cDurumlari as $cDurumu){
        echo '
        case '.$cDurumu->id.':
          return '.($cDurumu->kilitle == 0 ? "false": "true").';';
      }
      echo '
        default:
          return false;
      }
    }
  function butonDurumu(guncel_durum){
    if(!cihazKilitle(guncel_durum) || yonetici){      
      if(!duzenleme_modu){
        if(!$("#duzenleBtn").hasClass("goster")){
          $("#duzenleBtn").addClass("goster");
        }
        $("#duzenleBtn").show();
        if(!$("#silBtn").hasClass("goster")){
          $("#silBtn").addClass("goster");
        }
        $("#silBtn").show();
      }
    }else{
      if($("#duzenleBtn").hasClass("goster")){
        $("#duzenleBtn").removeClass("goster");
      }
      $("#duzenleBtn").hide();
      if($("#silBtn").hasClass("goster")){
        $("#silBtn").removeClass("goster");
      }
      $("#silBtn").hide();
      detaylariGoster();
    }
  }
  function medyalariYukle(id) {
    $.post("' . base_url("medyalar") . '/" + id, {}, function(data) {
      $("#list-medyalar").html(data);
    });
    $.post("' . base_url("medyalar") . '/" + id + "/1", {}, function(data) {
      $("#dt-medyalar").html(data);
    });
  }
  function cihaziSil(id, sorumlu_belirtildimi){
    $("#silOnayBtn").prop("disabled", true);
    $("#kaydediliyorModal").modal("show");
    var p_url = (sorumlu_belirtildimi ? "' . base_url("cihazlarim/cihazSil") . '" : "' . base_url("cihazyonetimi/cihazSil") . '") + "/" + id +"/post";
    $.post(p_url)
    .done(function(msg){
      $("#silOnayBtn").prop("disabled", false);
      $("#kaydediliyorModal").modal("hide");
      try{
        data = $.parseJSON( msg );
        if(data["sonuc"]==1){
          cihazlariGetir(cihazlarSayfa, cihazlarArama, false, cihazlarOrderIsim, cihazlarOrderDurum, cihazlarDurumSpec, cihazlarTurSpec);
          $("#'.$this->Cihazlar_Model->cihazDetayModalAdi().'").modal("hide");
          $("#cihaziSilModal").modal("hide");
          $("#basarili-mesaji").html("Kayıt başarıyla silindi.");
          basariliModalGoster();
        }else{
          $("#hata-mesaji").html(data["mesaj"]);
          $("#statusErrorsModal").modal("show");
        }
      }catch(error){
        $("#hata-mesaji").html(error);
        $("#statusErrorsModal").modal("show");
      }
    })
    .fail(function(xhr, status, error) {
      $("#silOnayBtn").prop("disabled", false);
      $("#kaydediliyorModal").modal("hide");
      $("#hata-mesaji").html(error);
      $("#statusErrorsModal").modal("show");
    });
  }
  function silModaliGoster(id, servis_no, musteri_adi){
    $("#silOnayBtn").attr("onclick", "cihaziSil(" + id + ", '.($sorumlu_belirtildimi ? "true": "false").')");

    $("#ServisNo4").html(servis_no);
    $("#MusteriAdi3").html(musteri_adi);

    $("#cihaziSilModal").modal("show");
  }
  function QRYenile(servis_no){
    $("#ServisNoQR").html("");
    new QRCode(document.getElementById("ServisNoQR"), {
      text: "servisNo:"+servis_no,
      width: 80,
      height: 80,
      colorDark : "#000000",
      colorLight : "#ffffff",
      correctLevel : QRCode.CorrectLevel.H
    });
  }
  function detayModaliGoster(id, servis_no, takip_no, musteri_kod, musteri_adi, teslim_eden, teslim_alan, adres, telefon_numarasi, tarih, bildirim_tarihi, cikis_tarihi, guncel_durum, guncel_durum_sayi, cihaz_turu, cihaz, cihaz_modeli, seri_no, teslim_alinanlar, cihaz_sifresi,cihaz_deseni, cihazdaki_hasar, hasar_tespiti, ariza_aciklamasi, servis_turu, yedek_durumu, sorumlu, yapilan_islem_aciklamasi, tahsilat_sekli, fatura_durumu, fis_no) {
    /*<button id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Btn{id}" class="btn btn-info text-white" onClick="' . $cihazDetayBtnOnclick . '">Detaylar</button>*/
    suankiCihaz = parseInt(id);
    
    cihazBilgileriniGetir();

    butonDurumu(guncel_durum_sayi);
    $("#duzenleBtn").prop("disabled", true);
    $("#silBtn").prop("disabled", true);
    QRYenile(servis_no);
    $("#ServisNo2, #ServisNo3").html(servis_no);
    $("#TakipNo").html(takip_no);
    $("#MusteriKod").html(musteri_kod);
    $("#MusteriAdi2").html(musteri_adi);
    $("#TeslimEden2").html(teslim_eden);
    $("#TeslimAlan2").html(teslim_alan);
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

    var sifreVar = false;

    if(cihaz_deseni.length > 0){
      dtBodyDesenP.setPattern(cihaz_deseni);
      $("#CihazDeseni").show();
      $("#CihazSifresi").hide();
      $("#CihazSifresi").html("");
    }else{
      $("#CihazSifresi").html(cihaz_sifresi);
      $("#CihazSifresi").show();
      $("#CihazDeseni").hide();
      dtBodyDesenP.clear();
    }

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
    $("#serviskabulBtn").attr("onclick", "servisKabulYazdir(" + id + ")");
    $("#kargoBilgisiBtn").attr("onclick", "kargoBilgisiYazdir(" + id + ")");
    $("#barkoduYazdirBtn").attr("onclick", "barkoduYazdir(" + id + ")");
    $("#formuYazdirBtn").attr("onclick", "formuYazdir(" + id + ")");
    $("#silBtn").attr("onclick", "silModaliGoster(\'" + id + "\',\'" + servis_no + "\',\'" + musteri_adi + "\')");

    $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").modal("show");
  }
  function kaydiKopyala(musteri_kod, musteri_adi, adres, telefon_numarasi, cihaz_turu, cihaz, cihaz_modeli, seri_no, cihaz_sifresi, sorumlu){

      $(\'#yeniCihazForm\')[0].reset();
      if(musteri_kod != "Yok" && musteri_kod != ""){
        $("#yeniCihazForm #musteri_kod").val(musteri_kod);
      }
        
      $("#yeniCihazForm #musteri_adi").val(musteri_adi);
      $("#yeniCihazForm #adres").val(adres);
      $("#yeniCihazForm #musteriyi_kaydet").prop("checked", false);
      $("#yeniCihazForm #telefon_numarasi").val(telefon_numarasi);
      $("#yeniCihazForm #cihaz_turu").val(cihaz_turu);
      $("#yeniCihazForm #cihaz").val(cihaz);
      $("#yeniCihazForm #cihaz_modeli").val(cihaz_modeli);
      $("#yeniCihazForm #seri_no").val(seri_no);
      $("#yeniCihazForm #cihaz_sifresi").val(cihaz_sifresi);
      $("#yeniCihazForm #sorumlu").val(sorumlu);

      $("#yeniCihazEkleModal").modal("show");
  }
</script>';
$this->load->view("inc/tarayici_uyari");
$this->load->view("inc/yukleniyor", array("yukleniyor_mesaj" => "Yükleniyor..."));
echo '<div class="progress-bar">
  <progress value="75" min="0" max="100" style="visibility:hidden;height:0;width:0;">75%</progress>
</div>';
echo '<div id="cihazTablosu" class="table-responsive" style="display:none;">';

echo '<div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
          <div class="col-sm-12 col-md-6"></div>
          <div class="col-sm-12 col-md-6">
            <div class="dataTables_filter">
              <label>Ara:
                <input id="cihaz_tablosu_ara" type="search" class="form-control form-control-sm" placeholder="">
              </label>
            </div>
          </div>
        </div>
      </div>';
echo '<table id="cihaz_tablosu" class="table table-bordered mt-2" style="min-height: 700px;">
<thead>
    <tr>
        <th scope="col">Servis No</th>
        <th scope="col">Müşteri Adı</th>
        <th scope="col">GSM</th>
        <th id="cihazTuruColumn" scope="col" class="no-sort">
          <div class="nav-item dropdown">
                <a href="javascript:void(0)" onclick="siralamaGuncelle($(\'#cihazTuruColumn\'), 3);" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "color: black;").'">Tür</a>
                <ul class="dropdown-menu cihazTurleriDropdown">';
                    echo '<li class="dropdown-item cihazTurleriDropdownItemTumu active">
                    <a href="javascript:void(0)" class="d-block w-100" onclick="cihazlariGetir(cihazlarSayfa, cihazlarArama, false, cihazlarOrderIsim, cihazlarOrderDurum, cihazlarDurumSpec, \'\');cihazDropdownActive(\'.cihazTurleriDropdown\', \'.cihazTurleriDropdownItemTumu\');">Tümü</a>
                  </li>';
                foreach($cTurleri as $cTuru){
                  echo '<li class="dropdown-item cihazTurleriDropdownItem'.$cTuru->id.'">
                    <a href="javascript:void(0)" class="d-block w-100" onclick="cihazlariGetir(cihazlarSayfa, cihazlarArama, false, cihazlarOrderIsim, cihazlarOrderDurum, cihazlarDurumSpec, \''.$cTuru->id.'\');cihazDropdownActive(\'.cihazTurleriDropdown\', \'.cihazTurleriDropdownItem'.$cTuru->id.'\');">'.$cTuru->isim.'</a>
                  </li>';
                }
                echo '
                    </ul>
            </div>
        </th>
        <th scope="col">Cihaz</th>
        <th scope="col">Giriş Tarihi</th>
        <th id="cihazDurumuColumn" class="no-sort" scope="col">
          <div class="nav-item dropdown">
                <a href="javascript:void(0)" onclick="siralamaGuncelle($(\'#cihazDurumuColumn\'), 6);" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "color: black;").'">Güncel Durum</a>
                <ul class="dropdown-menu cihazDurumlariDropdown">';
                echo '
                    <!--<li class="dropdown-item" style="background: gray;">
                      <a href="javascript:void(0)" class="d-block w-100">SIRALA</a>
                    </li>-->';
                    echo '<li class="dropdown-item cihazDurumlariDropdownItemTumu active">
                    <a href="javascript:void(0)" class="d-block w-100" onclick="cihazlariGetir(cihazlarSayfa, cihazlarArama, false, cihazlarOrderIsim, cihazlarOrderDurum, \'\', cihazlarTurSpec);cihazDropdownActive(\'.cihazDurumlariDropdown\', \'.cihazDurumlariDropdownItemTumu\');">Tümü</a>
                  </li>';
                foreach($cDurumlari as $cDurumu54){
                  echo '<li class="dropdown-item cihazDurumlariDropdownItem'.$cDurumu54->id.'">
                    <a href="javascript:void(0)" class="d-block w-100" onclick="cihazlariGetir(cihazlarSayfa, cihazlarArama, false, cihazlarOrderIsim, cihazlarOrderDurum, \''.$cDurumu54->id.'\', cihazlarTurSpec);cihazDropdownActive(\'.cihazDurumlariDropdown\', \'.cihazDurumlariDropdownItem'.$cDurumu54->id.'\');">'.$cDurumu54->durum.'</a>
                  </li>';
                }
                echo '
                    </ul>
          </div>
        </th>
        <th scope="col">Sorumlu Personel</th>
        <th scope="col">Detaylar</th>
    </tr>
</thead>
<tbody id="cihazlar">';
$sonCh = $sorumlu_belirtildimi ? $this->Cihazlar_Model->sonCihazJQ($suankiPersonel) : $this->Cihazlar_Model->sonCihazJQ();
$sonCihazID = count($sonCh) > 0 ? $sonCh[0]->id : 0;

$tabloOrnek = '<tr id="cihaz{id}" class="{class}" data-cihazid="{id}" onClick="$(\\\'#{id}Yeni\\\').remove()">
  <th scope="row"><span class="{id}ServisNo">{servis_no}</span></th>
  <td><span class="{id}MusteriAdi">{musteri_adi}</span>{yeni}</td>
  <td><span class="{id}MusteriGSM">{telefon_numarasi}</span></td>
  <td><span class="{id}CihazTuru">{cihaz_turu}</span></td>
  <td><span class="{id}Cihaz">{cihaz} {cihaz_modeli}</span></td>
  <td><span class="{id}Tarih2">{tarih2}</span></td>
  <td><span class="{id}GuncelDurum">{guncel_durum}</span></td>
  <td><span class="{id}Sorumlu">{sorumlu}</span></td>
  <td class="text-center">
    <button id="' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Btn{id}" class="btn btn-info text-white" onClick="' . $cihazDetayBtnOnclick . '">Detaylar</button>
   ' . ($sorumlu_belirtildimi ? "" : '<button class="btn btn-info text-white" alt="Aynı bilgilerle yeni kayıt oluştur." title="Aynı bilgilerle yeni kayıt oluştur." onClick="' . $kaydiKopyalaOnClick . '"><i class="fa-solid fa-copy"></i></button>') . '
   <button class="btn btn-secondary" onclick="barkoduYazdir({id})">Barkodu Yazdır</button> 
  </td>
 
</tr>';
$ilkOgeGenislik = "40%";
$ikinciOgeGenislik = "60%";
$besliIlkOgeGenislik = "40%";
$besliIkinciOgeGenislik = "10%";
$besliUcuncuOgeGenislik = "10%";
$besliDorduncuOgeGenislik = "20%";
$besliBesinciOgeGenislik = "20%";

$yapilanIslemInputlari = "";
for($i = 1; $i <= $this->Islemler_Model->maxIslemSayisi; $i++){
  $yapilanIslemInputlari .= "\n".$this->load->view("ogeler/yapilan_islem", array("index" => $i, "yapilanIslemArr" => null), true);
}
echo '<script>
function bildirim_tarih_durumu_duzenle(durum){
  bildirim_tarihi_degisti = durum;
}
$(document).ready(function(){
  $("#dt_duzenle input#bildirim_tarihi").change(function(){
    bildirim_tarih_durumu_duzenle(true);
  });
  $("#cihaz_tablosu_wrapper > .row:nth-child(1)").attr("id", "cihazlar_pegination1");
  $("#cihaz_tablosu_wrapper > .row:nth-child(2)").attr("id", "cihazlar_main");
  $("#cihaz_tablosu_wrapper > .row:nth-child(3)").attr("id", "cihazlar_pegination2");

  
  window.addEventListener("scroll", function () {
     
        const targetDiv = document.getElementById("cihazlar_main");
        const rect = targetDiv.getBoundingClientRect();
        if (rect.top <= 0) {
          $("#cihazlar_pegination1").css({
            position: "fixed",
            left: "0",
            right: "0",
            width: "100%",
            bottom: "0px",
            background: \''.(strlen($tema->arkaplan) > 0 ? $tema->arkaplan : "#fff").'\',
            padding: "1rem",
            zIndex : "2",
            borderTop: "1px solid '.(strlen($tema->yazi_rengi) > 0 ? $tema->yazi_rengi : "black").'"
          });
          $("#cihazlar_pegination2").css({
            height: document.getElementById("cihazlar_pegination1").offsetHeight
          });
        } else {
          $("#cihazlar_pegination1").attr("style", "");
          $("#cihazlar_pegination2").css({
            height: "0"
          });  
        }

        isFixed = true; // Tekrar tetiklenmesini önler
      
  });
';
if(isset( $_GET["servisNo"])){

  $cihazGoster = $_GET["servisNo"];
  $gosterilenCihaz = $this->Cihazlar_Model->tekCihazApp($cihazGoster);
  if($gosterilenCihaz != null){

    echo 'detayModaliGoster(
      "'.donusturOnclick($gosterilenCihaz->id).'", 
      "'.donusturOnclick($gosterilenCihaz->servis_no).'", 
      "'.donusturOnclick($gosterilenCihaz->takip_numarasi).'", 
      "'.donusturOnclick($gosterilenCihaz->musteri_kod).'", 
      "'.donusturOnclick($gosterilenCihaz->musteri_adi).'", 
      "'.donusturOnclick($gosterilenCihaz->teslim_eden).'",
      "'.donusturOnclick($gosterilenCihaz->teslim_alan).'",
      "'.donusturOnclick($gosterilenCihaz->adres).'",
      "'.donusturOnclick($gosterilenCihaz->telefon_numarasi).'",
      "'.donusturOnclick($gosterilenCihaz->tarih).'",
      "'.donusturOnclick($gosterilenCihaz->bildirim_tarihi).'",
      "'.donusturOnclick($gosterilenCihaz->cikis_tarihi).'",
      cihazDurumu("'.donusturOnclick($gosterilenCihaz->guncel_durum).'"),
      "'.donusturOnclick($gosterilenCihaz->guncel_durum).'",
      "'.donusturOnclick($gosterilenCihaz->cihaz_turu).'",
      "'.donusturOnclick($gosterilenCihaz->cihaz).'",
      "'.donusturOnclick($gosterilenCihaz->cihaz_modeli).'",
      "'.donusturOnclick($gosterilenCihaz->seri_no).'",
      "'.donusturOnclick($gosterilenCihaz->teslim_alinanlar).'",
      "'.donusturOnclick($gosterilenCihaz->cihaz_sifresi).'",
      "'.donusturOnclick($gosterilenCihaz->cihaz_deseni).'",
      "'.donusturOnclick($gosterilenCihaz->cihazdaki_hasar).'",
      "'.donusturOnclick($gosterilenCihaz->hasar_tespiti).'",
      "'.donusturOnclick($gosterilenCihaz->ariza_aciklamasi).'",
      servisTuru("'.donusturOnclick($gosterilenCihaz->servis_turu).'"),
      evetHayir("'.donusturOnclick($gosterilenCihaz->yedek_durumu).'"),
      "'.donusturOnclick($gosterilenCihaz->sorumlu).'",
      "'.donusturOnclick($gosterilenCihaz->yapilan_islem_aciklamasi).'",
      "'.donusturOnclick($gosterilenCihaz->tahsilat_sekli).'",
      faturaDurumu("'.donusturOnclick($gosterilenCihaz->fatura_durumu).'"), 
      "'.donusturOnclick($gosterilenCihaz->fis_no).'");';
  }
}
echo '
});
</script>';
$cihazDetayOrnek = '
<script>
$(document).ready(function(){
  setInterval(() => {
      $.get(\'' . base_url("cihazyonetimi/bilgisayardaAcGetir") . '/' . $this->Kullanicilar_Model->kullaniciBilgileri()["id"] . '\', {})
      .done(function(data) {
        try {
          var value = JSON.parse(data);
          if(value.id){
            $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").removeClass("fade");
            $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").modal("hide");
            $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").addClass("fade");
            detayModaliGoster(value.id, value.servis_no, value.takip_numarasi, value.musteri_kod, value.musteri_adi, value.teslim_eden, value.teslim_alan, value.adres, value.telefon_numarasi, value.tarih, value.bildirim_tarihi, value.cikis_tarihi, cihazDurumu(value.guncel_durum), value.guncel_durum, value.cihaz_turu, value.cihaz, value.cihaz_modeli, value.seri_no, value.teslim_alinanlar, value.cihaz_sifresi, value.cihaz_deseni, value.cihazdaki_hasar, value.hasar_tespiti, value.ariza_aciklamasi, servisTuru(value.servis_turu), evetHayir(value.yedek_durumu), value.sorumlu, value.yapilan_islem_aciklamasi, value.tahsilat_sekli, faturaDurumu(value.fatura_durumu), value.fis_no);
          }
        } catch (error) {
          console.error(error);
        }
      });
    }, 2000);
  $("#dt_duzenle #cihaz_turu").on("change", function() {
    cihazTurleriSifre($(this).val());
  });
  cihazTurleriSifre("#dt_duzenle", $("#dt_duzenle #cihaz_turu").val());

  $("#dt_duzenle #fatura_durumu").on("change", function() {
    faturaDurumuInputlar("#dt_duzenle", $(this).val())
  });
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
      <div id="detaylar_body" class="modal-body">
        <div class="row">
          <div id="dt-goster" class="row">
            <div class="col-12 col-lg-6">
              <!-- Genel Bilgiler Göster -->
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
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Teslim Eden:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="TeslimEden2"></li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Teslim Alan:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="TeslimAlan2"></li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Adresi:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="MusteriAdres"></li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">GSM:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="MusteriGSM2"></li>
              </ul>
              <ul class="list-group list-group-horizontal" style="display:none;">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">QR:</span></li>
                <li class="list-group-item text-center" style="width:' . $ikinciOgeGenislik . ';">
                  <span style="max-width:20%;" id="ServisNoQR"></span>
                </li>
              </ul>
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:' . $ilkOgeGenislik . ';"><span class="font-weight-bold">Giriş Tarihi:</span></li>
                <li class="list-group-item" style="width:' . $ikinciOgeGenislik . ';" id="GirisTarihi"></li>
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
            </div>
            <div class="col-12 col-lg-6">
              <!-- Cihaz Bilgileri Göster -->
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
                <li id="CihazDeseni" class="list-group-item" style="width:' . $ikinciOgeGenislik . ';">
                  <svg id="dtBodyDesen" class="patternlock success" xmlns="http://www.w3.org/2000/svg">
                    <g class="lock-actives"></g>
                    <g class="lock-lines"></g>
                    <g class="lock-dots">
                      <circle cx="20" cy="20" r="5"></circle>
                      <circle cx="80" cy="20" r="5"></circle>
                      <circle cx="140" cy="20" r="5"></circle>
          
                      <circle cx="20" cy="70" r="5"></circle>
                      <circle cx="80" cy="70" r="5"></circle>
                      <circle cx="140" cy="70" r="5"></circle>
          
                      <circle cx="20" cy="120" r="5"></circle>
                      <circle cx="80" cy="120" r="5"></circle>
                      <circle cx="140" cy="120" r="5"></circle>
                    </g>
                  </svg>
                  <script>
                  var dtBodyDesenE = document.getElementById("dtBodyDesen");
                  var dtBodyDesenP = new PatternLock(dtBodyDesenE, {
                      onPattern: function() {
                          
                      },
                      interactable: false,
                  });
                  </script>
                </li>
              </ul>
            </div>
            <div class="col-12">
              <!-- Teknik Servis Bilgileri Göster -->
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
            </div>
            <div class="col-12">
              <!-- Yapılan İşlemler Göster -->
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
                <li class="list-group-item" style="width:' . $besliBesinciOgeGenislik . ';"><span class="font-weight-bold">KDV</span></li>
                <li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';"><span class="font-weight-bold">Tutar (KDV\'siz)</span></li>
                <li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';"><span class="font-weight-bold">Toplam</span></li>
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
            </div>
            <div class="col-12">
              <!-- Medyalar Göster-->
              <ul class="list-group list-group-horizontal">
                <li class="list-group-item" style="width:100%;"><h3>Medyalar</h3></li>
              </ul>
              
              <ul class="list-group list-group-horizontal">
                <li id="list-medyalar" class="list-group-item" style="width:100%;"></li>
              </ul>
            </div>
          </div>
          
          <div id="dt_duzenle" class="col-12" style="display:none;">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                  <a class="nav-link active" id="genel-bilgiler-tab" data-toggle="pill" href="#genel-bilgiler" role="tab" aria-controls="genel-bilgiler" aria-selected="false">Genel Bilgiler</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="yapilan-islemler-tab" data-toggle="pill" href="#yapilan-islemler" role="tab" aria-controls="yapilan-islemler" aria-selected="false">Yapılan İşlemler</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="medyalar-tab" data-toggle="pill" href="#medyalar" role="tab" aria-controls="medyalar" aria-selected="false">Medyalar</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="genel-bilgiler" role="tabpanel" aria-labelledby="genel-bilgiler-tab">
                <form id="dt_duzenleForm" autocomplete="off" method="post" action="">
                  <div class="table-responsive">
                    <table class="table table-flush">
                      <thead></thead>
                      <tbody>
                        <tr>
                            <th class="align-middle">Müşteri Adı: </th>
                            <td class="align-middle">'.$this->load->view("ogeler/musteri_adi", array("sifirla" => true, "musteri_adi_form" => "#dt_duzenleForm", "musteri_adi_sayi" => "2"), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Teslim Eden: </th>
                            <td class="align-middle">'.$this->load->view("ogeler/teslim_eden", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Teslim Alan: </th>
                            <td id="TeslimAlan" class="align-middle"></td>
                        </tr>
                        <tr>
                            <th class="align-middle">Adresi: </th>
                            <td class="align-middle">'.$this->load->view("ogeler/adres", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">GSM *: </th>
                            <td class="align-middle">'.$this->load->view("ogeler/gsm", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Cihaz Türü:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/cihaz_turleri", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Sorumlu Personel:</th>
                            <td id="dz-sorumlu-personel" class="align-middle">'.($this->Kullanicilar_Model->yonetici() ?$this->load->view("ogeler/sorumlu_select", array("sifirla" => true), true) : "").'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Markası:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/cihaz_markasi", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Modeli:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/cihaz_modeli", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Seri Numarası:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/seri_no", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Cihaz Şifresi:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/cihaz_sifresi", array("formID" => "dt_duzenle", "sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Teslim alınırken belirlenen hasar türü:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/hasar_turu", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Teslim alınırken yapılan hasar tespiti:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/hasar_tespiti", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Arıza Açıklaması:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/ariza_aciklamasi", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Teslim Alınanlar:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/teslim_alinanlar", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Servis Türü:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/servis_turu", array("sifirla" => true), true).'</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Yedek Alınacak mı?:</th>
                            <td class="align-middle">'.$this->load->view("ogeler/yedek", array("sifirla" => true), true).'</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="yapilan-islemler" role="tabpanel" aria-labelledby="yapilan-islemler">
                <form id="dt-YapilanIslemlerForm" autocomplete="off" method="post" action="">
                  <div class="table-responsive">
                    <table class="table table-flush">
                      <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody id="form">
                          <tr>
                              <th class="align-middle" colspan="2">Giriş Tarihi:</th>
                              <td class="align-middle" colspan="2">'.$this->load->view("ogeler/tarih", array("tarih_id"=>"dz-tarih","sifirla" => true), true).'</td>
                          </tr>
                          <tr>
                              <th class="align-middle" colspan="2">Bildirim Tarihi:</th>
                              <td class="align-middle" colspan="2">'.$this->load->view("ogeler/bildirim_tarihi", array("sifirla" => true), true).'</td>
                          </tr>
                          <tr>
                              <th class="align-middle" colspan="2">Çıkış Tarihi:</th>
                              <td class="align-middle" colspan="2">'.$this->load->view("ogeler/cikis_tarihi", array("sifirla" => true), true).'</td>
                          </tr>
                          <tr>
                            <th class="align-middle" colspan="2">Güncel Durum:</th>
                            <td class="align-middle" colspan="2">'.$this->load->view("ogeler/guncel_durum", array("sifirla" => true), true).'</td>
                          </tr>
                          <tr>
                            <th class="align-middle" colspan="2">Tahsilat Şekli:</th>
                            <td class="align-middle" colspan="2">'.$this->load->view("ogeler/tahsilat_sekli", array("sifirla" => true), true).'</td>
                          </tr>
                          <tr>
                            <th class="align-middle" colspan="2">Fatura Durumu:</th>
                            <td id="fatura_durumu_td" class="align-middle" colspan="2">'.$this->load->view("ogeler/fatura_durumu", array("sifirla" => true), true).'</td>
                            <td id="fis_no_td" class="align-middle" style="display:none;" colspan="0">'.$this->load->view("ogeler/fis_no", array("sifirla" => true), true).'</td>
                          </tr>
                    </tbody>
                    </table>
                    <table class="table table-flush">
                      <thead>
                        <tr>
                            <th>#</th>
                            <!--<th>SK</th>-->
                            <th>Malzeme/İşçilik</th>
                            <th>Miktar</th>
                            <th>Birim Fiyat (TL)</th>
                            <th>KDV Oranı (%)</th>
                            <th>KDV</th>
                            <th>Tutar (KDV\'siz)</th>
                            <th>Toplam</th>
                        </tr>
                      </thead>
                      <tbody id="yapilanIslemBody">'.$yapilanIslemInputlari.'
                        <tr>
                            <th colspan="5">Toplam</th>
                            <td colspan="2" id="yapilanIslemToplam">0 TL</td>
                        </tr>
                        <tr>
                            <th colspan="5">KDV</th>
                            <td colspan="2" id="yapilanIslemKdv">0 TL</td>
                        </tr>
                        <tr>
                            <th colspan="5">Genel Toplam</th>
                            <td colspan="2" id="yapilanIslemGenelToplam">0 TL</td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="form-group p-0 m-0 col">
                                    <textarea id="yapilan_islem_aciklamasi" autocomplete="off" name="yapilan_islem_aciklamasi" class="form-control" rows="3" placeholder="Yapılan işlem açıklaması"></textarea>
                                </div>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="medyalar" role="tabpanel" aria-labelledby="medyalar">
                <div id="dt-medyalar"></div>
                <div class="row text-center">
                  <div class="col-2"></div>
                  <div class="col-8">
                      <form id="dt-UploadForm" onsubmit="" enctype="multipart/form-data" method="post">
                          <div class="form-group">
                              <input type="file" name="yuklenecekDosya" id="yuklenecekDosya" required>
                          </div>
                          <div class="form-group">
                              <div class="progress" id="progressDiv">
                                  <progress id="progressBar" value="0" max="100" style="width:100%; height: 1.2rem;"></progress>
                              </div>
                          </div>
                          <div class="form-group">
                              <h3 id="durum"></h3>
                              <p id="yukleme_durumu"></p>
                          </div>
                      </form>
                      <div class="form-group">
                          <button id="medyaYukleBtn" class="btn btn-primary">Medya Yükle</button>
                      </div>
                      <div class="alert alert-info" role="alert">
                        Not: Medyaları düzenledikten sonra kaydet butonuna basmanıza gerek yoktur. Medyalar otomatik olarak kaydedilir.
                      </div>
                  </div>
                  <div class="col-2"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <a id="duzenleBtn" href="#" onclick="duzenleyiGoster()" style="{display_kilit}" class="btn btn-primary goster">Düzenle</a>
      <a id="kaydetBtn" href="#" onclick="detaylariKaydet()" style="display:none;" class="btn btn-success">Kaydet</a>
      <a id="iptalBtn" href="#" onclick="detaylariGoster()" style="display:none;" class="btn btn-danger">İptal</a>
      <a id="kargoBilgisiBtn" href="#" class="btn btn-dark text-white">Kargo Bilgisi Yazdır</a>
      <a id="serviskabulBtn" href="#" class="btn btn-dark text-white">Servis Kabul Formunu Yazdır</a>
      <a id="barkoduYazdirBtn" href="#" class="btn btn-dark text-white">Barkodu Yazdır</a>
      <a id="formuYazdirBtn" href="#" class="btn btn-dark text-white">Formu Yazdır</a>
      ' . ($silButonuGizle ? '' : '<a id="silBtn" href="#" style="{display_kilit}" class="btn btn-danger text-white">Sil</a>') . '
      <a id="kapatBtn" href="#" class="btn btn-secondary" data-dismiss="modal">Kapat</a>
      </div>
    </div>
  </div>
</div>';

$cihazSilModalOrnek = $silButonuGizle ? '' : '<script>
$(document).ready(function(){
    $("#cihaziSilModal").on("hidden.bs.modal", function (e) {
        $("#ServisNo4").html("");
        $("#MusteriAdi3").html("");
        $("#silOnayBtn").attr("onclick", "");
    });
});
</script>
<div class="modal fade" id="cihaziSilModal" tabindex="-1" role="dialog" aria-labelledby="cihaziSilModalLabel" aria-hidden="true">
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
        <button id="silOnayBtn" class="btn btn-success">Evet</button>
        <button class="btn btn-danger" data-dismiss="modal">Hayır</button>
      </div>
    </div>
  </div>
</div>';
$yapilanIslemlerSatiri = '<ul class="list-group list-group-horizontal">
<li class="list-group-item" style="width:' . $besliIlkOgeGenislik . ';">{islem}</li>
<li class="list-group-item" style="width:' . $besliIkinciOgeGenislik . ';">{miktar}</li>
<li class="list-group-item" style="width:' . $besliUcuncuOgeGenislik . ';">{fiyat} TL</li>
<li class="list-group-item" style="width:' . $besliBesinciOgeGenislik . ';">{toplam_islem_kdv} TL ({kdv_orani}%)</li>
<li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';">{toplam_islem_fiyati} TL</li>
<li class="list-group-item" style="width:' . $besliDorduncuOgeGenislik . ';">{toplam_islem_fiyati_kdvli} TL</li>
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
//$cihazlar = $sorumlu_belirtildimi ? $this->Cihazlar_Model->cihazlarTekPersonel($suankiPersonel) : $this->Cihazlar_Model->cihazlar();

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
  "{musteri_kod_onclick}",
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
  "{teslim_eden_onclick}",
  "{teslim_alan_onclick}",
  "{adres_onclick}",
  "{guncel_durum_onclick}",
  "{cihaz_turu_onclick}",
  "{cihaz_turu_val}",
  "{cihaz_turu_val_onclick}",
  "{cihaz_onclick}",
  "{cihaz_modeli_onclick}",
  "{teslim_alinanlar_onclick}",
  "{cihaz_sifresi_onclick}",
  "{cihaz_deseni_onclick}",
  "{cihazdaki_hasar_onclick}",
  "{hasar_tespiti_onclick}",
  "{ariza_aciklamasi_onclick}",
  "{servis_turu_onclick}",
  "{sorumlu_onclick}",
  "{sorumlu_val}",
  "{sorumlu_val_onclick}",
  "{yapilan_islem_aciklamasi_onclick}",
  "{tahsilat_sekli_onclick}",
  "{fatura_durumu_onclick}",
  "{fis_no_onclick}",
  "{takip_no}",
  "{seri_no_onclick}"
);

$yapilanIslemToplamEskiArray = array(
  "{toplam_aciklama}",
  "{toplam_fiyat}"
);
$yapilanIslemEskiArray = array(
  "{islem}",
  "{miktar}",
  "{fiyat}",
  "{toplam_islem_kdv}",
  "{toplam_islem_fiyati}",
  "{toplam_islem_fiyati_kdvli}",
  "{kdv_orani}"
);
function donusturOnclick($oge)
{
  return str_replace("'","\'",trim(preg_replace('/\s\s+/', '<br>', $oge)));
}

/*
foreach ($cihazlar as $cihaz) {
  $cDurumCh = $this->Cihazlar_Model->cihazDurumuBul($cihaz->guncel_durum);
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
        $kdv_suan,
        $toplam_islem_fiyati_suan,
        $toplam_islem_fiyati_suan + $kdv_suan,
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
    $cDurumCh->num_rows() > 0 ? $cDurumCh->result()[0]->renk : "bg-white",
    ($this->Cihazlar_Model->cihazDurumuKilitle($cihaz->guncel_durum) && !$this->Kullanicilar_Model->yonetici()) ? "display:none;" : "",
    $cihaz->servis_no,
    $cihaz->takip_numarasi,
    $cihaz->id,
    $cihaz->musteri_adi,
    isset($cihaz->musteri_kod) ? $cihaz->musteri_kod : "Yok",
    isset($cihaz->musteri_kod) ? donusturOnclick($cihaz->musteri_kod) : "Yok",
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
    $this->Cihazlar_Model->cihazDurumuIsım($cihaz->guncel_durum),
    $cihaz->guncel_durum,
    $cihaz->tahsilat_sekli,
    $this->Islemler_Model->faturaDurumu($cihaz->fatura_durumu),
    $cihaz->fis_no,
    $yapilanİslemler,
    donusturOnclick($cihaz->musteri_adi),
    donusturOnclick($cihaz->teslim_eden),
    donusturOnclick($cihaz->teslim_alan),
    donusturOnclick($cihaz->adres),
    donusturOnclick($this->Cihazlar_Model->cihazDurumuIsım($cihaz->guncel_durum)),
    donusturOnclick($cihaz->cihaz_turu),
    $cihaz->cihaz_turu_val,
    donusturOnclick($cihaz->cihaz_turu_val),
    donusturOnclick($cihaz->cihaz),
    donusturOnclick($cihaz->cihaz_modeli),
    donusturOnclick($cihaz->teslim_alinanlar),
    donusturOnclick($cihaz->cihaz_sifresi),
    donusturOnclick($cihaz->cihaz_deseni),
    donusturOnclick($this->Islemler_Model->cihazdakiHasar($cihaz->cihazdaki_hasar)),
    donusturOnclick($cihaz->hasar_tespiti),
    donusturOnclick($cihaz->ariza_aciklamasi),
    donusturOnclick($this->Islemler_Model->servisTuru($cihaz->servis_turu)),
    donusturOnclick($cihaz->sorumlu),
    $cihaz->sorumlu_val,
    donusturOnclick($cihaz->sorumlu_val),
    donusturOnclick($cihaz->yapilan_islem_aciklamasi),
    donusturOnclick($cihaz->tahsilat_sekli),
    donusturOnclick($this->Islemler_Model->faturaDurumu($cihaz->fatura_durumu)),
    donusturOnclick($cihaz->fis_no),
    $cihaz->takip_numarasi,
    donusturOnclick($cihaz->seri_no)
  );
  $tablo = str_replace($eskiler, $yeniler, $tabloOrnek);
  //echo $tablo;
}*/
echo '
</tbody>
</table>';
echo '</div>';
echo '<script>
    $(document).ready(function(){
        $("#dt_duzenle #telefon_numarasi, #yeniCihazForm #telefon_numarasi").inputmask("+99 (999) 999-9999");
    });
    </script>';
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
    foreach($cDurumlari as $cDurumu){
      echo '
      case '.$cDurumu->id.':
        return "'.$cDurumu->durum.'";';
    }
    echo '
      default:
        return "'.$this->Cihazlar_Model->cihazDurumuIsım(0).'";
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
    
    foreach($cDurumlari as $cDurumu){
      echo 'case '.$cDurumu->id.':
        return "'.$cDurumu->renk.'";';
    }
echo '
      default:
        return "bg-white";
    }
  }';


  echo 'function tarihDonusturSiralama(tarih) {
    var gun = tarih.slice(0, 2);
    var ay = tarih.slice(3, 5);
    var yil = tarih.slice(6, 10);
    var saat = tarih.slice(11, 16);
    return gun + "." + ay + "." + yil + " " + saat ;
  }';
  echo 'function tarihDonusturInput(tarih) {
      var gun = tarih.slice(0, 2);
      var ay = tarih.slice(3, 5);
      var yil = tarih.slice(6, 10);
      var saat = tarih.slice(11, 16);
      return yil + "-" + ay + "-" + gun + "T" + saat ;
    }';

echo '
function donusturOnclick(oge){
  if(oge){
    return oge.replaceAll(/(?:\r\n|\r|\n)/g, "<br>").replaceAll("\'", "\\\\\'");
  }else{
    return "";
  }
}
function donustur(str, value, yeni) {
    return str.
    replaceAll("{yeni}", yeni ? \' <span id="\' + value.id + \'Yeni" class="badge badge-danger">Yeni</span>\' : \'\')
      .replaceAll("{class}", cihazDurumuClass(value.guncel_durum))
      .replaceAll("{display_kilit}",  cihazKilitle(value.guncel_durum) ? "display:none;" : "")
      .replaceAll("{servis_no}", value.servis_no)
      .replaceAll("{id}", value.id)
      .replaceAll("{musteri_adi}", value.musteri_adi)
      .replaceAll("{musteri_kod}", value.musteri_kod ? value.musteri_kod : "Yok")
      .replaceAll("{musteri_kod_onclick}", value.musteri_kod ? donusturOnclick(value.musteri_kod) : "Yok")
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
      .replaceAll("{tahsilat_sekli}", value.tahsilat_sekli)
      .replaceAll("{fatura_durumu}", faturaDurumu(value.fatura_durumu))
      .replaceAll("{fis_no}", value.fis_no)
      .replaceAll("{yapilan_islemler}", \'' . $yapilanIslemlerSatiriBos . $toplam2 . $kdv2 . $genel_toplam2 . '\')
      .replaceAll("{musteri_adi_onclick}", donusturOnclick(value.musteri_adi))
      .replaceAll("{teslim_eden_onclick}", donusturOnclick(value.teslim_eden))
      .replaceAll("{teslim_alan_onclick}", donusturOnclick(value.teslim_alan))
      .replaceAll("{adres_onclick}", donusturOnclick(value.adres))
      .replaceAll("{guncel_durum_onclick}", donusturOnclick(cihazDurumu(value.guncel_durum)))
      .replaceAll("{cihaz_turu_onclick}", donusturOnclick(value.cihaz_turu))
      .replaceAll("{cihaz_turu_val}", value.cihaz_turu_val)
      .replaceAll("{cihaz_turu_val_onclick}", donusturOnclick(value.cihaz_turu_val))
      .replaceAll("{cihaz_onclick}", donusturOnclick(value.cihaz))
      .replaceAll("{cihaz_modeli_onclick}", donusturOnclick(value.cihaz_modeli))
      .replaceAll("{teslim_alinanlar_onclick}", donusturOnclick(value.teslim_alinanlar))
      .replaceAll("{cihaz_sifresi_onclick}", donusturOnclick(value.cihaz_sifresi))
      .replaceAll("{cihaz_deseni_onclick}", donusturOnclick(value.cihaz_deseni))
      .replaceAll("{cihazdaki_hasar_onclick}", donusturOnclick(cihazdakiHasar(value.cihazdaki_hasar)))
      .replaceAll("{hasar_tespiti_onclick}", donusturOnclick(value.hasar_tespiti))
      .replaceAll("{ariza_aciklamasi_onclick}", donusturOnclick(value.ariza_aciklamasi))
      .replaceAll("{servis_turu_onclick}", donusturOnclick(servisTuru(value.servis_turu)))
      .replaceAll("{sorumlu_onclick}", donusturOnclick(value.sorumlu))
      .replaceAll("{sorumlu_val}", value.sorumlu_val)
      .replaceAll("{sorumlu_val_onclick}", donusturOnclick(value.sorumlu_val))
      .replaceAll("{yapilan_islem_aciklamasi_onclick}", donusturOnclick(value.yapilan_islem_aciklamasi))
      .replaceAll("{tahsilat_sekli_onclick}", donusturOnclick(value.tahsilat_sekli))
      .replaceAll("{fatura_durumu_onclick}", donusturOnclick(faturaDurumu(value.fatura_durumu)))
      .replaceAll("{fis_no_onclick}", donusturOnclick(value.fis_no))
      .replaceAll("{takip_no}", value.takip_numarasi)
      .replaceAll("{seri_no_onclick}", donusturOnclick(value.seri_no));
  }';
echo 'function tarihiFormatla(tarih12){
  return (tarih12 < 10) ? "0" + tarih12 : tarih12;
}';
echo 'function spaniSil(veri){
  return veri.replace(/<\/?span[^>]*>/g, "");
}';
echo 'function cihazBilgileriniGetir(){
  if(suankiCihaz > 0){
    $.get(\'' . base_url("cihazyonetimi/tekCihazJQ") . '/\' + suankiCihaz + \'\', {})
      .done(function(data) {
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
            ';
            for($i = 1; $i <= $this->Islemler_Model->maxIslemSayisi; $i++){
              echo '
            $("#dt_duzenle input#yapilanIslem'.$i.'").val("").change();
            $("#dt_duzenle input#yapilanIslemMiktar'.$i.'").val("").change();
            $("#dt_duzenle input#yapilanIslemFiyat'.$i.'").val("").change();
            $("#dt_duzenle input#yapilanIslemKdv'.$i.'").val("").change();
            ';
            }
echo '

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
                  .replaceAll("{toplam_islem_kdv}", parseFloat(kdv_suan).toFixed(2))
                  .replaceAll("{toplam_islem_fiyati}", parseFloat(yapilan_islem_tutari_suan).toFixed(2))
                  .replaceAll("{toplam_islem_fiyati_kdvli}", parseFloat(yapilan_islem_tutari_suan + kdv_suan).toFixed(2))
                  .replaceAll("{kdv_orani}", islem.kdv);
                // Duzenleme
                var dz_islemSayisi = i + 1;
                $("#dt_duzenle input#yapilanIslem"+dz_islemSayisi).val(islem.ad).change();
                $("#dt_duzenle input#yapilanIslemMiktar"+dz_islemSayisi).val(islem.miktar).change();
                $("#dt_duzenle input#yapilanIslemFiyat"+dz_islemSayisi).val(islem.birim_fiyat).change();
                $("#dt_duzenle input#yapilanIslemKdv"+dz_islemSayisi).val(islem.kdv).change();
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
            //QRYenile(value.servis_no);
            $("#ServisNo2").html(value.servis_no);
            $("#TakipNo").html(value.takip_numarasi);
            $("#MusteriKod").html(value.musteri_kod ? value.musteri_kod : "Yok");
            $("#MusteriAdi2").html(value.musteri_adi);
            $("#TeslimEden2").html(value.teslim_eden);
            $("#TeslimAlan2").html(value.teslim_alan);
            $("#MusteriAdres").html(value.adres);
            $("#MusteriGSM2").html(value.telefon_numarasi);
            $("#GirisTarihi").html(value.tarih);
            $("#BildirimTarihi").html(value.bildirim_tarihi);
            $("#CikisTarihi").html(value.cikis_tarihi);
            $("#GuncelDurum2").html(cihazDurumu(value.guncel_durum));
            $("#CihazTuru2").html(value.cihaz_turu);
            $("#CihazMarka").html(value.cihaz);
            $("#CihazModeli").html(value.cihaz_modeli);
            $("#SeriNo").html(value.seri_no);
            $("#TeslimAlinanlar").html(value.teslim_alinanlar);
            if(value.cihaz_deseni.length > 0){
              dtBodyDesenP.setPattern(value.cihaz_deseni);
              $("#CihazDeseni").show();
              $("#CihazSifresi").hide();
              $("#CihazSifresi").html("");
            }else{
              $("#CihazSifresi").html(value.cihaz_sifresi);
              $("#CihazSifresi").show();
              $("#CihazDeseni").hide();
              dtBodyDesenP.clear();
            }
            $("#CihazdakiHasar").html(cihazdakiHasar(value.cihazdaki_hasar));
            $("#HasarTespiti").html(value.hasar_tespiti);
            $("#ArizaAciklamasi").html(value.ariza_aciklamasi);
            $("#ServisTuru").html(servisTuru(value.servis_turu));
            $("#YedekDurumu").html(evetHayir(value.yedek_durumu));
            $("#Sorumlu2").html(value.sorumlu);
            $("#yapilanIslemAciklamasi").html(value.yapilan_islem_aciklamasi);
            $("#TahsilatSekli").html(value.tahsilat_sekli);
            $("#faturaDurumu").html(faturaDurumu(value.fatura_durumu));
            $("#fisNo").html(value.fis_no);
            medyalariYukle(value.id);
            
            // Düzenleme
            $("#dt_duzenleForm").attr("action", "' . base_url("cihaz/duzenle/") . '/" + value.id + "/post");
            $("#dt-YapilanIslemlerForm").attr("action", "' . base_url("cihaz/yapilanIslemDuzenle") . '/" + value.id + "/post");
            $("#medyaYukleBtn").attr("onclick", "dosyaYukle("+value.id+", function(){medyalariYukle("+value.id+")})");
            $("#dt_duzenle input#musteri_kod").val(value.musteri_kod);
            $("#dt_duzenle input#musteri_adi2").val(value.musteri_adi);
            $("#dt_duzenle #TeslimAlan").html(value.teslim_alan);
            $("#dt_duzenle input#teslim_eden").val(value.teslim_eden);
            $("#dt_duzenle input#adres").val(value.adres);
            if(value.telefon_numarasi.length>0){
              $("#dt_duzenle input#telefon_numarasi").val(value.telefon_numarasi);
            }else{
              $("#dt_duzenle input#telefon_numarasi").val("+90");
            }
            $("#dt_duzenle select#cihaz_turu").val(value.cihaz_turu_val).change();
            if(yonetici){
              $("#dt_duzenle select#sorumlu").val(value.sorumlu_val).change();
            }else{
              $("#dt_duzenle #dz-sorumlu-personel").html(value.sorumlu);
            }
            $("#dt_duzenle input#cihaz").val(value.cihaz);
            $("#dt_duzenle input#cihaz_modeli").val(value.cihaz_modeli);
            $("#dt_duzenle input#seri_no").val(value.seri_no);
            $("#dt_duzenle input#cihaz_sifresi").val(value.cihaz_sifresi);

            var sifreVar = false;
            if(value.cihaz_deseni.length > 0){
              $("#dt_duzenle select#sifre_turu").val("Desen").change();

              dt_duzenleDesenP.setPattern(value.cihaz_deseni);
              $("#dt_duzenle input#cihaz_deseni").val(value.cihaz_deseni);

              sifreVar = true;
            }else{
              $("#dt_duzenle input#cihaz_deseni").val("");
            }
            if(value.cihaz_sifresi.length > 0 && value.cihaz_sifresi != "Yok"){
              $("#dt_duzenle select#sifre_turu").val("Pin").change();
              $("#dt_duzenle input#cihaz_sifresi").val(value.cihaz_sifresi);
              sifreVar = true;
            }else{
              $("#dt_duzenle input#cihaz_sifresi").val("");
            }
            if(!sifreVar){
              $("#dt_duzenle select#sifre_turu").val("Yok").change();
            }
            $("#dt_duzenle select#cihazdaki_hasar").val(value.cihazdaki_hasar).change();
            $("#dt_duzenle textarea#hasar_tespiti").val(value.hasar_tespiti);
            $("#dt_duzenle textarea#ariza_aciklamasi").val(value.ariza_aciklamasi);
            $("#dt_duzenle textarea#teslim_alinanlar").val(value.teslim_alinanlar);
            $("#dt_duzenle select#servis_turu").val(value.servis_turu).change();
            $("#dt_duzenle select#yedek_durumu").val(value.yedek_durumu).change();
            $("#dt_duzenle input#dz-tarih").val(tarihDonusturInput(value.tarih));
            $("#dt_duzenle input#bildirim_tarihi").val(tarihDonusturInput(value.bildirim_tarihi));
            bildirim_tarih_durumu_duzenle(false);
            $("#dt_duzenle input#cikis_tarihi").val(tarihDonusturInput(value.cikis_tarihi));
            $("#dt_duzenle select#guncel_durum").val(value.guncel_durum).change();
            $("#dt_duzenle select#tahsilat_sekli").val(value.tahsilat_sekli_val).change();
            $("#dt_duzenle select#fatura_durumu").val(value.fatura_durumu).change();
            $("#dt_duzenle input#fis_no").val(value.fis_no);
            $("#dt_duzenle textarea#yapilan_islem_aciklamasi").val(value.yapilan_islem_aciklamasi);
            $("#duzenleBtn").prop("disabled", false);
            $("#silBtn").prop("disabled", false);
          }
        });
      }).fail(function(xhr, status, error) {
        $("#duzenleBtn").prop("disabled", false);
        $("#silBtn").prop("disabled", false);
      }); 
  }
}';
$ayarlar = $this->Ayarlar_Model->getir();
echo '
            function yukleniyorGuncelle(durum){
              $("#percentagePath").attr("stroke-dasharray", durum + ", 100");
              $("#percentageText").html(durum + "%");
            }
    var tabloDiv = "#cihaz_tablosu";
    var cihazlarTablosu = $(tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari("[[ 6, \"asc\" ], [ 5, \"desc\" ]]", "false", ' 
    "processing": true,
    "aoColumns": [
      null,
      null,
      null,
      null,
      null,
      { "sType": "date-tr" },
      { "sType": "status-tr" },
      null,
      null
    ],'
    , "", FALSE, 
      array(
        '{
          "targets": \'no-sort\',
          "orderable": false,
        }'
      )) . ');
              var cihazlarSayfa = 0;
              var cihazlarArama = "";
              var cihazlariGetirPost;
              var sayfalariGuncellePost;
              var cihazlarOrderIsim = "";
              var cihazlarOrderDurum = "";
              var cihazlarDurumSpec = "";
              var cihazlarTurSpec = "";
              function sayfaButonuGetir(sayfa, aktif, devredisi, tiklanabilir, text, arama){
                return \'<li class="paginate_button page-item\'+( aktif ? " active" : "" )+\'\'+( devredisi ? " disabled" : "" )+\'"><a href="javascript:void(0)"\' + ( tiklanabilir ? \' onclick="cihazlariGetir(\'+sayfa+\', \\\'\'+donusturOnclick(arama)+\'\\\', kaydirmaDurumu, cihazlarOrderIsim, cihazlarOrderDurum, cihazlarDurumSpec, cihazlarTurSpec)"\' : "" ) + \' class="page-link">\'+text+\'</a></li>\';;
              }
              function sayfalariGuncelle(sayfa, arama, durumSpec, turSpec){
                if (sayfalariGuncellePost !== undefined)
                {
                  sayfalariGuncellePost.abort();
                }
                sayfalariGuncellePost = $.post(\'' . base_url(($sorumlu_belirtildimi ? "cihazlarim" : "cihazyonetimi") . "/cihazlarTumuSayi/") . '\', {
                    arama: arama,
                    durumSpec: durumSpec,
                    turSpec: turSpec,
                }, function(data) {
                      var toplamCihaz = parseInt(data);

                      var butonlar = sayfaButonuGetir(sayfa - 1, false, sayfa == 1, sayfa != 1, "Önceki", arama);

                      if(toplamCihaz >0){
                        var toplamSayfa = Math.ceil(toplamCihaz / '.$ayarlar->tablo_oge.');
  
                        var peginationDiv = function(ekDiv){
                          return \'<div class="dataTables_paginate paging_simple_numbers"><ul class="pagination\'+ekDiv+\'"></ul></div>\';
                        }
                        $("#cihazlar_pegination1 > div:last-child").html(peginationDiv(" ust"));
                        //$("#cihazlar_pegination2 > div:last-child").html(peginationDiv(""));
                      
                        
                        if(sayfa <= 4 && toplamSayfa > 7){
                          for (let i = 1; i <= 5; i++) {
                            butonlar += sayfaButonuGetir(i, sayfa == i, false, sayfa != i, i, arama);
                          }
                          butonlar += sayfaButonuGetir(0, false, true, false, "…", arama);
                          butonlar += sayfaButonuGetir(toplamSayfa, sayfa == toplamSayfa, false, sayfa != toplamSayfa, toplamSayfa, arama);
                        }else if(toplamSayfa - sayfa < 4 && toplamSayfa > 7){
                          butonlar += sayfaButonuGetir(1, sayfa == 1, false, sayfa != 1, 1, arama);
                          butonlar += sayfaButonuGetir(0, false, true, false, "…", arama);
                          for (let i = toplamSayfa - 4; i <= toplamSayfa; i++) {
                            butonlar += sayfaButonuGetir(i, sayfa == i, false, sayfa != i, i, arama);
                          }
                        }else if(toplamSayfa - sayfa >= 4 && sayfa >= 4){
                          butonlar += sayfaButonuGetir(1, false, false, sayfa != 1, 1, arama);
                          butonlar += sayfaButonuGetir(0, false, true, false, "…", arama);
                          for (let i = sayfa - 1; i <= sayfa + 1; i++) {
                            butonlar += sayfaButonuGetir(i, sayfa == i, false, sayfa != i, i, arama);
                          }
                          butonlar += sayfaButonuGetir(0, false, true, false, "…", arama);
                          butonlar += sayfaButonuGetir(toplamSayfa, false, false, sayfa != toplamSayfa, toplamSayfa, arama);
                        }else{
                          for (let i = 1; i <= toplamSayfa; i++) {
                            butonlar += sayfaButonuGetir(i, sayfa == i, false, sayfa != i, i, arama);
                          }
                        }
                      }else{
                        //$("#cihazlar_pegination2 > div:first-child").html(\'<div class="dataTables_info">Kayıt Yok</div>\');
                      }
                      $("#cihazlar_pegination2").html("");
                      
                      var sonuc_bilgisi = \'<div class="dataTables_info">\';
                      if (toplamCihaz > 0){
                        sonuc_bilgisi += toplamCihaz + \' kayıttan \'+(((sayfa - 1) * '.$ayarlar->tablo_oge.') + 1)+\' - \'+(sayfa * '.$ayarlar->tablo_oge.')+\' arasındaki kayıtlar gösteriliyor\';
                        
                        butonlar += sayfaButonuGetir(sayfa + 1, false, sayfa == toplamSayfa, sayfa != toplamSayfa, "Sonraki", arama);
                        
                      }else{
                        //$("#cihazlar_pegination1 > div:last-child").html("");
                        sonuc_bilgisi += \'Kayıt Yok\';
                        butonlar += sayfaButonuGetir(1, true, false, false, 1, arama);
                        butonlar += sayfaButonuGetir(sayfa + 1, false, sayfa == 1, sayfa != 1, "Sonraki", arama);
                      }
                      sonuc_bilgisi += \'</div>\';


                      $("#cihazlar_pegination1 > div:first-child").html(sonuc_bilgisi);
                      //$("#cihazlar_pegination2 > div:first-child").html(sonuc_bilgisi);

                      $(".dataTables_paginate .pagination").each(function(){
                        var div = $(this);
                        if(div.hasClass("ust")){
                          $(this).html(butonlar.replaceAll("kaydirmaDurumu", "false"));
                        }else{
                          $(this).html(butonlar.replaceAll("kaydirmaDurumu", "true"));
                        }
                      });
                });
              }
              
              function cihazlariGetir(sayfa, arama, kaydir, orderIsim, orderDurum, durumSpec, turSpec){     
                if (cihazlariGetirPost !== undefined)
                {
                  cihazlariGetirPost.abort();
                }
                $(".datatable_processing").css("height", $("#cihazlar_main > div:first-child").height());
                $(".datatable_processing").show();
                cihazlarOrderIsim = orderIsim;
                cihazlarOrderDurum = orderDurum;
                cihazlarDurumSpec = durumSpec;
                cihazlarTurSpec = turSpec;
                cihazlariGetirPost = $.post(\'' . base_url(($sorumlu_belirtildimi ? "cihazlarim" : "cihazyonetimi") . "/cihazlarTumuJQ/") . '\', {
                    limit: '.$ayarlar->tablo_oge.',
                    sayfa: sayfa,
                    arama: arama,
                    orderIsim: orderIsim, 
                    orderDurum: orderDurum,
                    durumSpec: durumSpec,
                    turSpec: turSpec,
                }).done(function(data) {
                  sayfalariGuncelle(sayfa, arama, durumSpec, turSpec);
                  cihazlarSayfa = sayfa;
                  cihazlarTablosu.clear().draw();
                  $.each(JSON.parse(data), function(index, value) {
                    //cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
                    let tabloOrnek = \'' . $tabloOrnek . '\';
                    const tablo = donustur(tabloOrnek, value, false);
                    cihazlarTablosu.row.add($(tablo));
                  });
                  $("#yukleniyorDaire").hide();
                  $("#cihazTablosu").show();
                  cihazlarTablosu.draw();
                  cihazlarTablosu.columns.adjust();
                  $(".datatable_processing").hide();
                  if(kaydir){
                    $("html, body").scrollTop($(document).height()-$(window).height());
                  }
                }).fail(function(xhr, status, error) {
                  $(".datatable_processing").hide();
                });
              }
              function cihazDropdownActive(parent, current){
                $(parent).each(function( index ) {
                  cihazDropdownActiveNext(this, current);
                });
              }
              function cihazDropdownActiveNext(parent, current){
                $(parent).children("li").each(function() { 
                  if($(this).hasClass("active"))
                  {
                    $(this).removeClass("active"); 
                  }
                  if($(this).hasClass(current.replaceAll(".",""))){
                    $(current).addClass("active");
                  }
                });
              }
              function siralamaGuncelle(div, sira){
              
                var orderIsim = div.text();
                if(orderIsim == "Detaylar"){
                  return;
                }
                var desc = div.hasClass("sorting_asc");

                $(".sorting").each(function() {
                  //$(this).removeClass("sorting_asc"); // yukari
                  //$(this).removeClass("sorting_desc");
                });
                if(desc){
                  //div.addClass("sorting_desc");
                  orderDurum = "DESC";
                }else{
                  //div.addClass("sorting_asc");
                  orderDurum = "ASC";
                }
                var od = [ sira, orderDurum.toLowerCase()];
                cihazlarTablosu.order(od).draw();
                cihazlariGetir(cihazlarSayfa, cihazlarArama, false, orderIsim, orderDurum, cihazlarDurumSpec, cihazlarTurSpec);
              }
';
echo '$(document).ready(function() {
            cihazlariGetir(1, "", false, cihazlarOrderIsim, cihazlarOrderDurum, cihazlarDurumSpec, cihazlarTurSpec);
            $("#cihazlar_main").append(\'<div class="datatable_processing"></div>\');
            $(".datatable_processing").html(\'<div class="flex-wrapper" style="margin: auto;"><div class="yukleniyorDaire"></div></div>\');
            $(".datatable_processing").css("background", "rgba(255, 255, 255, 0.4)");
            $(".datatable_processing").css("position", "absolute");
            $(".datatable_processing").css("display", "flex");
            $(".datatable_processing").css("top", $(".dataTables_paginate .pagination").height());
            $(".datatable_processing").css("left", "0");
            $(".datatable_processing").css("width", "100%");
            $(".datatable_processing").hide();

            $("#cihaz_tablosu_ara").on("keyup", function(e) {
                var k = e.keyCode;
                if (k == 20 /* Caps lock */
                    || k == 16 /* Shift */
                    || k == 9 /* Tab */
                    || k == 27 /* Escape Key */
                    || k == 17 /* Control Key */
                    || k == 91 /* Windows Command Key */
                    || k == 19 /* Pause Break */
                    || k == 18 /* Alt Key */
                    || k == 93 /* Right Click Point Key */
                    || ( k >= 35 && k <= 40 ) /* Home, End, Arrow Keys */
                    || k == 45 /* Insert Key */
                    || ( k >= 33 && k <= 34 ) /*Page Down, Page Up */
                    || (k >= 112 && k <= 123) /* F1 - F12 */
                    || (k >= 144 && k <= 145 )) { /* Num Lock, Scroll Lock */
                        return;
                }
                        
                cihazlarArama = $("#cihaz_tablosu_ara").val();
                cihazlariGetir(1, cihazlarArama, false, cihazlarOrderIsim, cihazlarOrderDurum, cihazlarDurumSpec, cihazlarTurSpec);
            });
            var orderSira = 0;
        $(".sorting").each(function() {
            var el = $(this);
            var sira = orderSira;
            $(this).off("click").on("click", function(){
              siralamaGuncelle(el, sira);
            });
            orderSira++;
        });
        $("#cihaz_tablosu_ara").keyup(function(){
        
            
        });
    $(document).on("show.bs.modal", ".modal", function() {
      const zIndex = 1040 + 10 * $(".modal:visible").length;
      $(this).css("z-index", zIndex);
      setTimeout(() => $(".modal-backdrop").not(".modal-stack").css("z-index", zIndex - 1).addClass("modal-stack"));
    });
    $(document).on("hidden.bs.modal", ".modal", function() {
      if($(".modal:visible").length > 0){
        $("body").addClass("modal-open");
      }
    });
    $(window).on("resize", function(){
      $("#cihazlar tr.child").each(function(){
        $(this).remove();
      });
      $("#cihazlar tr").each(function(){
        if($(this).hasClass("dt-hasChild")){
          $(this).removeClass("dt-hasChild");
        }
        if($(this).hasClass("parent")){
          $(this).removeClass("parent");
        }
      });
    });
    ';
  
    echo '
    var cihazDurumuSiralama = [ 
      ';
      for($i = 0; $i < count($cDurumlari); $i++){
        echo '"' . $cDurumlari[$i]->durum . '"';
        if ($i < count($cDurumlari) - 1) {
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
                          return "status-tr";
                      }
                  }
                  i++;
              }
          }
      }
      return null;
    });
    $.extend( $.fn.dataTable.ext.type.order, {
      "status-tr-pre": function ( name ) {
          var cihazDurumuSiralamaNo = 0;
          name = spaniSil(name);
          ';
for ($i = 0; $i < count($cDurumlari); $i++) {

  echo ($i > 0 ? "else " : "") . 'if (name == "' . $cDurumlari[$i]->durum . '") {
              cihazDurumuSiralamaNo = ' . $cDurumlari[$i]->siralama . ';
            }';
}
echo '
          return cihazDurumuSiralamaNo;
      },
      "status-tr-asc": function ( a, b ) {
              return a - b;
      },
      "status-tr-desc": function ( a, b ) {
              return b - a;
      },
      "date-tr-pre": function ( name ) {
        name = spaniSil(name);
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
    function classlariGuncelle(className, cnt){
      $("."+className).each(function () {
        $(this).html(cnt);
      });
    }
    function verileriGuncelle(){
      cihazBilgileriniGetir();
      $.get(\'' . base_url("cihazyonetimi/silinenCihazlariBul") . '\', {}, function(data) {
        $.each(JSON.parse(data), function(index, value) {
          const cihazVarmi = document.querySelectorAll(
            "#cihaz" + value.id
          ).length > 0;
          if (cihazVarmi) {
            cihazlariGetir(cihazlarSayfa, cihazlarArama, false, cihazlarOrderIsim, cihazlarOrderDurum, cihazlarDurumSpec, cihazlarTurSpec);
            if(suankiCihaz == value.id && $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").hasClass("show")){
              $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . '").modal("hide");
              $("#cihaziSilModal").modal("hide");
              $("#cihazSilindiModal").modal("show");
            }
            //cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
          }
        });
      });
      $.get(\'' . base_url("cihazyonetimi" . "/sonCihazJQ/") . '\', {}, function(data) {
        sayac = 0;
        $.each(JSON.parse(data), function(index, value) {
          if (sayac == 0) {
            sonCihazID = value.id;
          }
          sayac++;
        });
      });
      var gorunenCihazlarIDs = [];
      $("#cihazlar tr").each(function() {
        var cID = $(this).data("cihazid");
        if(cID !== undefined){
          gorunenCihazlarIDs.push(cID);
        }
      });
      if(gorunenCihazlarIDs.length > 0){
        $.post(\'' . base_url("cihazyonetimi" . "/cihazlarTumuJQ/") . '\', {spesifik:gorunenCihazlarIDs}, function(data) {
          $.each(JSON.parse(data), function(index, value) {
            const cihazVarmi = document.querySelectorAll(
              "#cihaz" + value.id
            ).length > 0;
            if (cihazVarmi) {
              let cihazDetayBtnOnclick = \'' . $cihazDetayBtnOnclick . '\';
              const cihazDetayBtn = donustur(cihazDetayBtnOnclick, value, true);
              $("button[id^=\'cihazDetayBtn"+value.id+"\']").each(function () {
                $(this).attr("onclick", cihazDetayBtn);
              });
              $("#' . $this->Cihazlar_Model->cihazDetayModalAdi() . 'Btn" + value.id).attr("onClick", cihazDetayBtn);
              $("#cihaz" + value.id).attr(\'class\', \'\');
              $("#cihaz" + value.id).addClass(cihazDurumuClass(value.guncel_durum));
              $("#" + value.id + "ServisNo3").html(value.servis_no);
              //$("." + value.id + "ServisNo").html(value.servis_no);
              classlariGuncelle(value.id + "ServisNo", value.servis_no);
              //$("." + value.id + "MusteriAdi").html(value.musteri_adi);
              classlariGuncelle(value.id + "MusteriAdi", value.musteri_adi);
              //$("." + value.id + "CihazTuru").html(value.cihaz_turu);
              classlariGuncelle(value.id + "CihazTuru", value.cihaz_turu);
              //$("." + value.id + "Sorumlu").html(value.sorumlu);
              classlariGuncelle(value.id + "Sorumlu", value.sorumlu);
              //$("." + value.id + "Cihaz").html(value.cihaz + " " + value.cihaz_modeli);
              classlariGuncelle(value.id + "Cihaz", value.cihaz + " " + value.cihaz_modeli);
              //$("." + value.id + "GuncelDurum").html(cihazDurumu(value.guncel_durum));
              classlariGuncelle(value.id + "GuncelDurum", cihazDurumu(value.guncel_durum));
              //$("." + value.id + "MusteriGSM").html(value.telefon_numarasi);
              classlariGuncelle(value.id + "MusteriGSM", value.telefon_numarasi);
              //$("." + value.id + "Tarih2").html(tarihDonusturSiralama(value.tarih));
              classlariGuncelle(value.id + "Tarih2", tarihDonusturSiralama(value.tarih));';
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
        //console.log(gorunenCihazlarIDs.length + " cihaz güncellendi");
      }else{
        //console.log("Güncellenecek cihaz yok");
      }
      $.get(\'' . base_url(($sorumlu_belirtildimi ? "cihazlarim" : "cihazyonetimi") . "/cihazlarJQ/") . '\' + sonCihazID, {}, function(data) {
        $.each(JSON.parse(data), function(index, value) {
            const cihazVarmi = document.querySelectorAll(
            "#cihaz" + value.id
          ).length > 0;
          if (!cihazVarmi && cihazlarArama.length == 0 && cihazlarSayfa == 1) {
            //cihazlarTablosu.row($("#cihaz" + value.id)).remove().draw();
            let tabloOrnek = \'' . $tabloOrnek . '\';
            
            const tablo = donustur(tabloOrnek, value, true);
            cihazlarTablosu.row.add($(tablo)).draw();
            //$("#cihazlar").prepend(tablo);
          }
        });
      });
    }
    var sonGuncelleme = '.time().';
    setInterval(() => {
      if(!duzenleme_modu && !yeniCihazGirisiAcik){
        verileriGuncelle();
        /*$.get(\'' . base_url("cihazyonetimi/veriGuncellendi") . '\', {}).done(function(data) {
          var guncellenenVeri = JSON.parse(data);
          if(guncellenenVeri.guncelleme_tarihi > sonGuncelleme){
            sonGuncelleme = guncellenenVeri.guncelleme_tarihi;
            verileriGuncelle();
          }
        });*/
        //console.log("Veriler güncellendi");
      }else{
        //console.log("Yeni Cihaz Girişi Modalı açık olduğu için veriler güncellenmedi");
      }
    }, 5000);
    $("#'.$this->Cihazlar_Model->cihazDetayModalAdi().'").on("hidden.bs.modal", function (e) {
      detaylariGoster();
    });
    $("#statusErrorsModal").on("hidden.bs.modal", function(e) {
      $("#hata-mesaji").html("");
    });
    $("#statusSuccessModal").on("hidden.bs.modal", function(e) {
      $("#basarili-mesaji").html("");
    });
    
  });
</script>';
echo $cihazDetayOrnek;
echo $cihazSilModalOrnek;
echo '
<script>
$(document).ready(function(){
    $("#teslimAlanModal").on("hidden.bs.modal", function (e) {
        $("#teslim_alan_form").val("");
    });
});
</script>
<div class="modal fade" id="teslimAlanModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="teslimAlanModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="teslimAlanModalLabel">Teslim Alan Müşteri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
        <h6 class="col">Belirtmek istemiyorsanız boş bırakabilirsiniz.</h6>
      </div>';
      echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="teslim_alan_form" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" placeholder="Teslim Alan Müşteri" value="">

</div>';
      echo '
      </div>
      <div class="modal-footer">
        <button id="teslimAlanYazdir" type="button" class="btn btn-success">Yazdır</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">İptal</button>
      </div>
    </div>
  </div>
</div>';
echo '
<div class="modal fade" id="cihazSilindiModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="cihazSilindiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cihazSilindiModalLabel">Cihaz Silindi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Cihaz bir kullanıcı tarafından silindiği için cihaz detaylarına erişilemiyor.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>';


$this->load->view("inc/modal_medyasil");
