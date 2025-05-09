<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $baslik; ?> - Düzenle</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Anasayfa</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("urunler"); ?>">Ürünler</a></li>
                        <li class="breadcrumb-item active"><?= $baslik; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form id="urunDuzenleForm" autocomplete="off" method="post"
                    action="<?= base_url("urunler/duzenle/" . $urun_id); ?>">
                    <?php
                    $this->load->view("icerikler/urunler/form", array("urun_id" => $urun_id));
                    ?>
                </form>
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <input id="urunDuzenleBtn" type="submit" class="btn btn-success" form="urunDuzenleForm"
                            value="Düzenle" />
                        <a href="<?= base_url("urunler"); ?>" class="btn btn-primary ml-1">Geri</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>