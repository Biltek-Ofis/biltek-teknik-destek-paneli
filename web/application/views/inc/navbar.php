<?php
$ayarlar = $this->Ayarlar_Model->getir();

$tema = $this->Ayarlar_Model->kullaniciTema();
$asilTema = $this->Ayarlar_Model->kullaniciAsilTema();
$kullanicibilgileri123 = $this->Kullanicilar_Model->kullaniciBilgileri();
?>
<script>

  var maliyetiGoster = false;
  var maliyetBoyutFonksiyon = null;
  
  function maliyetGoster(durum) {
    maliyetiGoster = durum;
    maliyetDurumuGuncelle();
  }
  function maliyetDurumuGuncelle() {
    if (maliyetiGoster) {
      $(".maliyet").show();
      $("#maliyetGosterButon1Icon, #maliyetGosterButon2Icon").removeClass("fa-eye-slash");
      $("#maliyetGosterButon1Icon, #maliyetGosterButon2Icon").addClass("fa-eye");
    } else {
      $(".maliyet").hide();
      $("#maliyetGosterButon1Icon, #maliyetGosterButon2Icon").removeClass("fa-eye");
      $("#maliyetGosterButon1Icon, #maliyetGosterButon2Icon").addClass("fa-eye-slash");
    }
    if(maliyetBoyutFonksiyon != null){
      maliyetBoyutFonksiyon();
    }
  }
  $(document).ready(function () {
    maliyetGoster(false);
    function toggleDropdown(e) {
      const _d = $(e.target).closest(".dropdown"),
        _m = $(".dropdown-menu", _d)
      setTimeout(
        function () {
          const shouldOpen = e.type !== "click" && _d.is(":hover")
          _m.toggleClass("show", shouldOpen)
          _d.toggleClass("show", shouldOpen)
          $("[data-bs-toggle=\'dropdown\']", _d).attr("aria-expanded", shouldOpen)
        },
        e.type === "mouseleave" ? 300 : 0
      )
    }

    $("body")
      .on("mouseenter mouseleave", ".dropdown", toggleDropdown)
      .on("click", ".dropdown-menu a", toggleDropdown);
  });
</script>
<style>
  .dropdown:hover>.dropdown-menu,
  .dropdown-menu:hover {
    /*display: block;*/
  }
