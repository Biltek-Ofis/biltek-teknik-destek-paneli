<?php
if (isset($cagri) || $cagri != null) {
    ?>
    <script>
        $(document).ready(function () {
            ayrilma_durumu_tetikle = false;
        });
    </script>
    <div class="content-wrapper">
        <section class="content-header py-4">
            <div class="container-fluid">
                <div class="row mb-2 w-100">
                    <div class="col-sm-6">
                        <h3 class="card-title">Çağrı Kaydı <?= $cagri->id; ?> Detayı</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url(); ?>">Anasayfa</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url("cagrikayitlari"); ?>">Çağrı Kayıtları</a>
                            </li>
                            <li class="breadcrumb-item active"><?= $cagri->id; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <?php
            $cihaz = $this->Cihazlar_Model->cagriCihazi($cagri->id);
            $musteri = $this->Kullanicilar_Model->kullaniciGetir($cagri->kull_id);

            ?>
            <div class="table-responsive">
                <table id="cagriKaydiTablosu" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:30%"></th>
                            <th style="width:70%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($this->Giris_Model->kullaniciGiris()) {
                            ?>
                            <tr>
                                <th>Müşteri:</th>
                                <td><?= $musteri[0]->ad_soyad; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        ?>
                        <tr>
                            <th>Bölge:</th>
                            <td><?= $cagri->bolge; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Birim:</th>
                            <td><?= $cagri->birim; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>GSM:</th>
                            <td><?= $cihaz != null ? $cihaz->telefon_numarasi : $cagri->telefon_numarasi; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Cihaz Türü:</th>
                            <td><?= $this->Cihazlar_Model->cihazTuru($cihaz != null ? $cihaz->cihaz_turu : $cagri->cihaz_turu); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Marka - Model:</th>
                            <td><?= $cihaz != null ? $cihaz->cihaz : $cagri->cihaz; ?> -
                                <?= $cihaz != null ? $cihaz->cihaz_modeli : $cagri->cihaz_modeli; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Seri No:</th>
                            <td><?= $cihaz != null ? $cihaz->seri_no : $cagri->seri_no; ?></td>
                        </tr>
                        <tr>
                            <th>Arıza:</th>
                            <td><?= $cihaz != null ? $cihaz->ariza_aciklamasi : $cagri->ariza_aciklamasi; ?></td>
                        </tr>
                        <tr>
                            <th>Çağrı Kayıt Tarihi:</th>
                            <td><?= $this->Islemler_Model->tarihDonustur($cagri->tarih); ?></td>
                        </tr>
                        <?php
                        if ($cihaz != null) {
                            ?>
                            <tr>
                                <th>Durum:</th>
                                <td><?php
                                $durum = $this->Cihazlar_Model->cihazDurumuIsım($cihaz->guncel_durum);
                                echo $durum;
                                if ($durum == "Fiyat Onayı Bekleniyor") {
                                    ?>
                                        <a href="<?= base_url("cagrikayitlari/fiyationayla/" . $cagri->id); ?>"
                                            class="btn btn-sm btn-success ms-2">Fiyatı Onayla</a>
                                        <a href="<?= base_url("cagrikayitlari/fiyatireddet/" . $cagri->id); ?>"
                                            class="btn btn-sm btn-danger ms-2">Fiyatı Reddet</a>
                                        <?php
                                }
                                ?>
                                </td>
                            </tr>
                            <?php
                            if ($cihaz != null) {
                                ?>
                                <tr>
                                    <th>Servis No:</th>
                                    <td><?= $cihaz->servis_no; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <th>Yapılan İşlem Açıklaması:</th>
                                <td><?= $cihaz->yapilan_islem_aciklamasi; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive mt-4">
                <?php
                if ($cihaz != null) {
                    $islemler = $this->Cihazlar_Model->islemleriGetir($cihaz->id);
                    if (count($islemler) > 0) {
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>İşlem</th>
                                    <th>Birim Fiyatı</th>
                                    <th>Miktar</th>
                                    <th>KDV</th>
                                    <th>Tutar (KDV'siz)</th>
                                    <th>Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tTutar = 0.00;
                                $tKdv = 0.00;
                                foreach ($islemler as $islem) {
                                    $tutar = $islem->birim_fiyat * $islem->miktar;
                                    $kdv = ($tutar / 100) * $islem->kdv;
                                    $tTutar += $tutar;
                                    $tKdv += $kdv;
                                    ?>
                                    <tr>
                                        <td><?= $islem->ad; ?></td>
                                        <td><?= $islem->birim_fiyat; ?> TL</td>
                                        <td><?= $islem->miktar; ?></td>
                                        <td>%<?= $islem->kdv; ?></td>
                                        <td><?= number_format($tutar, 2, '.', ''); ?> TL</td>
                                        <td><?= number_format($tutar + $kdv, 2, '.', ''); ?> TL</td>
                                    </tr>
                                    <?php
                                } ?>
                                <tr>
                                    <th colspan="2" class="text-start">Toplam:</th>
                                    <td colspan="4"><?= number_format($tTutar, 2, '.', ''); ?> TL</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-start">KDV:</th>
                                    <td colspan="4"><?= number_format($tKdv, 2, '.', ''); ?> TL</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-start">Genel Toplam:</th>
                                    <td colspan="4"><?= number_format($tTutar + $tKdv, 2, '.', ''); ?> TL</td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                ?>
            </div>

            <?php
            if ($cihaz == null) {
                ?>
                <div class="alert alert-warning text-center" role="alert">
                    Çağrı kaydınızın yetkili tarafından işleme alınması bekleniyor.
                </div>
                <?php
            }
            if ($this->Giris_Model->kullaniciGiris(TRUE)) {
                $ayarlar = $this->Ayarlar_Model->getir();
                ?>

                <div class="alert alert-success text-center" role="alert">
                    Çağrı kaydınız hakkında bilgi almak (istek, fiyat onayı, iade talebi vb) için
                    <b><?= $ayarlar->sirket_telefonu; ?></b> numarasından bize ulaşabilirsiniz.
                </div>
                <?php
            }
            ?>

            <div class="col-sm-12 text-center">
                <?php
                if ($this->Giris_Model->kullaniciGiris()) {
                    if ($cihaz != null) {
                    $kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
                ?>
                    <a href="<?= base_url($kullanici["teknikservis"] == 1 ? "cihazlarim/?servisNo=" . $cihaz->servis_no : "?servisNo=" . $cihaz->servis_no); ?>"
                        class="btn btn-success me-2">Servis Kaydı</a>
                <?php    
                }
                ?>
                    <button id="cagriKaydiDuzenleBtn" type="button" class="btn btn-info text-white me-2" data-bs-toggle="modal"
                        data-bs-target="#cagriKaydiDuzenleModal">
                        Düzenle
                    </button>
                <?php
                }
                ?>
                <a href="<?= base_url("cagrikayitlari"); ?>" class="btn btn-primary">Geri Dön</a>
            </div>
        </section>
    </div>
    <?php
    $this->load->view("inc/modal_cagri_kaydi_duzenle", array(
        "cagri_servis_no" => $cihaz != null ? $cihaz->servis_no : "",
        "cihaz_mevcut" => $cihaz != null ? TRUE : FALSE,
        "form_action" => base_url("cagrikayitlari/duzenle/" . $cagri->id . "/?cagri=1"),
        "bolge_value" => $cagri->bolge,
        "birim_value" => $cagri->birim,
        "telefon_numarasi_value" => $cihaz != null ? $cihaz->telefon_numarasi : $cagri->telefon_numarasi,
        "cihaz_turu_value" => $cihaz != null ? $cihaz->cihaz_turu : $cagri->cihaz_turu,
        "cihaz_value" => $cihaz != null ? $cihaz->cihaz : $cagri->cihaz,
        "cihaz_modeli_value" => $cihaz != null ? $cihaz->cihaz_modeli : $cagri->cihaz_modeli,
        "seri_no_value" => $cihaz != null ? $cihaz->seri_no : $cagri->seri_no,
        "ariza_aciklamasi_value" => $cihaz != null ? $cihaz->ariza_aciklamasi : $cagri->ariza_aciklamasi,
    ));
} else {
    ?>
    <div class="content-wrapper">
        <section class="content-header py-4">
            <div class="container-fluid">
                <div class="row mb-2 w-100">
                    <div class="alert alert-danger text-center" role="alert">
                        Çağrı Kaydı Bulunamadı
                    </div>
                    <div class="col-sm-12 text-center">
                        <a href="<?= base_url("cagrikayitlari"); ?>" class="btn btn-primary mt-3">Geri Dön</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php

}
?>