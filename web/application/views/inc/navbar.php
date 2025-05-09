<?php
$ayarlar = $this->Ayarlar_Model->getir();

$tema = $this->Ayarlar_Model->kullaniciTema();
$asilTema = $this->Ayarlar_Model->kullaniciAsilTema();
$kullanicibilgileri123 = $this->Kullanicilar_Model->kullaniciBilgileri();
?>
<script>
  $(document).ready(function () {
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

  .dropdown-item a {
    color: rgba(0, 0, 0, .5);
  }

  .dropdown-item.active,
  .dropdown-item.active a,
  nav-item.active {
    color: rgba(0, 0, 0, .9);
    background-color: transparent;
  }

  .dropdown-item.active:focus,
  .dropdown-item.active a:focus,
  .dropdown-item.active a {
    background-color: transparent;
    color: rgba(0, 0, 0, .9);
  }
</style>
<?php
$detect = new Mobile_Detect();
if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
  ?>
  <div class="w-100 bg-success text-center">
    <a href="<?= base_url("app/android"); ?>" target="_blank" style="color: blue !important;"><img
        style="width:calc(100% / 3)" src="<?= base_url(" dist/img/app/google-play.png"); ?>" /></a>
  </div>
  <?php
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
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
              <a class="dropdown-item" href="#" onclick="bosFormYazdir();">
                Boş Form Yazdır
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a href="<?= base_url("kullanici"); ?>" class="nav-link"
              style="<?= strlen($tema->yazi_rengi) > 0 ? "color: " . $tema->yazi_rengi : ""; ?>"><?= $kullanicibilgileri123["ad_soyad"]; ?></a>
          </li>
          <!--<li class="nav-item">
              <a class="nav-link" href="#" role="button" style="<?= strlen($tema->yazi_rengi) > 0 ? "color: " . $tema->yazi_rengi : ""; ?>" data-bs-toggle="modal" data-bs-target="#temaSecModal">
                <i class="fa-brands fa-themeisle"></i> Tema
              </a>
          </li>-->
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"
                style="<?= (strlen($tema->yazi_rengi) > 0 ? "color: " . $tema->yazi_rengi : ""); ?>"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url("cikis"); ?>" role="button">
              <i class="fas fa-right-from-bracket"
                style="<?= (strlen($tema->yazi_rengi) > 0 ? "color: " . $tema->yazi_rengi : ""); ?>"></i>
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
            <a href="<?= base_url("kullanici/tema/0"); ?>"
              style="<?= (strlen($tema->yazi_rengi) > 0 ? "color: " . $tema->yazi_rengi : ""); ?>">
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
              <a href="<?= base_url("kullanici/tema/" . $gosterimTema->id); ?>"
                style="<?= (strlen($tema->yazi_rengi) > 0 ? "color: " . $tema->yazi_rengi : ""); ?>">
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

  function bosFormYazdir() {
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
  function basariliModalGoster() {
    $("#statusSuccessModal").modal("show");
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