</style>
<?php
$detect = new Mobile_Detect();
if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
  ?>
  <div class="w-100 bg-success text-center">
    <a href="<?= base_url("app/android"); ?>" target="_blank"><img style="width:calc(100% / 3)"
        src="<?= base_url("dist/img/app/google-play.png"); ?>" /></a><?php
        
        
  if(strlen(MOBIL_SURUM_URL) > 0){
    ?>
    veya <a href="<?= base_url("m"); ?>">Mobil Sürüme Geç</a>
    <?php
  }
  ?>
        
  </div>
  <?php
}
?>
<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= base_url(); ?>"> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link<?= $aktifSayfa == "cihazyonetimi" || $aktifSayfa == "anasayfa" ? ' active" aria-current="page' : ''; ?>"
            href="<?= base_url(); ?>">
            Anasayfa
          </a>
        </li>
        <?php
        if ($kullanicibilgileri123["teknikservis"] == 1) {
          ?>
          <li class="nav-item">
            <a class="nav-link<?= $aktifSayfa == "cihazlarim" ? ' active" aria-current="page' : ''; ?>"
              href="<?= base_url("cihazlarim"); ?>">
              Cihazlarım
            </a>
          </li>
          <?php
        }
        if($this->Giris_Model->kullaniciGiris()){
        ?>
        <li class="nav-item">
          <a class="nav-link<?= $aktifSayfa == "malzemeteslimi" ? ' active" aria-current="page' : ''; ?>"
            href="<?= base_url("malzemeteslimi"); ?>">
            Malzeme Teslimi
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= $aktifSayfa == "cagri_kaydi" || $aktifSayfa == "cagri_kaydi_detay" ? ' active" aria-current="page' : ''; ?>"
            href="<?= base_url("cagrikayitlari"); ?>">
            Çağrı Kayıtları
          </a>
        </li>
        <?php
        }
        if ($kullanicibilgileri123["yonetici"] == 1) {
          ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle<?= ($aktifSayfa == "yonetim/kullanicilar"
              || $aktifSayfa == "yonetim/yoneticiler"
              || $aktifSayfa == "yonetim/personel"
              || $aktifSayfa == "yonetim/cihaz_turleri"
              || $aktifSayfa == "yonetim/cihaz_durumlari"
              || $aktifSayfa == "yonetim/tahsilat_sekilleri"
              || $aktifSayfa == "yonetim/musteriler"
              || $aktifSayfa == "yonetim/rapor"
              || $aktifSayfa == "yonetim/ayarlar") ? ' active" aria-current="page' : ""; ?>" href="#" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Yönetim
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/kullanicilar" || $aktifSayfa == "yonetim/yoneticiler" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/yoneticiler"); ?>">
                  Yönetici Hesapları
                </a>
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/personel" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/personel"); ?>">
                  Personel Hesapları
                </a>
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/musteri_hesaplari" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/musteri_hesaplari"); ?>">
                  Müşteri Hesapları
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/cihaz_turleri" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/cihaz_turleri"); ?>">
                  Cihaz Türleri
                </a>
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/cihaz_durumlari" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/cihaz_durumlari"); ?>">
                  Cihaz Durumları
                </a>
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/tahsilat_sekilleri" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/tahsilat_sekilleri"); ?>">
                  Tahsilat Şekilleri
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/musteriler" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/musteriler"); ?>">
                  Müşteriler
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/rapor" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/rapor"); ?>">
                  Rapor
                </a>
              </li>
              <li>
                <a class="dropdown-item<?= $aktifSayfa == "yonetim/ayarlar" ? ' active" aria-current="page' : ""; ?>"
                  href="<?= base_url("yonetim/ayarlar"); ?>">
                  Ayarlar
                </a>
              </li>
            </ul>
          </li>
          <?php
        }
        if($this->Giris_Model->kullaniciGiris()){
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            İşlemler
          </a>
          <ul class="dropdown-menu">
            <!--<li>
              <a class="dropdown-item" href="https://github.com/ozayakcan/biltek-teknik-destek-paneli/releases"
                target="_blank">
                Barkod Okuyucu Programı İndir
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?= base_url(" urunler/komisyon"); ?>" target="_blank">
                Komisyon Oranlarını İndir
              </a>
            </li>-->
            
            <li>
              <a class="dropdown-item" target="_blank" href="<?=base_url("app/biltekdesk");?>">
                BiltekDesk Programını İndir
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#" onclick="ozelBarkodYazdirPencere();">
                Özel Barkod Yazdır
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#" onclick="bosTeknikServisFormuYazdir();">
                Boş Teknik Servis Formu Yazdır
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#" onclick="bosMalzemeTeslimiFormuYazdir();">
                Boş Malzeme Teslimi Formu Yazdır
              </a>
            </li>
          </ul>
        </li>
        
        <?php
        }
        ?>
      </ul>
      <form class="d-flex" role="search">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a href="<?= base_url("kullanici"); ?>" class="nav-link"><?= $kullanicibilgileri123["ad_soyad"]; ?></a>
          </li>
          <li class="nav-item align-items-center d-flex">
          <i class="fas fa-sun"></i>
            <!-- Default switch -->
            <div class="ms-2 form-check form-switch">
              <input id="karanlikTema" class="form-check-input" type="checkbox" role="switch" />
            </div>
            <i class="fas fa-moon"></i>
          </li>
          <!--<li class="nav-item">
              <a class="nav-link" href="#" role="button" data-bs-toggle="modal" data-bs-target="#temaSecModal">
                <i class="fa-brands fa-themeisle"></i> Tema
              </a>
          </li>-->
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url("cikis"); ?>" role="button">
              <i class="fas fa-right-from-bracket"></i>
            </a>
          </li>
        </ul>
      </form>
    </div>
  </div>
</nav>
<div class="modal fade" id="temaSecModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="temaSecModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="temaSecModalTitle">Tema Seç</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <style>
          .siteTema {
            cursor: pointer;
          }
        </style>
        <div class="row">
          <div class="col-4">
            <a href="<?= base_url("kullanici/tema/0"); ?>">
              <div class="col-2 siteTema">
                <img src="<?= base_url("dist/img/temalar/" . $this->Ayarlar_Model->siteTema()->onizleme_resmi); ?>"
                  width="200" heigh="100" />
              </div>
              <div class="col-10 text-center">
                <input type="radio" <?= ($asilTema->id == 0 || $asilTema->id == "0" ? " checked" : ""); ?> /> Otomatik
                (Sitenin Güncel Teması)
              </div>
            </a>
          </div>
          <?php
          $temalar = $this->Ayarlar_Model->temalar();
          foreach ($temalar as $gosterimTema) {
            ?>
            <div class="col-4 siteTema">
              <a href="<?= base_url("kullanici/tema/" . $gosterimTema->id); ?>">
                <div class="col-2 siteTema">
                  <img src="<?= base_url("dist/img/temalar/" . $gosterimTema->onizleme_resmi); ?>" width="200"
                    heigh="100" />
                </div>
                <div class="col-10 text-center">
                  <input type="radio" <?= ($tema->id == $gosterimTema->id ? " checked" : ""); ?> />
                  <?= $gosterimTema->isim; ?>
                </div>
              </a>
            </div>
            <?php
          }
          ?>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>
