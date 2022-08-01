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
                        <a class="nav-link" id="yapilan-islemler-tab" data-toggle="pill" href="#yapilan-islemler" role="tab" aria-controls="teknik-servis" aria-selected="false">Yapılan İşlemler</a>
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
                                <a href="javascript:void(0);" id="sifirlaGenel" class="btn btn-secondary mt-2">
                                    Sıfırla
                                </a>
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
                                    </tbody>
                                </table>
                                <table class="table table-flush">
                                    <thead>
                                        <tr>
                                            <th>İşlem</th>
                                            <th>Miktar</th>
                                            <th>Birim Fiyat (TL)</th>
                                            <th>Tutar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="yapilanIslemBody">
                                        <?php
                                        $yapilanIslemlerModel = $this->Cihazlar_Model->yapilanIslemler($cihaz->id);
                                        $toplam = 0;
                                        $kdv = 0;
                                        $genel_toplam = 0;
                                        $islem = 0;
                                        $yapilanIslemArr = $yapilanIslemlerModel->result();
                                        foreach ($yapilanIslemArr as $yapilanIslem) {
                                            $tutar = $yapilanIslem->miktar * $yapilanIslem->birim_fiyati;
                                            $toplam = $toplam + $tutar;
                                        }
                                        $kdv = ceil($toplam * 0.18);
                                        $genel_toplam = $toplam + $kdv;
                                        ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 0, "yapilanIslemArr" => $yapilanIslemArr)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 1, "yapilanIslemArr" => $yapilanIslemArr)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 2, "yapilanIslemArr" => $yapilanIslemArr)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 3, "yapilanIslemArr" => $yapilanIslemArr)); ?>
                                        <?php $this->load->view("ogeler/yapilan_islem", array("index" => 4, "yapilanIslemArr" => $yapilanIslemArr)); ?>
                                        <tr>
                                            <th colspan="3">Toplam</th>
                                            <td id="yapilanIslemToplam"><?= $toplam > 0 ? $toplam . " TL" : ""; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">KDV (%18)</th>
                                            <td id="yapilanIslemKdv"><?= $kdv > 0 ? $kdv . " TL" : ""; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Genel Toplam</th>
                                            <td id="yapilanIslemGenelToplam"><?= $genel_toplam > 0 ? $genel_toplam . " TL" : ""; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div id="container w-100 m-0 p-0">
                            <div class="row m-0 p-0 d-flex justify-content-end">
                                <input type="submit" class="btn btn-success mt-2 mr-2" form="yapilanIslemlerForm" value="Kaydet" />
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                for (let i = 0; i < 5; i++) {
                                    $("#yapilanIslem" + i).keyup(function() {
                                        var yapilanIslem = $("#yapilanIslem" + i).val();
                                        if (yapilanIslem.length > 0) {
                                            $("#yapilanIslemMiktar" + i).prop('required', true);
                                            $("#yapilanIslemFiyat" + i).prop('required', true);
                                        } else {
                                            $("#yapilanIslemMiktar" + i).prop('required', false);
                                            $("#yapilanIslemFiyat" + i).prop('required', false);
                                        }
                                    });
                                    $("#yapilanIslemMiktar" + i + ", #yapilanIslemFiyat" + i).keyup(function() {
                                        var yapilanIslemMiktar = $("#yapilanIslemMiktar" + i).val();
                                        var yapilanIslemFiyat = $("#yapilanIslemFiyat" + i).val();
                                        if (yapilanIslemMiktar.length > 0 && yapilanIslemFiyat.length) {
                                            var tutar = yapilanIslemMiktar * yapilanIslemFiyat;
                                            $("#yapilanIslemTutar" + i).html(tutar + " TL");
                                        } else {
                                            $("#yapilanIslemTutar" + i).html("");
                                        }
                                        tutarHesapla();
                                    });
                                }

                                function tutarHesapla() {
                                    var toplam = 0;
                                    for (let i = 0; i < 5; i++) {
                                        var miktar = $("#yapilanIslemMiktar" + i).val();
                                        var birim_fiyati = $("#yapilanIslemFiyat" + i).val();
                                        if (miktar.length > 0 && birim_fiyati > 0) {
                                            miktar = parseInt(miktar);
                                            birim_fiyati = parseInt(birim_fiyati);
                                            var tutar = miktar * birim_fiyati;
                                            console.log("#yapilanIslemTutar" + i + " " + tutar);
                                            toplam = toplam + tutar;
                                        }
                                    }
                                    var kdv = Math.ceil(toplam * 0.18);
                                    var genel_toplam = toplam + kdv;
                                    $("#yapilanIslemToplam").html(toplam > 0 ? toplam + " TL" : "");

                                    $("#yapilanIslemKdv").html(kdv > 0 ? kdv + " TL" : "");

                                    $("#yapilanIslemGenelToplam").html(genel_toplam > 0 ? genel_toplam + " TL" : "");
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>