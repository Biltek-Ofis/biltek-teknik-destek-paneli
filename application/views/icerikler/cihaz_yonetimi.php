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
                <h3 class="card-title">Son Cihazlar</h3>
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

<div class="modal fade" id="yeniCihazEkleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="yeniCihazEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniCihazEkleModalLabel">Yeni Cihaz Girişi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="yeniCihazForm" autocomplete="off" method="post" action="<?= base_url("cihaz_yonetimi/cihazEkle"); ?>">
                    <div class="form-group">
                        <input class="form-control" type="text" name="musteri_adi" placeholder="Müşterinin Adı" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control mt-3" name="cihaz_turu" aria-label="Cihaz türü" required>
                            <option value="" selected>Cihaz Türü Seçin</option>
                            <?php
                            foreach ($cihazTurleri as $cihazTuru) {
                                echo '<option value=' . $cihazTuru->id . '>' . $cihazTuru->isim . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control mt-3" type="text" name="cihaz" placeholder="Cihaz" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control mt-3" type="text" name="ariza_aciklamasi" placeholder="Arıza Açıklaması" required>
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