<script>

  function bosTeknikServisFormuYazdir() {
    var url = "<?= base_url("cihaz/teknik_servis_formu/yazdir"); ?>/";
    bosTeknikServisFormuPencere = window.open(
      url,
      "bosTeknikServisFormuPencere",
      'status=1,width=' + screen.availWidth + ',height=' + screen.availHeight
    );
    $(bosTeknikServisFormuPencere).ready(function () {
      //bosTeknikServisFormuPencere.print();
    });
  }
  function bosMalzemeTeslimiFormuYazdir() {
    var url = "<?= base_url("malzemeteslimi/yazdir"); ?>/";
    bosMalzemeTeslimiFormuPencere = window.open(
      url,
      "bosMalzemeTeslimiFormuPencere",
      'status=1,width=' + screen.availWidth + ',height=' + screen.availHeight
    );
    $(bosMalzemeTeslimiFormuPencere).ready(function () {
      //bosMalzemeTeslimiFormuPencere.print();
    });
  }
  function basariliModalGoster() {
    $("#statusSuccessModal").modal("show");
  }
  function ozelBarkodYazdirPencere() {
    $("#ozelBarkodYazdirModal").modal("show");
  }
  function ozelBarkodYazdir() {
    var satir1 = $("#ozelBarkodSatir1").val();
    var satir1YaziBoyutu = $("#ozelBarkodSatir1Yazi").val();
    var satir1YaziBoyutuSelect = $("#ozelBarkodSatir1YaziSelect").val();
    var satir1Align = $("#ozelBarkodSatir1HizaSelect").val();

    var satir2 = $("#ozelBarkodSatir2").val();
    var satir2YaziBoyutu = $("#ozelBarkodSatir2Yazi").val();
    var satir2YaziBoyutuSelect = $("#ozelBarkodSatir2YaziSelect").val();
    var satir2Align = $("#ozelBarkodSatir2HizaSelect").val();

    var satir3 = $("#ozelBarkodSatir3").val();
    var satir3YaziBoyutu = $("#ozelBarkodSatir3Yazi").val();
    var satir3YaziBoyutuSelect = $("#ozelBarkodSatir3YaziSelect").val();
    var satir3Align = $("#ozelBarkodSatir3HizaSelect").val();

    var url = "<?= base_url("app/barkod_ozel"); ?>/"
      + "?satir1=" + satir1
      + "&satir1YaziBoyut=" + satir1YaziBoyutu + "" + satir1YaziBoyutuSelect
      + "&satir1Align=" + satir1Align

      + "&satir2=" + satir2
      + "&satir2YaziBoyut=" + satir2YaziBoyutu + "" + satir2YaziBoyutuSelect
      + "&satir2Align=" + satir2Align
      + "&satir3=" + satir3
      + "&satir3YaziBoyut=" + satir3YaziBoyutu + "" + satir3YaziBoyutuSelect
      + "&satir3Align=" + satir3Align
    ozelBarkodYazdirPencereObj = window.open(
      url,
      "ozelBarkodYazdirPencereObj",
      'status=1,width=' + screen.availWidth + ',height=' + screen.availHeight
    );
  }
  $(document).ready(function () {
    $("#duyuru_gonder_form").submit(function (e) {
      $("#kaydediliyorModal").modal("show");
      var formData = $("#duyuru_gonder_form").serialize();
      $.post("<?= base_url("kullanici / duyuruGonder"); ?>", formData)
        .done(function (msg) {
          $("#kaydediliyorModal").modal("hide");
          try {
            data = $.parseJSON(msg);
            if (data["sonuc"] == 1) {
              $("#duyuru_gonder_form")[0].reset();
              $("#basarili-mesaji").html("Duyuru gönderildi.");
              $("#statusSuccessModal").modal("show");
            } else {
              $("#hata-mesaji").html(data["mesaj"]);
              $("#statusErrorsModal").modal("show");
            }
          } catch (error) {
            $("#hata-mesaji").html(error);
            $("#statusErrorsModal").modal("show");
          }
        })
        .fail(function (xhr, status, error) {
          $("#kaydediliyorModal").modal("hide");
          $("#hata-mesaji").html(error);
          $("#statusErrorsModal").modal("show");
        });
      return false;
    });
  });
