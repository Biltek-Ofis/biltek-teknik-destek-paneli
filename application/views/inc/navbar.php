<?php
$ayarlar = $this->Ayarlar_Model->getir();
$kullanicibilgileri123 = $this->Kullanicilar_Model->kullaniciBilgileri();
echo '<script>
$(document).ready(function(){
function toggleDropdown(e) {
  const _d = $(e.target).closest(".dropdown"),
    _m = $(".dropdown-menu", _d)
  setTimeout(
    function () {
      const shouldOpen = e.type !== "click" && _d.is(":hover")
      _m.toggleClass("show", shouldOpen)
      _d.toggleClass("show", shouldOpen)
      $("[data-toggle=\'dropdown\']", _d).attr("aria-expanded", shouldOpen)
    },
    e.type === "mouseleave" ? 300 : 0
  )
}

$("body")
  .on("mouseenter mouseleave", ".dropdown", toggleDropdown)
  .on("click", ".dropdown-menu a", toggleDropdown);
});
</script>';
echo '<style>
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
    background-color:transparent;
    color: rgba(0, 0, 0, .9);     
}
</style>';
echo '<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>-->
    <li class="nav-item d-none d-sm-inline-block';
if ($aktifSayfa == "cihazyonetimi" || $aktifSayfa == "anasayfa") {
    echo " active";
}
echo '">
      <a href="' . base_url() . '" class="nav-link">Anasayfa</a>
    </li>';
if($kullanicibilgileri123["teknikservis"] == 1){
    echo '<li class="nav-item d-none d-sm-inline-block';
if ($aktifSayfa == "cihazlarim") {
    echo " active";
}
echo '">
      <a href="' . base_url("cihazlarim") . '" class="nav-link">Cihazlarım</a>
    </li>';
    }
    if ($kullanicibilgileri123["yonetici"] == 1) {
      echo '<li class="nav-item dropdown';
      if ($aktifSayfa == "yonetim/kullanicilar" 
          || $aktifSayfa == "yonetim/yoneticiler" 
          || $aktifSayfa == "yonetim/personel"
          || $aktifSayfa == "yonetim/cihaz_turleri"
          || $aktifSayfa == "yonetim/cihaz_durumlari"
          || $aktifSayfa == "yonetim/tahsilat_sekilleri"
          || $aktifSayfa == "yonetim/musteriler"
          || $aktifSayfa == "yonetim/rapor"
          || $aktifSayfa == "yonetim/ayarlar") {
        echo " active";
      }
      echo '">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Yönetim</a>
                <ul class="dropdown-menu">
                  <li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/kullanicilar" || $aktifSayfa == "yonetim/yoneticiler") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/yoneticiler") . '" class="d-block w-100">Yönetici Hesapları</a></li>';

                  echo '<li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/personel") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/personel") . '" class="d-block w-100">Personel Hesapları</a></li>';

                  echo '<li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/cihaz_turleri") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/cihaz_turleri") . '" class="d-block w-100">Cihaz Türleri</a></li>';

                  echo '<li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/cihaz_durumlari") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/cihaz_durumlari") . '" class="d-block w-100">Cihaz Durumları</a></li>';

                  echo '<li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/tahsilat_sekilleri") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/tahsilat_sekilleri") . '" class="d-block w-100">Tahsilat Şekilleri</a></li>';

                  echo '<li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/musteriler") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/musteriler") . '" class="d-block w-100">Müşteriler</a></li>';

                  echo '<li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/rapor") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/rapor") . '" class="d-block w-100">Rapor</a></li>';

                  echo '<li class="dropdown-item';
                  if ($aktifSayfa == "yonetim/ayarlar") {
                    echo " active";
                  }            
                  echo '"><a href="' . base_url("yonetim/ayarlar") . '" class="d-block w-100">Ayarlar</a></li>';
                  echo  '
                </ul>
            </li>';
    }
if ($kullanicibilgileri123["yonetici"] == 1 || $kullanicibilgileri123["urunduzenleme"] == 1) {
    echo '<li class="nav-item d-none d-sm-inline-block';
if ($aktifSayfa == "urunler/anasayfa" || $aktifSayfa == "urunler/duzenle") {
    echo " active";
}
echo '">
      <a href="' . base_url("urunler") . '" class="nav-link">Ürünler</a>
    </li>';
}
echo '
  </ul>
  <ul class="navbar-nav ml-auto">
    <!--<li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">3 Bildirim</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 yeni cihaz
          <span class="float-right text-muted text-sm">1 gün</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">Tüm Bildirimleri Gör</a>
      </div>
    </li>-->
    <li class="nav-item">
      <a href="' . base_url("kullanici") . '" class="nav-link" style="color:black;">' . $kullanicibilgileri123["ad_soyad"] . '</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="' . base_url("cikis") . '" role="button">
        <i class="fas fa-right-from-bracket"></i>
      </a>
    </li>
  </ul>
</nav>';
