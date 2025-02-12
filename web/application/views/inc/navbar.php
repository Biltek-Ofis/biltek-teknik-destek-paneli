<?php
$ayarlar = $this->Ayarlar_Model->getir();

$tema = $this->Ayarlar_Model->kullaniciTema();
$asilTema = $this->Ayarlar_Model->kullaniciAsilTema();
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
                    <li class="dropdown-item"><a href="https://github.com/ozayakcan/biltek-teknik-destek-paneli/releases" target="_blank" class="d-block w-100">Barkod Okuyucu Programı İndir</a></li>
                    <li class="dropdown-item"><a href="' . base_url("urunler/komisyon") . '" target="_blank" class="d-block w-100">Komisyon Oranlarını İndir</a></li>
                    <li class="dropdown-item"><a href="#" class="d-block w-100" onclick="bosFormYazdir();">Boş Form Yazdır</a></li>
                </ul>
            </li>';
            if ($kullanicibilgileri123["yonetici"] == 1) {
                echo ' 
                <li class="nav-item d-none d-sm-inline-block">
                  <a href="#" class="nav-link" data-toggle="modal" data-target="#duyuruGonderModal">Duyuru Gönder</a>
                </li>';
            }
           
    echo '
    </ul>
  </div>
    <ul class="navbar-nav ml-auto">
    
    <li class="nav-item">
      <a href="' . base_url("kullanici") . '" class="nav-link" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "").'">' . $kullanicibilgileri123["ad_soyad"] . '</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" role="button" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "").'" data-toggle="modal" data-target="#temaSecModal">
        <i class="fa-brands fa-themeisle"></i> Tema
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "").'"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="' . base_url("cikis") . '" role="button">
        <i class="fas fa-right-from-bracket" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "").'"></i>
      </a>
    </li>
  </ul>
</nav>';
echo '<div class="modal fade" id="temaSecModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="temaSecModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="temaSecModalTitle">Tema Seç</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <style>
              .siteTema {
                cursor:pointer;
              }
            </style>
               <div class="row">
                <div class="col-4">
                  <a href="'.base_url("kullanici/tema/0").'" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "").'">
                    <div class="col-2 siteTema">
                      <img src="'.base_url("dist/img/temalar/".$this->Ayarlar_Model->siteTema()->onizleme_resmi).'" width="200" heigh="100"/>
                    </div>
                    <div class="col-10 text-center">
                      <input type="radio"'.($asilTema->id == 0 || $asilTema->id == "0" ? " checked" : "").'/> Otomatik (Sitenin Güncel Teması)
                    </div> 
                  </a>
                </div>';
                $temalar = $this->Ayarlar_Model->temalar();
                foreach($temalar as $gosterimTema){
                  echo '<div class="col-4 siteTema">
                  <a href="'.base_url("kullanici/tema/".$gosterimTema->id).'" style="'.(strlen($tema->yazi_rengi) > 0 ? "color: ".$tema->yazi_rengi : "").'">
                    <div class="col-2 siteTema">
                      <img src="'.base_url("dist/img/temalar/".$gosterimTema->onizleme_resmi).'" width="200" heigh="100"/>
                    </div>
                    <div class="col-10 text-center">
                      <input type="radio"'.($tema->id == $gosterimTema->id ? " checked" : "").'/> '.$gosterimTema->isim.'
                    </div> 
                  </a>
                </div>';
                }
                echo '
               </div>
            </div>
<div class="modal-footer">
';
echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
</div>
</div>
</div>
</div>';
echo '
<script>
function basariliModalGoster(){
  $("#statusSuccessModal").modal("show");
  setTimeout(function(){
    $("#statusSuccessModal").modal("hide");
  }, 1000);
}
$(document).ready(function() {
    $("#duyuru_gonder_form").submit(function(e){
      $("#kaydediliyorModal").modal("show");
      var formData = $("#duyuru_gonder_form").serialize();
      $.post("' . base_url("kullanici/duyuruGonder") . '", formData)
      .done(function(msg){
          $("#kaydediliyorModal").modal("hide");
          try{
              data = $.parseJSON( msg );
              if(data["sonuc"]==1){
                  $(\'#duyuru_gonder_form\')[0].reset();
                  $("#basarili-mesaji").html("Duyuru gönderildi.");
                  $("#statusSuccessModal").modal("show");
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
          $("#kaydediliyorModal").modal("hide");
          $("#hata-mesaji").html(error);
          $("#statusErrorsModal").modal("show");
      });
      return false;
  });
});
</script>';
if ($kullanicibilgileri123["yonetici"] == 1) {
  echo '
  <div class="modal fade" id="duyuruGonderModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="duyuruGonderModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="duyuruGonderModalTitle">Duyuru Gönder</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <p>Bu kısım mobil uygulamayı kullanan personellere duyuru göndermek içindir.</p>
                <form id="duyuru_gonder_form" autocomplete="off" method="post">
                  <div class="form-group col">
                      <label for="duyuru_baslik">Konu:</label>
                      <input id="duyuru_baslik" name="duyuru_baslik" autocomplete="off" class="form-control" type="text"
                          placeholder="Konu" required>
                  </div>
                  <div class="form-group col">
                      <label for="duyuru_mesaj">Mesaj:</label>
                      <textarea id="duyuru_mesaj" name="duyuru_mesaj" autocomplete="off" class="form-control" type="text"
                          placeholder="Mesaj:" required></textarea>
                  </div>
                </form>
              </div>
  <div class="modal-footer">
  ';
  echo '<button type="submit" class="btn btn-success" form="duyuru_gonder_form">Gönder</button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
  </div>
  </div>
  </div>
  </div>';
}

echo '
<div class="modal fade" id="statusSuccessModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="statusSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-lg-4">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
          <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " /> 
        </svg> 
        <h4 class="text-success mt-3">Başarılı</h4> 
        <p id="basarili-mesaji" class="mt-3"></p>
        <button type="button" class="btn btn-sm mt-3 btn-success"  data-dismiss="modal">TAMAM</button> 
      </div>
    </div>
  </div>
</div>';

echo '
<div class="modal fade" id="statusErrorsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="statusErrorsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-lg-4">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
          <circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" /> 
          <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
          <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" X2="34.4" y2="92.2" /> 
        </svg>
        
        <h4 class="text-danger mt-3">Başarısız</h4> 
        <p id="hata-mesaji" class="mt-3"></p>
        <button type="button" class="btn btn-sm mt-3 btn-danger"  data-dismiss="modal">TAMAM</button> 
      </div>
    </div>
  </div>
</div>';

echo '
<div class="modal" id="kaydediliyorModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="kaydediliyorModalLabel" aria-hidden="true">
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
</div>';