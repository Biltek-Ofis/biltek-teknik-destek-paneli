<?php $this->load->view("inc/datatables_scripts"); ?>
<?php
$kullaniciTuru = $kullaniciTuru ?? 1;
?>
<script>
    $(document).ready(function() {
        var tabloDiv = "#kullanici_tablosu";
        var cihazlarTablosu = $(tabloDiv).DataTable(<?= $this->Islemler_Model->datatablesAyarlari([0, "asc"]); ?>);
        var hash = location.hash.replace(/^#/, '');
        if (hash) {
            $('#' + hash).modal('show')
        }
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
                <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary me-2 mb-2" data-toggle="modal" data-target="#yeniKullaniciEkleModal">
                            Yeni Hesap Ekle
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="yeniKullaniciEkleModal" tabindex="-1" aria-labelledby="yeniKullaniciEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniKullaniciEkleModalLabel">Hesap Ekle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="kullaniciEkleForm" autocomplete="off" method="post" action="<?= base_url("yonetim/kullaniciEkle/" . $kullaniciTuru); ?>">
                                    <div class="row">
                                        <?php $this->load->view("ogeler/kullanici_ad"); ?>
                                    </div>
                                    <div class="row">
                                        <?php $this->load->view("ogeler/kullanici_soyad"); ?>
                                    </div>
                                    <div class="row">
                                        <?php $this->load->view("ogeler/kullanici_adi"); ?>
                                    </div>
                                    <div class="row">
                                        <?php $this->load->view("ogeler/kullanici_sifre"); ?>
                                    </div>
                                    <div class="row">
                                        <?php $this->load->view("ogeler/kullanici_personel"); ?>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="kullaniciEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="kullanici_tablosu" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hesap Kodu</th>
                                <th>Ad Soyad</th>
                                <th>Kullanıcı Adı</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($this->Kullanicilar_Model->kullanicilar(array("yonetici" => $kullaniciTuru)) as $kullanici) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $kullanici->id; ?>
                                    </td>
                                    <td>
                                        <?= $this->Kullanicilar_Model->adSoyad($kullanici->ad, $kullanici->soyad); ?><?= $this->Kullanicilar_Model->kullaniciBilgileri()["id"] == $kullanici->id ? ' <span class="font-weight-bold">(Siz)</span>' : "" ?>
                                    </td>
                                    <td>
                                        <?= $kullanici->kullanici_adi; ?>
                                    </td>
                                    <td class="align-middle text-center">

                                        <?= $this->Kullanicilar_Model->kullaniciBilgileri()["id"] == $kullanici->id ? "" : '<a href="#" class="btn btn-info text-white ml-1" data-toggle="modal" data-target="#kullaniciDuzenleModal' . $kullanici->id . '">Düzenle</a><a href="#" class="btn btn-danger ml-1" data-toggle="modal" data-target="#kullaniciSilModal' . $kullanici->id . '">Sil</a>'; ?>
                                    </td>
                                </tr>
                                <?php
                                if ($this->Kullanicilar_Model->kullaniciBilgileri()["id"] != $kullanici->id) {
                                ?>
                                    <div class="modal fade" id="kullaniciSilModal<?= $kullanici->id; ?>" tabindex="-1" aria-labelledby="kullaniciSilModal<?= $kullanici->id; ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="kullaniciSilModal<?= $kullanici->id; ?>Label">Personel Sil</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="font-weight-bold"><?= $this->Kullanicilar_Model->adSoyad($kullanici->ad, $kullanici->soyad); ?> (<?= $kullanici->kullanici_adi; ?>)</span> personelini silmek istediğinize emin misiniz?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url("yonetim/kullaniciSil/" . $kullanici->id) . "/" . $kullaniciTuru; ?>" class="btn btn-danger">Evet</a>
                                                    <a href="#" class="btn btn-success" data-dismiss="modal">Hayır</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="kullaniciDuzenleModal<?= $kullanici->id; ?>" tabindex="-1" aria-labelledby="kullaniciDuzenleModal<?= $kullanici->id; ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="kullaniciDuzenleModal<?= $kullanici->id; ?>Label">Kullanıcı Düzenle</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="kullaniciDuzenleForm<?= $kullanici->id; ?>" autocomplete="off" method="post" action="<?= base_url("yonetim/kullaniciDuzenle/" . $kullanici->id . "/" . $kullaniciTuru); ?>">
                                                        <div class="row">
                                                            <?php $this->load->view("ogeler/kullanici_ad", array("value" => $kullanici->ad, "id" => $kullanici->id)); ?>
                                                        </div>
                                                        <div class="row">
                                                            <?php $this->load->view("ogeler/kullanici_soyad", array("value" => $kullanici->soyad, "id" => $kullanici->id)); ?>
                                                        </div>
                                                        <div class="row">
                                                            <input type="hidden" name="kullanici_adi_orj<?= $kullanici->id; ?>" value="<?= $kullanici->kullanici_adi; ?>">
                                                            <?php $this->load->view("ogeler/kullanici_adi", array("value" => $kullanici->kullanici_adi, "id" => $kullanici->id)); ?>
                                                        </div>
                                                        <div class="row">
                                                            <?php $this->load->view("ogeler/kullanici_sifre", array("value" => $kullanici->sifre, "id" => $kullanici->id)); ?>
                                                        </div>
                                                        <div class="row">
                                                            <?php $this->load->view("ogeler/kullanici_personel", array("value" => $kullanici->yonetici, "id" => $kullanici->id)); ?>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-success" form="kullaniciDuzenleForm<?= $kullanici->id; ?>" value="Kaydet" />
                                                    <a href="#" class="btn btn-danger" data-dismiss="modal">İptal</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>