<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view("inc/datatables_scripts");
?>
<script>
    $(document).ready(function () {
        var tabloDiv = "#cihaz_turu_tablosu";
        var cihazlarTablosu = $(tabloDiv).DataTable(<?= $this->Islemler_Model->datatablesAyarlari('[0, "asc"]'); ?>);
        var hash = location.hash.replace(/^#/, '\\');
        if (hash) {
            $('#' + hash).modal('show');
        }
    });
</script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cihaz Türleri</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= base_url() ;?>">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yonetim</li>
                        <li class="breadcrumb-item active">Cihaz Türleri</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button type="button" class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#yeniCihazTuruEkleModal">
                            Yeni Cihaz Türü Ekle
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="yeniCihazTuruEkleModal" tabindex="-1" aria-labelledby="yeniCihazTuruEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniCihazTuruEkleModalLabel">Cihaz Türü Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="cihazTuruEkleForm" autocomplete="off" method="post" action="<?=base_url("yonetim/cihazTuruEkle") ;?>">
                                    <div class="row">
                                        <?php
                                        $this->load->view("ogeler/cihaz_turu_isim");
                                        ?>
                                    </div>
                                    <div class="row">
                                        <?php
                                        $this->load->view("ogeler/cihaz_turu_sifre");
                                        ?>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="cihazTuruEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="cihaz_turu_tablosu" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kod</th>
                                <th>İsim</th>
                                <th>Cihaz Şifresi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($this->Cihazlar_Model->cihazTurleri() as $cihazTuru) {
                        ?>
                            <tr>
                                <td>
                                    <?= $cihazTuru->id ;?>
                                </td>
                                <td>
                                    <?= $cihazTuru->isim ;?>
                                </td>
                                <td>
                                    <?= ($cihazTuru->sifre == 1 ? "Evet" : "Hayır") ;?>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" class="btn btn-info text-white ml-1" data-bs-toggle="modal" data-bs-target="#cihazTuruDuzenleModal<?= $cihazTuru->id ;?>">Düzenle</a><a href="#" class="btn btn-danger ml-1" data-bs-toggle="modal" data-bs-target="#cihazTuruSilModal<?= $cihazTuru->id ;?>">Sil</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="cihazTuruSilModal<?= $cihazTuru->id ;?>" tabindex="-1" aria-labelledby="cihazTuruSilModal<?= $cihazTuru->id ;?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cihazTuruSilModal<?= $cihazTuru->id ;?>Label">Cihaz Türü Sil</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <span class="fw-bold"><?= $cihazTuru->isim ;?></span> türünü silmek istediğinize emin misiniz?
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?= base_url("yonetim/cihazTuruSil/" . $cihazTuru->id) ;?>" class="btn btn-danger">Evet</a>
                                            <a href="#" class="btn btn-success" data-bs-dismiss="modal">Hayır</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="cihazTuruDuzenleModal<?= $cihazTuru->id ;?>" tabindex="-1" aria-labelledby="cihazTuruDuzenleModal<?= $cihazTuru->id ;?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cihazTuruDuzenleModal<?= $cihazTuru->id ;?>Label">Cihaz Türü Düzenle</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="cihazTuruDuzenleForm<?= $cihazTuru->id ;?>" autocomplete="off" method="post" action="<?= base_url("yonetim/cihazTuruDuzenle/" . $cihazTuru->id) ;?>">
                                                <div class="row">
                                                    <?php
                                                    $this->load->view("ogeler/cihaz_turu_isim", array("cihaz_turu_isim_value" => $cihazTuru->isim, "id" => $cihazTuru->id));
                                                    ?>
                                                </div>
                                                <div class="row">
                                                    <?php
                                                    $this->load->view("ogeler/cihaz_turu_sifre", array("cihaz_turu_sifre_value" => $cihazTuru->sifre, "id" => $cihazTuru->id));
                                                    ?>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-success" form="cihazTuruDuzenleForm<?= $cihazTuru->id ;?>" value="Kaydet" />
                                            <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
