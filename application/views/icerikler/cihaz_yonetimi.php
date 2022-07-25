<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cihaz Yönetimi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Cihaz Yönetimi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cihazlar</h3>
            </div>
            <div class="card-body">
                <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary me-2" data-toggle="modal" data-target="#yeniCihazEkleModal">
                            Yeni Cihaz Girişi
                        </button>
                    </div>
                </div>
                <?php $this->load->view("icerikler/cihaz_tablosu"); ?>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="yeniCihazEkleModal" tabindex="-1" role="dialog" aria-labelledby="yeniCihazEkleModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniCihazEkleModalTitle">Yeni Cihaz Girişi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="yeniCihazForm" autocomplete="off" method="post" action="<?= base_url("cihaz_yonetimi/cihazEkle"); ?>">
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="musteri_adi" placeholder="Müşteri Adı Soyadı *" required>
                        </div>
                        <div class="form-group col">
                            <input class="form-control" type="text" name="adres" placeholder="Adresi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="gsm_mail" placeholder="GSM & E-Mail">
                        </div>
                        <div class="form-group col">
                            <input class="form-control" type="text" name="tel_faks" placeholder="TEL-FAKS">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <select class="form-control" name="cihaz_turu" aria-label="Cihaz türü" required>
                                <option value="" selected>Cihaz Türü Seçin *</option>
                                <?php
                                foreach ($cihazTurleri as $cihazTuru) {
                                    echo '<option value=' . $cihazTuru->id . '>' . $cihazTuru->isim . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="cihaz" placeholder="Cihaz Marka / Modeli *" required>
                        </div>
                        <div class="form-group col">
                            <input class="form-control" type="text" name="seri_no" placeholder="Cihazın Seri Numarası">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="ariza_aciklamasi" placeholder="Belirtilen arıza açıklaması *" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <select class="form-control" name="yapilacak_islem" aria-label="Yapılacak İşlem" required>
                                <option value="" selected>Yapılacak İşlem Seçin *</option>
                                <option value="GARANTİ KAPSAMINDA BAKIM/ONARIM">GARANTİ KAPSAMINDA BAKIM/ONARIM</option>
                                <option value="ANLAŞMALI KAPSAMINDA BAKIM/ONARIM">ANLAŞMALI KAPSAMINDA BAKIM/ONARIM</option>
                                <option value="ÜCRETLİ BAKIM/ONARIM">ÜCRETLİ BAKIM/ONARIM</option>
                                <option value="ÜCRETLİ ARIZA TESPİTİ">ÜCRETLİ ARIZA TESPİTİ</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <h9 class="col">Yedek alınacak mı?</h9>
                        <div class="form-check form-check-inline col-3">
                            <input class="form-check-input" type="radio" name="yedek_durumu" id="yedek_durumu1" value="Evet" checked>
                            <label class="form-check-label col-12" for="yedek_durumu1">Evet</label>
                        </div>
                        <div class="form-check form-check-inline col-3">
                            <input class="form-check-input" type="radio" name="yedek_durumu" id="yedek_durumu2" value="Hayır">
                            <label class="form-check-label col-12" for="yedek_durumu2">Hayır</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <h5 class="col">Aksesuarlar</h5>
                    </div>
                    <?php $this->load->view("ogeler/aksesuar_radio", array("isim" => "Taşıma Çantası:", "id" => "tasima_cantasi")); ?>
                    <?php $this->load->view("ogeler/aksesuar_radio", array("isim" => "Sarj Adaptörü:", "id" => "sarj_adaptoru")); ?>
                    <?php $this->load->view("ogeler/aksesuar_radio", array("isim" => "Pil:", "id" => "pil")); ?>

                    <div class="row mt-2">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="diger_aksesuar" placeholder="Diğer aksesuar bilgileri">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">İptal</button>
                <input type="submit" class="btn btn-success" form="yeniCihazForm" value="Ekle" />
            </div>
        </div>
    </div>
</div>