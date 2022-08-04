<script>
    $(document).ready(function() {
        var hash = location.hash.replace(/^#/, '');
        if (hash) {
            $('#' + hash + '-tab').click();
        }
        $('.nav-tabs a').on('shown.bs.tab', function(e) {
            window.location.hash = e.target.hash;
        });
    });
</script>
<script src="<?= base_url("dist/js/cihaz.js"); ?>"></script>
<script src="<?= base_url("dist/js/cihaz_yonetimi.js"); ?>"></script>
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
                        <li class="breadcrumb-item active"><?= $baslik; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
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
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="genel-bilgiler" role="tabpanel" aria-labelledby="genel-bilgiler-tab">
                        <form id="cihazDuzenleForm" autocomplete="off" method="post" action="<?= base_url("cihaz/duzenle/" . $cihaz->id); ?>">
                            <div class="table-responsive">
                                <table class="table table-flush">
                                    <thead></thead>
                                    <tbody>

                                        <tr>
                                            <th class="align-middle">Müşteri Adı: </th>
                                            <td class="align-middle">
                                                <input id="musteri_kod" name="cari_kod" type="hidden">
                                                <?php $this->load->view("ogeler/musteri_adi", array("sifirla" => true, "musteri_adi_value" => $cihaz->musteri_adi)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Adresi: </th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/adres", array("sifirla" => true, "adres_value" => $cihaz->adres)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">GSM & E-Mail: </th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/gsm", array("sifirla" => true, "gsm_mail_value" => $cihaz->gsm_mail)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Teslim Durumu:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/teslim_durumu", array("sifirla" => true, "teslim_edildi_value" => $cihaz->teslim_edildi)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Cihaz Türü:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/cihaz_turleri", array("sifirla" => true, "cihaz_turu_value" => $cihaz->cihaz_turu)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Markası:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/cihaz_markasi", array("sifirla" => true, "cihaz_value" => $cihaz->cihaz)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Modeli:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/cihaz_modeli", array("sifirla" => true, "cihaz_modeli_value" => $cihaz->cihaz_modeli)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Seri Numarası:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/seri_no", array("sifirla" => true, "seri_no_value" => $cihaz->seri_no)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Teslim alınırken belirlenen hasar türü:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/hasar_turu", array("sifirla" => true, "cihazdaki_hasar_value" => $cihaz->cihazdaki_hasar)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Teslim alınırken yapılan hasar tespiti:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/hasar_tespiti", array("sifirla" => true, "hasar_tespiti_value" => $cihaz->hasar_tespiti)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Arıza Açıklaması:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/ariza_aciklamasi", array("sifirla" => true, "ariza_aciklamasi_value" => $cihaz->ariza_aciklamasi)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Servis Türü:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/servis_turu", array("sifirla" => true, "servis_turu_value" => $cihaz->servis_turu)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Yedek Alınacak mı?:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/yedek", array("sifirla" => true, "yedek_durumu_value" => $cihaz->yedek_durumu)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Taşıma Çantası:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Taşıma Çantası", "id" => "tasima_cantasi", "sifirla" => true, "aksesuar_value" => $cihaz->tasima_cantasi)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Sarj Adaptörü:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Sarj Adaptörü", "id" => "sarj_adaptoru", "sifirla" => true, "aksesuar_value" => $cihaz->sarj_adaptoru)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Pil:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Pil", "id" => "pil", "sifirla" => true, "aksesuar_value" => $cihaz->pil)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Diğer:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/diger_aksesuar_bilgileri", array("sifirla" => true, "diger_aksesuar_value" => $cihaz->diger_aksesuar)); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div id="container w-100 m-0 p-0">
                            <div class="row m-0 p-0 d-flex justify-content-end">
                                <input type="submit" class="btn btn-success mt-2 mr-2" form="cihazDuzenleForm" value="Kaydet" />
                                <a href="javascript:void(0);" id="sifirlaGenel" class="btn btn-secondary mt-2 mr-2">
                                    Sıfırla
                                </a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#yazdirModal" class="btn btn-dark text-white mt-2">Yazdır</a>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            var adres = $("#adres").val();
                            var tasima_cantasi = $("#tasima_cantasi").prop('selectedIndex');
                            var sarj_adaptoru = $("#sarj_adaptoru").prop('selectedIndex');
                            var pil = $("#pil").prop('selectedIndex');
                            var ariza_aciklamasi = $("#ariza_aciklamasi").val();
                            var cihaz = $("#cihaz").val();
                            var cihaz_modeli = $("#cihaz_modeli").val();
                            var cihaz_turu = $("#cihaz_turu").prop('selectedIndex');
                            var diger_aksesuar = $("#diger_aksesuar").val();
                            var gsm_mail = $("#gsm_mail").val();
                            var hasar_tespiti = $("#hasar_tespiti").val();
                            var cihazdaki_hasar = $("#cihazdaki_hasar").prop('selectedIndex');
                            var musteri_adi = $("#musteri_adi").val();
                            var seri_no = $("#seri_no").val();
                            var servis_turu = $("#servis_turu").prop('selectedIndex');
                            var tarih = $("#tarih").val();
                            var bildirim_tarihi = $("#bildirim_tarihi").val();
                            var cikis_tarihi = $("#cikis_tarihi").val();
                            var teslim_edildi = $("#teslim_edildi").prop('selectedIndex');
                            var yedek_durumu = $("#yedek_durumu").prop('selectedIndex');
                            $("#sifirlaGenel").on("click", function() {
                                $("#adres").val(adres);
                                $("#tasima_cantasi").prop('selectedIndex', tasima_cantasi);
                                $("#sarj_adaptoru").prop('selectedIndex', sarj_adaptoru);
                                $("#pil").prop('selectedIndex', pil);
                                $("#ariza_aciklamasi").val(ariza_aciklamasi);
                                $("#cihaz").val(cihaz);
                                $("#cihaz_modeli").val(cihaz_modeli);
                                $("#cihaz_turu").prop('selectedIndex', cihaz_turu);
                                $("#diger_aksesuar").val(diger_aksesuar);
                                $("#gsm_mail").val(gsm_mail);
                                $("#hasar_tespiti").val(hasar_tespiti);
                                $("#cihazdaki_hasar").prop('selectedIndex', cihazdaki_hasar);
                                $("#musteri_adi").val(musteri_adi);
                                $("#seri_no").val(seri_no);
                                $("#servis_turu").prop('selectedIndex', servis_turu);
                                $("#tarih").val(tarih);
                                $("#bildirim_tarihi").val(bildirim_tarihi);
                                $("#cikis_tarihi").val(cikis_tarihi);
                                $("#teslim_edildi").prop('selectedIndex', teslim_edildi);
                                $("#yedek_durumu").prop('selectedIndex', yedek_durumu);
                            });
                        });
                    </script>
                    <div class="tab-pane fade" id="yapilan-islemler" role="tabpanel" aria-labelledby="yapilan-islemler">
                        <div class="table-responsive">
                            <form id="yapilanIslemlerForm" autocomplete="off" method="post" action="<?= base_url("cihaz/yapilanIslemDuzenle/" . $cihaz->id); ?>">
                                <table class="table table-flush">
                                    <thead></thead>
                                    <tbody id="form">
                                        <tr>
                                            <th class="align-middle">Giriş Tarihi:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/tarih", $cihaz->tarih == "" ? array("isim" => "tarih", "sifirla" => true) : array("isim" => "tarih", "sifirla" => true, "tarih_value" => $cihaz->tarih)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Bildirim Tarihi:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/bildirim_tarihi", $cihaz->bildirim_tarihi == "" ? array("sifirla" => true) : array("sifirla" => true, "bildirim_tarihi_value" => $cihaz->bildirim_tarihi)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Çıkış Tarihi:</th>
                                            <td class="align-middle">
                                                <?php $this->load->view("ogeler/cikis_tarihi", $cihaz->cikis_tarihi == "" ? array("isim" => "cikis_tarihi", "sifirla" => true) : array("isim" => "cikis_tarihi", "sifirla" => true, "cikis_tarihi_value" => $cihaz->cikis_tarihi)); ?>
                                            </td>
                                        </tr>
                                        <th class="align-middle">Güncel Durum:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/guncel_durum", array("sifirla" => true, "guncel_durum_value" => $cihaz->guncel_durum)); ?>
                                        </td>
                                    </tbody>
                                </table>
                                <table class="table table-flush">
                                    <thead>
                                        <tr>
                                            <th>Malzeme/İşçilik</th>
                                            <th>Miktar</th>
                                            <th>Birim Fiyat (TL)</th>
                                            <th>KDV Oranı</th>
                                            <th>Tutar</th>
                                            <th>KDV</th>
                                        </tr>
                                    </thead>
                                    <tbody id="yapilanIslemBody">
                                        <?php
                                        $toplam = 0;
                                        $kdv = 0;
                                        $genel_toplam = 0;
                                        if ($cihaz->i_ad_1 != "") {
                                            $toplam_islem_fiyati_1 = $cihaz->i_birim_fiyat_1 * $cihaz->i_miktar_1;
                                            $toplam_kdv_1 = ceil(($toplam_islem_fiyati_1 / 100) * $cihaz->i_kdv_1);
                                            $kdv = $kdv + $toplam_kdv_1;
                                            $toplam = $toplam + $toplam_islem_fiyati_1;
                                        }
                                        if ($cihaz->i_ad_2 != "") {
                                            $toplam_islem_fiyati_2 = $cihaz->i_birim_fiyat_2 * $cihaz->i_miktar_2;
                                            $toplam_kdv_2 = ceil(($toplam_islem_fiyati_2 / 100) * $cihaz->i_kdv_2);
                                            $kdv = $kdv + $toplam_kdv_2;
                                            $toplam = $toplam + $toplam_islem_fiyati_2;
                                        }
                                        if ($cihaz->i_ad_3 != "") {
                                            $toplam_islem_fiyati_3 = $cihaz->i_birim_fiyat_3 * $cihaz->i_miktar_3;
                                            $toplam_kdv_3 = ceil(($toplam_islem_fiyati_3 / 100) * $cihaz->i_kdv_3);
                                            $kdv = $kdv + $toplam_kdv_3;
                                            $toplam = $toplam + $toplam_islem_fiyati_3;
                                        }
                                        if ($cihaz->i_ad_4 != "") {
                                            $toplam_islem_fiyati_4 = $cihaz->i_birim_fiyat_4 * $cihaz->i_miktar_4;
                                            $toplam_kdv_4 = ceil(($toplam_islem_fiyati_4 / 100) * $cihaz->i_kdv_4);
                                            $kdv = $kdv + $toplam_kdv_4;
                                            $toplam = $toplam + $toplam_islem_fiyati_4;
                                        }
                                        if ($cihaz->i_ad_5 != "") {
                                            $toplam_islem_fiyati_5 = $cihaz->i_birim_fiyat_5 * $cihaz->i_miktar_5;
                                            $toplam_kdv_5 = ceil(($toplam_islem_fiyati_5 / 100) * $cihaz->i_kdv_5);
                                            $kdv = $kdv + $toplam_kdv_5;
                                            $toplam = $toplam + $toplam_islem_fiyati_5;
                                        }
                                        $genel_toplam = $toplam + $kdv;
                                        ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 1, "yapilanIslemArr" => isset($cihaz->i_ad_1) ? array(
                                            "stok_kod" => $cihaz->i_stok_kod_1,
                                            "islem" => $cihaz->i_ad_1,
                                            "miktar" => $cihaz->i_miktar_1,
                                            "birim_fiyati" => $cihaz->i_birim_fiyat_1,
                                            "kdv" => $cihaz->i_kdv_1
                                        ) : null)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 2, "yapilanIslemArr" => isset($cihaz->i_ad_1) ? array(
                                            "stok_kod" => $cihaz->i_stok_kod_2,
                                            "islem" => $cihaz->i_ad_2,
                                            "miktar" => $cihaz->i_miktar_2,
                                            "birim_fiyati" => $cihaz->i_birim_fiyat_2,
                                            "kdv" => $cihaz->i_kdv_2
                                        ) : null)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 3, "yapilanIslemArr" => isset($cihaz->i_ad_1) ? array(
                                            "stok_kod" => $cihaz->i_stok_kod_3,
                                            "islem" => $cihaz->i_ad_3,
                                            "miktar" => $cihaz->i_miktar_3,
                                            "birim_fiyati" => $cihaz->i_birim_fiyat_3,
                                            "kdv" => $cihaz->i_kdv_3
                                        ) : null)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 4, "yapilanIslemArr" => isset($cihaz->i_ad_1) ? array(
                                            "stok_kod" => $cihaz->i_stok_kod_4,
                                            "islem" => $cihaz->i_ad_4,
                                            "miktar" => $cihaz->i_miktar_4,
                                            "birim_fiyati" => $cihaz->i_birim_fiyat_4,
                                            "kdv" => $cihaz->i_kdv_4
                                        ) : null)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 5, "yapilanIslemArr" => isset($cihaz->i_ad_1) ? array(
                                            "stok_kod" => $cihaz->i_stok_kod_5,
                                            "islem" => $cihaz->i_ad_5,
                                            "miktar" => $cihaz->i_miktar_5,
                                            "birim_fiyati" => $cihaz->i_birim_fiyat_5,
                                            "kdv" => $cihaz->i_kdv_5
                                        ) : null)); ?>
                                        <tr>
                                            <th colspan="3">Toplam</th>
                                            <td id="yapilanIslemToplam"><?= $toplam > 0 ? $toplam . " TL" : ""; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">KDV</th>
                                            <td id="yapilanIslemKdv"><?= $kdv > 0 ? $kdv . " TL" : ""; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Genel Toplam</th>
                                            <td id="yapilanIslemGenelToplam"><?= $genel_toplam > 0 ? $genel_toplam . " TL" : ""; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <div class="form-group p-0 m-0 col">
                                                    <textarea id="yapilan_islem_aciklamasi" autocomplete="off" name="yapilan_islem_aciklamasi" class="form-control" rows="3" placeholder="Yapılan işlem açıklaması"><?= $cihaz->yapilan_islem_aciklamasi; ?></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div id="container w-100 m-0 p-0">
                            <div class="row m-0 p-0 d-flex justify-content-end">
                                <input type="submit" class="btn btn-success mt-2 mr-2" form="yapilanIslemlerForm" value="Kaydet" />
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#yazdirModal" class="btn btn-dark text-white mt-2">Yazdır</a>
                            </div>
                        </div>
                        <script>

                        </script>
                    </div>
                    <script>

                    </script>
                    <div class="tab-pane fade" id="medyalar" role="tabpanel" aria-labelledby="medyalar">
                        <?php $this->load->view("icerikler/medyalar", array("id" => $cihaz->id, "silButonu" => true)); ?>
                        <div class="row text-center">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form id="upload_form" onsubmit="dosyaYukle(<?= $cihaz->id; ?>)" enctype="multipart/form-data" method="post">
                                    <div class="form-group">
                                        <input type="file" name="yuklenecekDosya" id="yuklenecekDosya" required>
                                    </div>
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" value="Medya Yükle" name="btnSubmit" accept="image/pjpeg, image/png, image/jpeg, video/mp4">
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
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="yazdirModal" tabindex="-1" role="dialog" aria-labelledby="yazdirModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yazdirModalLabel">Yazdırma İşlemini Onaylayın</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yazdırma işleminden önce yaptığınız değişiklikleri kaydetmelisiniz.
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" onclick="yazdir(<?= $cihaz->id; ?>);" class="btn btn-dark text-white">Yazdır</a>
                <a class="btn btn-secondary" data-dismiss="modal">Kapat</a>
            </div>
        </div>
    </div>
</div>