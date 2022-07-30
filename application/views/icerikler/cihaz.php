<script>
    $(document).ready(function() {
        var hash = location.hash.replace(/^#/, '');
        if (hash) {
            $('#' + hash + '-tab').click();
        }
        $('.nav-tabs a').on('shown.bs.tab', function(e) {
            window.location.hash = e.target.hash;
        })
        $("#sifirla").on("click", function() {
            window.location.reload();
        });
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
                        <li class="breadcrumb-item active"><?= $baslik; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="genel-bilgiler-tab" data-toggle="pill" href="#genel-bilgiler" role="tab" aria-controls="genel-bilgiler" aria-selected="false">Genel Bilgiler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cihaz-bilgileri-tab" data-toggle="pill" href="#cihaz-bilgileri" role="tab" aria-controls="cihaz-bilgileri" aria-selected="false">Cihaz Bilgileri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="teknik-servis-bilgileri-tab" data-toggle="pill" href="#teknik-servis-bilgileri" role="tab" aria-controls="teknik-servis" aria-selected="false">Teknik Servis Bilgileri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="aksesuar-bilgileri-tab" data-toggle="pill" href="#aksesuar-bilgileri" role="tab" aria-controls="teknik-servis" aria-selected="false">Aksesuar Bilgileri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="yapilan-islemler-tab" data-toggle="pill" href="#yapilan-islemler" role="tab" aria-controls="teknik-servis" aria-selected="false">Yapılan İşlemler</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="genel-bilgiler" role="tabpanel" aria-labelledby="genel-bilgiler-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th class="align-middle">Müşteri Adı: </th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/musteri_adi", array("sifirla" => true, "value" => $cihaz->musteri_adi)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Adresi: </th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/adres", array("sifirla" => true, "value" => $cihaz->adres)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">GSM & E-Mail: </th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/gsm", array("sifirla" => true, "value" => $cihaz->gsm_mail)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Giriş Tarihi:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/tarih", array("isim" => "tarih", "sifirla" => true, "value" => $cihaz->tarih)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Bildirim Tarihi:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/tarih", array("isim" => "bildirim_tarihi", "sifirla" => true, "value" => $cihaz->bildirim_tarihi)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Çıkış Tarihi:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/tarih", array("isim" => "cikis_tarihi", "sifirla" => true, "value" => $cihaz->cikis_tarihi)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Teslim Durumu:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/teslim_durumu", array("sifirla" => true, "value" => $cihaz->teslim_edildi)); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="cihaz-bilgileri" role="tabpanel" aria-labelledby="cihaz-bilgileri-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th class="align-middle">Cihaz Türü:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/cihaz_turleri", array("sifirla" => true, "value" => $cihaz->cihaz_turu)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Markası:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/cihaz_markasi", array("sifirla" => true, "value" => $cihaz->cihaz)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Modeli:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/cihaz_modeli", array("sifirla" => true, "value" => $cihaz->cihaz_modeli)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Seri Numarası:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/seri_no", array("sifirla" => true, "value" => $cihaz->seri_no)); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="teknik-servis-bilgileri" role="tabpanel" aria-labelledby="teknik-servis-bilgileri">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th class="align-middle">Teslim alınırken belirlenen hasar türü:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/hasar_turu", array("sifirla" => true, "value" => $cihaz->cihazdaki_hasar)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Teslim alınırken yapılan hasar tespiti:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/hasar_tespiti", array("sifirla" => true, "value" => $cihaz->hasar_tespiti)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Arıza Açıklaması:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/ariza_aciklamasi", array("sifirla" => true, "value" => $cihaz->ariza_aciklamasi)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Servis Türü:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/servis_turu", array("sifirla" => true, "value" => $cihaz->servis_turu)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Yedek Alınacak mı?:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/yedek", array("sifirla" => true, "value" => $cihaz->yedek_durumu)); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="aksesuar-bilgileri" role="tabpanel" aria-labelledby="aksesuar-bilgileri-bilgileri">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th class="align-middle">Taşıma Çantası:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Taşıma Çantası", "id" => "tasima_cantasi", "sifirla" => true, "value" => $cihaz->tasima_cantasi)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Sarj Adaptörü:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Sarj Adaptörü", "id" => "sarj_adaptoru", "sifirla" => true, "value" => $cihaz->sarj_adaptoru)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Pil:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/aksesuar_select", array("isim" => "Pil", "id" => "pil", "sifirla" => true, "value" => $cihaz->pil)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Diğer:</th>
                                        <td class="align-middle">
                                            <?php $this->load->view("ogeler/diger_aksesuar_bilgileri", array("sifirla" => true, "value" => $cihaz->diger_aksesuar)); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="yapilan-islemler" role="tabpanel" aria-labelledby="yapilan-islemler">
                        Yapılan İşlemler
                    </div>
                </div>
                <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">
                        <a href="javascript:void(0);" id="sifirla" class="btn btn-secondary me-2 mt-2 mr-2">
                            Sıfırla
                        </a>
                        <a href="<?= base_url("cihaz/" . $cihaz->id); ?>" class="btn btn-success me-2 mt-2">
                            Kaydet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>