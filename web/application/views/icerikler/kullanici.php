<?php
$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();

echo '<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>'. $kullanici["ad_soyad"].'</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="'. base_url().'">Anasayfa</a></li>
                        <li class="breadcrumb-item active">'. $kullanici["ad_soyad"].'</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form autocomplete="off" method="post" action="'. base_url("kullanici/guncelle").'">
                    <div class="row">';
                        $this->load->view("ogeler/kullanici_ad", array("value" => $kullanici["ad_soyad"]));
                    echo '</div>
                    <div class="row">
                        <input type="hidden" name="kullanici_adi_orj" value="'. $kullanici["kullanici_adi"].'">';
                        $this->load->view("ogeler/kullanici_adi", array("value" => $kullanici["kullanici_adi"]));
                    echo '</div>
                    <div class="row">';
                        $this->load->view("ogeler/kullanici_sifre", array("value" => $kullanici["sifre"]));
                    echo '</div>
                    <div class="row w-100">
                        <div class="col-6 col-lg-6">
                        </div>
                        <div class="col-6 col-lg-6 text-end">
                            <input type="submit" class="btn btn-success me-2 mb-2" value="Kaydet">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>';