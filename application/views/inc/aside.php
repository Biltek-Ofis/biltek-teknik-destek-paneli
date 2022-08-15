<style>
    .break-sec-w {
        width: 100%;
        border-bottom: 1px solid #4f5962 !important;
        border-bottom-width: 1px !important;
        border-bottom-style: solid !important;
        border-bottom-color: rgb(79, 89, 98) !important;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= base_url(); ?>" class="brand-link">
        <img src="<?= base_url("dist/img/favicon.ico"); ?>" style="height: 33px;" alt="Biltek Bilgisayar Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Biltek Bilgisayar</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <h5 class="info w-100 text-center">
                <a href="<?= base_url("kullanici"); ?>" class="d-block"><?= $this->Kullanicilar_Model->kullaniciBilgileri()["ad_soyad"]; ?><br>(<?= $this->Kullanicilar_Model->kullaniciBilgileri()["kullanici_adi"]; ?>)</a>
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php

                if ($this->Kullanicilar_Model->kullaniciBilgileri()["yonetici"] == 1) {
                ?>
                    <li class="nav-header">Yönetim</li>
                    <li class="nav-item">
                        <a href="<?= base_url("yonetim/kullanicilar"); ?>" class="nav-link<?php if ($aktifSayfa == "yonetim/kullanicilar") {
                                                                                                echo " active";
                                                                                            } ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Kullanıcılar
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url("yonetim/personel"); ?>" class="nav-link<?php if ($aktifSayfa == "yonetim/personel") {
                                                                                            echo " active";
                                                                                        } ?>">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Personel
                            </p>
                        </a>
                    </li>
                    <hr class="break-sec-w">
                <?php
                }
                ?>
                <li class="nav-header">Teknik Destek</li>
                <li class="nav-item">
                    <a href="<?= base_url(""); ?>" class="nav-link<?php if ($aktifSayfa == "cihaz_yonetimi" or $aktifSayfa == "anasayfa") {
                                                                        echo " active";
                                                                    } ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Anasayfa
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url("cihazlarim"); ?>" class="nav-link<?php if ($aktifSayfa == "cihazlarim") {
                                                                                echo " active";
                                                                            } ?>">
                        <i class="nav-icon fas fa-laptop-house"></i>
                        <p>
                            Cihazlarım
                        </p>
                    </a>
                </li>
                <!--<li class="nav-item<?php /*if ($aktifSayfa == "cihazlar") {
                                            echo " menu-is-opening menu-open";
                                        }*/ ?>">
                    <a href="#" class="nav-link<?php /*if ($aktifSayfa == "cihazlar") {
                                                    echo " active";
                                                }*/ ?>">
                        <i class="nav-icon fas fa-floppy-disk"></i>
                        <p>
                            Cihazlar
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" <?php /*if ($aktifSayfa == "cihazlar") {
                                                        echo ' style="display:block;"';
                                                    }*/ ?>">
                        <?php
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
                        ?>

                    </ul>
                </li>-->
            </ul>
        </nav>
    </div>
</aside>