</script>
<?php
if ($kullanicibilgileri123["yonetici"] == 1) {
  ?>
  <div class="modal fade" id="duyuruGonderModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="duyuruGonderModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="duyuruGonderModalTitle">Duyuru Gönder</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bu kısım mobil uygulamayı kullanan personellere duyuru göndermek içindir.</p>
          <form id="duyuru_gonder_form" autocomplete="off" method="post">
            <div class="col">
              <label class="form-label" for="duyuru_baslik">Konu:</label>
              <input id="duyuru_baslik" name="duyuru_baslik" autocomplete="off" class="form-control" type="text"
                placeholder="Konu" required>
            </div>
            <div class="col">
              <label class="form-label" for="duyuru_mesaj">Mesaj:</label>
              <textarea id="duyuru_mesaj" name="duyuru_mesaj" autocomplete="off" class="form-control" type="text"
                placeholder="Mesaj:" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" form="duyuru_gonder_form">Gönder</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<div class="modal fade" id="statusSuccessModal" tabindex="-1" aria-labelledby="statusSuccessModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-lg-4">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1"
            cy="65.1" r="62.1" />
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round"
            stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
        </svg>
        <h4 class="text-success mt-3">Başarılı</h4>
        <p id="basarili-mesaji" class="mt-3"></p>
        <button type="button" class="btn btn-sm mt-3 btn-success" data-bs-dismiss="modal">TAMAM</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="statusErrorsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="statusErrorsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-lg-4">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1"
            cy="65.1" r="62.1" />
          <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round"
            stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
          <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round"
            stroke-miterlimit="10" x1="95.8" y1="38" X2="34.4" y2="92.2" />
        </svg>

        <h4 class="text-danger mt-3">Başarısız</h4>
        <p id="hata-mesaji" class="mt-3"></p>
        <button type="button" class="btn btn-sm mt-3 btn-danger" data-bs-dismiss="modal">TAMAM</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="kaydediliyorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="kaydediliyorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-lg-4">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">İşlem gerçekleştiriliyor...</span>
        </div>
        <p>İşlem gerçekleştiriliyor...</p>
      </div>
    </div>
  </div>
</div>
<?php
function yazi($satir)
{
  return '<label for="ozelBarkodSatir' . $satir . '" class="form-label">Yazı:</label>
          <input id="ozelBarkodSatir' . $satir . '" type="text" class="form-control" placeholder="1. Satır Yazısı" />';
}
function yaziBoyutu($satir)
{
  return '<label for="ozelBarkodSatir' . $satir . 'Yazi" class="form-label">Yazı Boyutu:</label>
          <div class="input-group">
            <input id="ozelBarkodSatir' . $satir . 'Yazi" type="number" class="form-control" placeholder="Satır ' . $satir . ' Yazı Boyutu"
              aria-label="Satır ' . $satir . ' Yazı Boyutu" value="17">
            <select class="form-select" id="ozelBarkodSatir' . $satir . 'YaziSelect">
              <option value="px">px</option>
              <option value="cm">cm</option>
            </select>
          </div>';
}
function hizala($satir)
{
  return '<label for="ozelBarkodSatir' . $satir . 'HizaSelect" class="form-label">Hizalama:</label>
          <div class="input-group">
            <select class="form-select" id="ozelBarkodSatir' . $satir . 'HizaSelect">
              <option value="left">Sola Yasla</option>
              <option value="center" selected>Ortala</option>
              <option value="right">Sağa Yasla</option>
            </select>
          </div>';
}
?>
<div class="modal fade" id="ozelBarkodYazdirModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="ozelBarkodYazdirModalTitle" style="z-index: 1040; display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ozelBarkodYazdirModalTitle">Özel Barkod Yazdır</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <H5>Satır 1</H5>
        <div class="mb-3">
          <?= yazi("1"); ?>
        </div>
        <div class="mb-3">
          <?= yaziBoyutu("1"); ?>
        </div>
        <div class="mb-3">
          <?= hizala("1"); ?>
        </div>
        <H5>Satır 2</H5>
        <div class="mb-3">
          <?= yazi("2"); ?>
        </div>
        <div class="mb-3">
          <?= yaziBoyutu("2"); ?>
        </div>
        <div class="mb-3">
          <?= hizala("2"); ?>
        </div>
        <H5>Satır 3</H5>
        <div class="mb-3">
          <?= yazi("3"); ?>
        </div>
        <div class="mb-3">
          <?= yaziBoyutu("3"); ?>
        </div>
        <div class="mb-3">
          <?= hizala("3"); ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="ozelBarkodYazdir()">Yazdır</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>