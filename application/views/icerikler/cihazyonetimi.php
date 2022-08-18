<?php
echo '<script>
    function createDateAsUTC(date) {
        return new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes()));
    }
    $(document).ready(function() {
        var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash).modal(\'show\')
        }
        $(\'#yeniCihazEkleModal\').on(\'show.bs.modal\', function(e) {
            var tarih = createDateAsUTC(new Date());
            $("#tarih").val(tarih.toJSON().slice(0, 19));
        });
    });
</script>
<script src="' . base_url("dist/js/cihazyonetimi.min.js") . '"></script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cihaz Yönetimi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
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
                </div>';
$this->load->view("icerikler/cihaz_tablosu");
echo '</div>
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
                <form id="yeniCihazForm" autocomplete="off" method="post" action="' . base_url("cihazyonetimi/cihazEkle") . '">
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>
                    <div class="row">';
$this->load->view("ogeler/tarih");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/musteri_adi");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/adres");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/gsm");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/cihaz_turleri");
echo '</div>';

if ($this->Kullanicilar_Model->yonetici()) {

    echo '<div class="row">';
    $this->load->view("ogeler/sorumlu_select");
    echo '</div>';
} else {
    $this->load->view("ogeler/sorumlu_text");
}

echo '<div class="row">';
    $this->load->view("ogeler/cihaz_markasi");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/cihaz_modeli");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/seri_no");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/cihaz_sifresi");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/ariza_aciklamasi");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/teslim_alinanlar");
echo '</div>
<div class="row">
    <h5 class="col">Cihazın Hasar Bilgisi</h5>
</div>
<div class="row">';
    $this->load->view("ogeler/hasar_tespiti");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/hasar_turu");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/servis_turu");
echo '</div>
<div class="row">';
    $this->load->view("ogeler/yedek");
echo '</div>
</form>
</div>
<div class="modal-footer">
    <input type="submit" class="btn btn-success" form="yeniCihazForm" value="Ekle" />
    <button type="button" onclick="$(\'#yeniCihazForm\')[0].reset();" class="btn btn-primary">Temizle</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">İptal</button>
</div>
</div>
</div>
</div>';
