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
$detect = new Mobile_Detect();
if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
  echo '<div class="w-100 bg-success text-center">
    <a href="'.base_url("app/android").'" target="_blank" style="color: blue !important;"><img style="width:calc(100% / 3)" src="'.base_url("dist/img/app/google-play.png").'"/></a>
  </div>';
}
echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item';
if ($aktifSayfa == "cihazyonetimi" || $aktifSayfa == "anasayfa") {
    echo " active";
}
echo '">
        <a class="nav-link" href="'.base_url().'">Anasayfa</a>
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

echo '<!-- <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Ürünler</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item"><a href="' . base_url("urunler") . '" class="d-block w-100">Ürün Listesi</a></li>
                </ul>
            </li>-->';
echo '<li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">İşlemler</a>
                <ul class="dropdown-menu">
                    <script>
                    
	function bosFormYazdir(){
		var url = "' . base_url("cihaz/teknik_servis_formu/yazdir") . '/";

		bosTeknikServisFormuPencere = window.open(
			url,
			"bosTeknikServisFormuPencere",
			\'status=1,width=\' + screen.availWidth + \',height=\' + screen.availHeight
		);
		$(bosTeknikServisFormuPencere).ready(function() {
			//bosTeknikServisFormuPencere.print();
		});
	}
                    </script>
                    <li class="dropdown-item"><a href="' . base_url("urunler/komisyon") . '" target="_blank" class="d-block w-100">Komisyon Oranlarını İndir</a></li>
                    <li class="dropdown-item"><a href="#" class="d-block w-100" onclick="bosFormYazdir();">Boş Form Yazdır</a></li>
                </ul>
            </li>';
echo '
    </ul>
  </div>
    <ul class="navbar-nav ml-auto">
    
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

