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
<div class="modal fade" id="yeniCihazEkleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="yeniCihazEkleModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
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
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="adres" placeholder="Adresi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="gsm_mail" placeholder="GSM & E-Mail *" required>
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
                            <input class="form-control" type="text" name="cihaz" placeholder="Cihaz Markası *" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="cihaz_modeli" placeholder="Modeli">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <input class="form-control" type="text" name="seri_no" placeholder="Cihazın Seri Numarası">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <textarea name="ariza_aciklamasi" class="form-control" rows="3" placeholder="Belirtilen arıza açıklaması *" required></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <h5 class="col">Cihazın Hasar Bilgisi</h5>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-12 col">
                            <input class="form-control" type="text" name="hasar_tespiti" placeholder="Teslim alırken yapılan hasar tespiti">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-check form-check-inline pl-2 col-2">
                            <input class="form-check-input" type="radio" name="cihazdaki_hasar" id="cihazdaki_hasar1" value="Yok" checked>
                            <label class="form-check-label col-12" for="cihazdaki_hasar1">Yok</label>
                        </div>
                        <div class="form-check form-check-inline col-2">
                            <input class="form-check-input" type="radio" name="cihazdaki_hasar" id="cihazdaki_hasar2" value="Çizik">
                            <label class="form-check-label col-12" for="cihazdaki_hasar2">Çizik</label>
                        </div>
                        <div class="form-check form-check-inline col-2">
                            <input class="form-check-input" type="radio" name="cihazdaki_hasar" id="cihazdaki_hasar3" value="Kırık">
                            <label class="form-check-label col-12" for="cihazdaki_hasar3">Kırık</label>
                        </div>
                        <div class="form-check form-check-inline col-2">
                            <input class="form-check-input" type="radio" name="cihazdaki_hasar" id="cihazdaki_hasar4" value="Çatlak">
                            <label class="form-check-label col-12" for="cihazdaki_hasar4">Çatlak</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col">
                            <select class="form-control" name="servis_turu" aria-label="Servis Türü">
                                <option value="0" selected>Servis Türü Seçin</option>
                                <option value="1"><?= $this->Islemler_Model->servisTuru(1); ?></option>
                                <option value="2"><?= $this->Islemler_Model->servisTuru(2); ?></option>
                                <option value="3"><?= $this->Islemler_Model->servisTuru(3); ?></option>
                                <option value="4"><?= $this->Islemler_Model->servisTuru(4); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col">
                            <select class="form-control" name="yedek_durumu" aria-label="Yedekleme İşlemi">
                                <option value="0" selected>Yedek alınacak mı?</option>
                                <option value="1"><?= $this->Islemler_Model->evetHayir(1); ?></option>
                                <option value="2"><?= $this->Islemler_Model->evetHayir(2); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <h5 class="col">Aksesuarlar</h5>
                    </div>
                    <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Taşıma Çantası", "id" => "tasima_cantasi")); ?>
                    <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Sarj Adaptörü", "id" => "sarj_adaptoru")); ?>
                    <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Pil", "id" => "pil")); ?>

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