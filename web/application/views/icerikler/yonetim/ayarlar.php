<?php
defined('BASEPATH') or exit('No direct script access allowed');

$ayarlar = $this->Ayarlar_Model->getir();
?>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    function parantezEkle(deger) {
        if (deger.length > 0) {
            $("#baslik_parantez").html("(" + deger + ") ");
        } else {
            $("#baslik_parantez").html("");
        }
    }
    $(document).ready(function () {
        $("#db_telefon").inputmask("+99 (999) 999-9999");
        parantezEkle($("#db_barkod_ad").val());
        $("#db_barkod_ad").keyup(function () {
            parantezEkle($("#db_barkod_ad").val());
        });
    });
</script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $baslik; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yonetim</li>
                        <li class="breadcrumb-item active"><?= $baslik; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?= base_url("yonetim/ayarDuzenle"); ?>">
                    <h4>Genel Ayarlar</h4>
                    <hr>
                    <div class="form-group col">
                        <label for="db_baslik">Site Başlığı</label>
                        <input id="db_baslik" name="db_baslik" autocomplete="off" class="form-control" type="text"
                            placeholder="Site Başlığı" value="<?= $ayarlar->site_basligi; ?>" required>
                    </div>
                    <div class="form-group col">
                        <label for="db_anasayfa">Şirketinizin Websitesi</label>
                        <input id="db_anasayfa" name="db_anasayfa" autocomplete="off" class="form-control" type="text"
                            placeholder="Şirketinizin Websitesi" value="<?= $ayarlar->firma_url; ?>" required>
                    </div>
                    <div class="form-group col">
                        <label for="db_unvan">Şirket Ünvanı</label>
                        <input id="db_unvan" name="db_unvan" autocomplete="off" class="form-control" type="text"
                            placeholder="Şirket Ünvanı" value="<?= $ayarlar->sirket_unvani; ?>" required>
                    </div>
                    <div class="form-group col">
                        <label for="db_adres">Şirket Adresi</label>
                        <input id="db_adres" name="db_adres" autocomplete="off" class="form-control" type="text"
                            placeholder="Şirket Adresi" value="<?= $ayarlar->adres; ?>" required>
                    </div>
                    <div class="form-group col">
                        <label for="db_telefon">Şirket Telefonu</label>
                        <input id="db_telefon" name="db_telefon" autocomplete="off" class="form-control" type="text"
                            placeholder="Şirket Telefonu" value="<?= $ayarlar->sirket_telefonu; ?>" required>
                    </div>
                    <div class="form-group col">
                        <label for="db_tablo_oge">Tablolarda Sayfa Başına Gösterilecek Öğe Sayısı</label>
                        <input id="db_tablo_oge" name="db_tablo_oge" autocomplete="off" class="form-control" type="text"
                            placeholder="Sayfa Başına Öğe" value="<?= $ayarlar->tablo_oge; ?>" required>
                    </div>
                    <h4>Barkod Ayarları</h4>
                    <hr>
                    <div class="form-group col">
                        <label for="db_barkod_ad">Barkodda Görünecek Şirket Adı</label>
                        <div class="input-group mb-2">
                            <input id="db_barkod_ad" name="db_barkod_ad" autocomplete="off" class="form-control"
                                type="text" placeholder="Ad" value="<?= $ayarlar->barkod_ad; ?>" required>
                        </div>
                    </div>

                    <div class="form-group col">
                        <label for="db_barkod_sirket_adi_boyutu">Şirket Adı <span id="baslik_parantez"></span>ve Tarih
                            Boyutu</label>
                        <div class="input-group mb-2">
                            <input id="db_barkod_sirket_adi_boyutu" name="db_barkod_sirket_adi_boyutu"
                                autocomplete="off" class="form-control" type="number" placeholder="Müşteri Adı Boyutu"
                                value="<?= $ayarlar->barkod_sirket_adi_boyutu; ?>" required>
                            <div class="input-group-append">
                                <div class="input-group-text">pt</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="db_barkod_en">En</label>
                        <div class="input-group mb-2">
                            <input id="db_barkod_en" name="db_barkod_en" autocomplete="off" class="form-control"
                                type="number" placeholder="En" value="<?= $ayarlar->barkod_en; ?>" required>
                            <div class="input-group-append">
                                <div class="input-group-text">mm</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="db_barkod_boy">Boy</label>
                        <div class="input-group mb-2">
                            <input id="db_barkod_boy" name="db_barkod_boy" autocomplete="off" class="form-control"
                                type="number" placeholder="Boy" value="<?= $ayarlar->barkod_boy; ?>" required>
                            <div class="input-group-append">
                                <div class="input-group-text">mm</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="db_barkod_boyutu">Barkod Boyutu</label>
                        <div class="input-group mb-2">
                            <input id="db_barkod_boyutu" name="db_barkod_boyutu" autocomplete="off" class="form-control"
                                type="number" placeholder="Barkod Boyutu" value="<?= $ayarlar->barkod_boyutu; ?>"
                                required>
                            <div class="input-group-append">
                                <div class="input-group-text">mm</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="db_barkod_numarasi_boyutu">Barkod Numarası Boyutu</label>
                        <div class="input-group mb-2">
                            <input id="db_barkod_numarasi_boyutu" name="db_barkod_numarasi_boyutu" autocomplete="off"
                                class="form-control" type="number" placeholder="Barkod Numarası Boyutu"
                                value="<?= $ayarlar->barkod_numarasi_boyutu; ?>" required>
                            <div class="input-group-append">
                                <div class="input-group-text">pt</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="db_barkod_musteri_adi_boyutu">Müşteri Adı Boyutu</label>
                        <div class="input-group mb-2">
                            <input id="db_barkod_musteri_adi_boyutu" name="db_barkod_musteri_adi_boyutu"
                                autocomplete="off" class="form-control" type="number" placeholder="Müşteri Adı Boyutu"
                                value="<?= $ayarlar->barkod_musteri_adi_boyutu; ?>" required>
                            <div class="input-group-append">
                                <div class="input-group-text">pt</div>
                            </div>
                        </div>
                    </div>
                    <div id="container w-100 m-0 p-0">
                        <div class="row m-0 p-0 d-flex justify-content-end">
                            <a href="javascript:void();" onclick="barkoduYazdir('test')"
                                class="btn btn-primary mt-2 mr-2">Önizleme (Ayarları kaydettikten sonra)</a>
                        </div>
                    </div>
                    <hr>
                    <div id="container w-100 m-0 p-0">
                        <div class="row m-0 p-0 d-flex justify-content-end">
                            <input type="submit" class="btn btn-success mt-2 mr-2" value="Kaydet" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>