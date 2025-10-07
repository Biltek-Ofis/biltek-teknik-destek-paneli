<?php
$this->load->view("inc/datatables_scripts");
$this->load->view("inc/style_tablo");
$this->load->view("inc/styles_important");
function donusturOnclick($oge)
{
    return str_replace("'", "\'", trim(preg_replace('/\s\s+/', '<br>', $oge)));
}
?>
<script>
    $(document).ready(function () {
        ayrilma_durumu_tetikle = false;
        try {
            var cagriTablosu = $("#cagriKaydiTablosu").DataTable(<?= $this->Islemler_Model->datatablesAyarlari('[0, "desc"]', 'true'); ?>);
        } catch (error) {
            console.error(error);
        }
    });
</script>
<?php
if ($this->Giris_Model->kullaniciGiris()) {
    ?>
    <script>
        $(document).ready(function () {
            $("#cagriKaydiniSilModal").on("hidden.bs.modal", function (e) {
                $("#CagriKaydiNo").html("");
                $("#MusteriAdi").html("");
                $("#silOnayBtn").attr("href", "#");
            });
            $("#cagriKaydiDuzenleModal").on("hidden.bs.modal", function (e) {
                $("#cagriKaydiDuzenleForm").attr("action", "");
                $("#cagriKaydiDuzenleForm #bolge").val("");
                $("#cagriKaydiDuzenleForm #birim").val("");
                $("#cagriKaydiDuzenleForm #telefon_numarasi1").val("");
                $("#cagriKaydiDuzenleForm #cihaz_turu").val("");
                $("#cagriKaydiDuzenleForm #cihaz").val("");
                $("#cagriKaydiDuzenleForm #cihaz_modeli").val("");
                $("#cagriKaydiDuzenleForm #seri_no").val("");
                $("#cagriKaydiDuzenleForm #ariza_aciklamasi").val("");
            });
        });
        function cagriKaydiDuzenle(id, bolge, birim, tel, cihazTuru, cihaz, cihazModeli, seriNo, ariza) {
            $("#cagriKaydiDuzenleForm").attr("action", "<?= base_url("cagrikayitlari/duzenle"); ?>/" + id);
            $("#cagriKaydiDuzenleForm #bolge").val(bolge);
            $("#cagriKaydiDuzenleForm #birim").val(birim);
            $("#cagriKaydiDuzenleForm #telefon_numarasi2").val(tel);
            $("#cagriKaydiDuzenleForm #cihaz_turu").val(cihazTuru);
            $("#cagriKaydiDuzenleForm #cihaz").val(cihaz);
            $("#cagriKaydiDuzenleForm #cihaz_modeli").val(cihazModeli);
            $("#cagriKaydiDuzenleForm #seri_no").val(seriNo);
            $("#cagriKaydiDuzenleForm #ariza_aciklamasi").val(ariza);
            $("#cagriKaydiDuzenleModal").modal("show");
        }
        function silModaliGoster(id, musteri_adi) {
            $("#silOnayBtn").attr("href", "<?= base_url("cagrikayitlari/sil"); ?>/" + id);

            $("#CagriKaydiNo").html(id);
            $("#MusteriAdi").html(musteri_adi);

            $("#cagriKaydiniSilModal").modal("show");
        }
    </script>
    <?php
}
?>
<div class="content-wrapper">
    <section class="content-header py-4">
        <div class="container-fluid">
            <div class="row mb-2 w-100">
                <div class="col-sm-6">
                    <h3 class="card-title">Çağrı Kayıtları</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url(); ?>">Anasayfa</a>
                        </li>
                        <li class="breadcrumb-item active">Çağrı Kayıtları </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body px-0 mx-0">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button id="yeniCagriKaydiBtn" type="button" class="btn btn-primary me-2 mb-2"
                            data-bs-toggle="modal" data-bs-target="#yeniCagriKaydiModal">
                            Yeni Çağrı Kaydı
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="cagriKaydiTablosu" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Çağrı No</th>
                        <?php
                        if ($this->Giris_Model->kullaniciGiris()) {
                            ?>
                            <th>Müşteri</th>
                            <?php
                        }
                        ?>
                        <th>Servis No</th>
                        <th>Cihaz Türü</th>
                        <th>Cihaz Marka - Model</th>
                        <th>Kayıt Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cagriKayitlari = $this->Cihazlar_Model->cagriKayitlari(($this->Giris_Model->kullaniciGiris(TRUE) ? $this->Kullanicilar_Model->kullaniciBilgileri()["id"] : 0));
                    foreach ($cagriKayitlari as $cagri) {
                        $cihaz = $this->Cihazlar_Model->cagriCihazi($cagri->id);
                        $musteri = $this->Kullanicilar_Model->kullaniciGetir($cagri->kull_id);
                        ?>
                        <tr class="<?php
                        if ($cihaz != null) {
                            echo $this->Cihazlar_Model->
                                cihazDurumuRenk($cihaz->guncel_durum);
                        } else {
                            echo "bg-warning";
                        }
                        ?>">
                            <th><?= $cagri->id; ?></th>
                            <?php
                            if ($this->Giris_Model->kullaniciGiris()) {
                                ?>
                                <td><?= $musteri[0]->ad_soyad; ?></td>
                                <?php
                            }
                            ?>
                            <td><?= $cihaz != null ? $cihaz->servis_no : "-"; ?>
                            <td><?= $this->Cihazlar_Model->cihazTuru($cihaz != null ? $cihaz->cihaz_turu : $cagri->cihaz_turu); ?>
                            </td>
                            <td><?= ($cihaz != null ? $cihaz->cihaz : $cagri->cihaz) . ' - ' . ($cihaz != null ? $cihaz->cihaz_modeli : $cagri->cihaz_modeli); ?>
                            </td>
                            <td><?= $this->Islemler_Model->tarihDonustur($cagri->tarih); ?></td>
                            <td>
                                <?php
                                if ($cihaz != null) {
                                    echo $this->Cihazlar_Model->cihazDurumuIsım($cihaz->guncel_durum);
                                } else {
                                    ?>
                                    İşlem Bekleniyor
                                    <?php
                                }
                                ?>
                            </td>

                            <td>
                                <a href="<?= base_url("cagrikayitlari/detay/" . $cagri->id); ?>"
                                    class="btn btn-sm btn-primary">Detaylar</a>
                                <?php
                                if ($this->Giris_Model->kullaniciGiris()) {
                                    if ($cihaz == null) {
                                        ?>
                                        <a href="<?= base_url("?yeniCihaz=1&musteri_id=" . $cagri->kull_id . "&musteri_adi=" . $cagri->bolge ." ". $cagri->birim . "&gsm=" . $cagri->telefon_numarasi . "&cagri_id=" . $cagri->id . "&cihazTuru=" . $cagri->cihaz_turu . "&&cihaz=" . $cagri->cihaz . "&model=" . $cagri->cihaz_modeli . "&seri_no=" . $cagri->seri_no . "&ariza=" . $cagri->ariza_aciklamasi); ?>"
                                            class="btn btn-sm btn-success">Kayıt Aç</a>
                                        <?php
                                    }
                                    ?>
                                    <button class="btn btn-sm btn-info text-white"
                                        onclick="cagriKaydiDuzenle('<?= donusturOnclick($cagri->id); ?>','<?= donusturOnclick($cagri->bolge); ?>', '<?= donusturOnclick($cagri->birim); ?>', '<?= donusturOnclick($cagri->telefon_numarasi); ?>', '<?= donusturOnclick($cagri->cihaz_turu); ?>', '<?= donusturOnclick($cagri->cihaz); ?>', '<?= donusturOnclick($cagri->cihaz_modeli); ?>', '<?= donusturOnclick($cagri->seri_no); ?>', '<?= donusturOnclick($cagri->ariza_aciklamasi); ?>')">Düzenle</button>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="silModaliGoster('<?= donusturOnclick($cagri->id); ?>', '<?= donusturOnclick($musteri[0]->ad_soyad); ?>')">Sil</button>

                                    <?php

                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
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
    </section>
</div>

<div class="modal fade" id="yeniCagriKaydiModal" tabindex="-1" role="dialog" aria-labelledby="yeniCagriKaydiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniCagriKaydiModalTitle">Yeni Çağrı Kaydı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="yeniCagriKaydiForm" action="<?= base_url("cagrikayitlari/ekle"); ?>" method="post">
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/musteri_sec");
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/bolge");
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/birim");
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/gsm", array("telefon_numarasi_label"=> TRUE, "gsm_id" => "telefon_numarasi1"));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/cihaz_turleri", array("cihaz_turleri_label"=> TRUE));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/cihaz_markasi", array("cihaz_markasi_label"=> TRUE));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/cihaz_modeli", array("cihaz_modeli_label"=> TRUE));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/seri_no", array("seri_no_label"=> TRUE));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/ariza_aciklamasi", array("ariza_aciklamasi_label"=> TRUE));
                        ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="yeniCagriKaydiKaydetBtn" class="btn btn-success" type="submit"
                    form="yeniCagriKaydiForm">Kaydet</button>
                <button type="button" onclick="$('#yeniCagriKaydiForm')[0].reset();"
                    class="btn btn-primary">Temizle</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            </div>
        </div>
    </div>
</div>
<?php
if ($this->Giris_Model->kullaniciGiris()) {
    $this->load->view("inc/modal_cagri_kaydi_duzenle");
    ?>
    
    <div class="modal fade" id="cagriKaydiniSilModal" tabindex="-1" role="dialog"
        aria-labelledby="cagriKaydiniSilModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-danger">
                <div class="modal-header">
                    <h5 class="modal-title" id="cagriKaydiniSilModalLabel">Çağrı Kaydı Silme İşlemini Onaylayın</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bu çağrı kaydını (<span id="CagriKaydiNo"></span> - <span id="MusteriAdi"></span>) silmek istediğinize
                    emin
                    misiniz?
                </div>
                <div class="modal-footer">
                    <a id="silOnayBtn" href="#" class="btn btn-success">Evet</a>
                    <button class="btn btn-danger" data-bs-dismiss="modal">Hayır</button>
                </div>
            </div>
        </div>
    </div>
    <?php

}
?>