<script>
    function createDateAsUTC(date) {
        return new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes()));
    }
    $(document).ready(function() {
        var hash = location.hash.replace(/^#/, '');
        if (hash) {
            $('#' + hash).modal('show')
        }
        $('#yeniCihazEkleModal').on('show.bs.modal', function(e) {
            var tarih = createDateAsUTC(new Date());
            $("#tarih").val(tarih.toJSON().slice(0, 19));
        });
    });
</script>
<script src="<?= base_url("dist/js/cihaz_yonetimi.js"); ?>"></script>
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
                        <button type="button" class="btn btn-primary me-2 mb-2" data-toggle="modal" data-target="#yeniCihazEkleModal">
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
                        <?php $this->load->view("ogeler/tarih"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/musteri_adi"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/adres"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/gsm"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/cihaz_turleri"); ?>
                    </div>
                    <?php
                    if ($this->Kullanicilar_Model->yonetici()) {
                    ?>
                        <div class="row">
                            <?php $this->load->view("ogeler/sorumlu_select"); ?>
                        </div>
                    <?php
                    } else {
                    ?>
                        <?php $this->load->view("ogeler/sorumlu_text"); ?>
                    <?php
                    }
                    ?>
                    <div class="row">
                        <?php $this->load->view("ogeler/cihaz_markasi"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/cihaz_modeli"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/seri_no"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/cihaz_sifresi"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/ariza_aciklamasi"); ?>
                    </div>
                    <div class="row">
                        <h5 class="col">Cihazın Hasar Bilgisi</h5>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/hasar_tespiti"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/hasar_turu"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/servis_turu"); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/yedek"); ?>
                    </div>
                    <div class="row">
                        <h5 class="col">Aksesuarlar</h5>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Taşıma Çantası", "id" => "tasima_cantasi")); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Sarj Adaptörü", "id" => "sarj_adaptoru")); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Pil", "id" => "pil")); ?>
                    </div>
                    <div class="row">
                        <?php $this->load->view("ogeler/diger_aksesuar_bilgileri"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" form="yeniCihazForm" value="Ekle" />
                <button type="button" onclick="$('#yeniCihazForm')[0].reset();" class="btn btn-primary">Temizle</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">İptal</button>
            </div>
        </div>
    </div>
</div>