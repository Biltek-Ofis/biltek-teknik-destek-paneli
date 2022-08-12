<?php
$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $kullanici["ad"]; ?> <?= $kullanici["soyad"]; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Anasayfa</a></li>
                        <li class="breadcrumb-item active"><?= $kullanici["ad"]; ?> <?= $kullanici["soyad"]; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form autocomplete="off" method="post" action="<?= base_url("kullanici/guncelle"); ?>">
                    <div class="row">
                        <?php $this->load->view("ogeler/kullanici_ad", array("value" => $kullanici["ad"])); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/kullanici_soyad", array("value" => $kullanici["soyad"])); ?>
                    </div>
                    <div class="row">
                        <input type="hidden" name="kullanici_adi_orj" value="<?= $kullanici["kullanici_adi"]; ?>">
                        <?php $this->load->view("ogeler/kullanici_adi", array("value" => $kullanici["kullanici_adi"])); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/kullanici_sifre", array("value" => $kullanici["sifre"])); ?>
                    </div>
                    <div id="container w-100 m-0 p-0">
                        <div class="row m-0 p-0 d-flex justify-content-end">
                            <input type="submit" class="btn btn-success me-2 mb-2" value="Kaydet">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>