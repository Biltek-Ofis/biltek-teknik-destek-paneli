<?php
$ayarlar = $this->Ayarlar_Model->getir();
$kullanicibilgileri123 = $this->Kullanicilar_Model->kullaniciBilgileri();
echo '<style>
    .break-sec-w {
        width: 100%;
        border-bottom: 1px solid #4f5962 !important;
        border-bottom-width: 1px !important;
        border-bottom-style: solid !important;
        border-bottom-color: rgb(79, 89, 98) !important;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="' . base_url() . '" class="brand-link">
        <img src="' . base_url("dist/img/favicon.ico") . '" style="height: 33px;" alt="' . $ayarlar->site_basligi . ' Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">' . $ayarlar->site_basligi . '</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <h5 class="info w-100 text-center">
                <a href="' . base_url("kullanici") . '" class="d-block">' . $kullanicibilgileri123["ad_soyad"] . '<br>(' . $kullanicibilgileri123["kullanici_adi"] . ')</a>
            </h5>
        </div>
        <!--<div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Menüde Ara" aria-label="Menüde Ara">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>-->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
if ($kullanicibilgileri123["yonetici"] == 1) {
    echo '<li class="nav-header">Yönetim</li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/yoneticiler") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/kullanicilar") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Yönetici Hesapları
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/personel") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/personel") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Personel Hesapları
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/cihaz_turleri") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/cihaz_turleri") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-laptop-medical"></i>
                            <p>
                                Cihaz Türleri
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/cihaz_durumlari") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/cihaz_durumlari") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-laptop"></i>
                            <p>
                                Cihaz Durumları
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/tahsilat_sekilleri") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/tahsilat_sekilleri") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-lira-sign"></i>
                            <p>
                                Tahsilat Şekilleri
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/musteriler") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/musteriler") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-person"></i>
                            <p>
                                Müşteriler
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/rapor") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/rapor") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Rapor
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="' . base_url("yonetim/ayarlar") . '" class="nav-link';
    if ($aktifSayfa == "yonetim/ayarlar") {
        echo " active";
    }
    echo '">
                            <i class="nav-icon fas fa-gear"></i>
                            <p>
                                Ayarlar
                            </p>
                        </a>
                    </li>
                    <hr class="break-sec-w">';
}

echo '<li class="nav-header">Teknik Destek</li>
                <li class="nav-item">
                    <a href="' . base_url("") . '" class="nav-link';
if ($aktifSayfa == "cihazyonetimi" or $aktifSayfa == "anasayfa") {
    echo " active";
}
echo '">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Anasayfa
                        </p>
                    </a>
                </li>';
 if($kullanicibilgileri123["teknikservis"] == 1){
                echo '
                <li class="nav-item">
                    <a href="' . base_url("cihazlarim") . '" class="nav-link';
if ($aktifSayfa == "cihazlarim") {
    echo " active";
}
echo '">
                        <i class="nav-icon fas fa-laptop-house"></i>
                        <p>
                            Cihazlarım
                        </p>
                    </a>
                </li>';
}
                echo '
                <!--<li class="nav-item';
/*if ($aktifSayfa == "cihazlar") {
                                            echo " menu-is-opening menu-open";
                                        }*/
echo '">
                    <a href="#" class="nav-link';
/*if ($aktifSayfa == "cihazlar") {
                                                    echo " active";
                                                }*/
echo '">
                        <i class="nav-icon fas fa-floppy-disk"></i>
                        <p>
                            Cihazlar
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"';
/*if ($aktifSayfa == "cihazlar") {
                                                        echo ' style="display:block;"';
                                                    }*/
echo '">';
/*foreach ($cihazTurleri as $cihazTuru) {
                            echo ' <li class="nav-item">
                                <a href="' . base_url("cihazlar/" . $cihazTuru->id) . '" class="nav-link';
                            if ($baslik == $cihazTuru->isim) {
                                echo " active";
                            }
                            echo '">
                                    <!--<i class="nav-icon fas fa-mobile-alt"></i>-->
                                    <p>' . $cihazTuru->isim . '</p>
                                </a>
                            </li>';
                        }*/


echo '</ul>
                </li>-->
            </ul>
        </nav>
    </div>
</aside>';
