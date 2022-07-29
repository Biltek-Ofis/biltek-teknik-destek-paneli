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
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="text" name="musteri_adi" placeholder="Müşteri Adı" value="<?= $cihaz->musteri_adi; ?>" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Adresi: </th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="text" name="adres" placeholder="Adres" value="<?= $cihaz->adres; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">GSM & E-Mail: </th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="text" name="gsm_mail" placeholder="GSM & E-Mail *" value="<?= $cihaz->gsm_mail; ?>" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Giriş Tarihi:</th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="datetime-local" name="tarih" value="<?= $this->Islemler_Model->tarihDonusturInput($cihaz->tarih); ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Bildirim Tarihi:</th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="datetime-local" name="tarih" value="<?= $this->Islemler_Model->tarihDonusturInput($cihaz->bildirim_tarihi); ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Çıkış Tarihi:</th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="datetime-local" name="tarih" value="<?= $this->Islemler_Model->tarihDonusturInput($cihaz->cikis_tarihi); ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Teslim Durumu:</th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <select class="form-control" name="cihaz_turu" aria-label="Cihaz türü">
                                                    <option value="0" <?= ($cihaz->teslim_edildi == 0) ? " selected" : ""; ?>>Teslim Edilmedi</option>
                                                    <option value="1" <?= ($cihaz->teslim_edildi == 1) ? " selected" : ""; ?>>Teslim Edildi</option>
                                                </select>
                                            </div>
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
                                            <?php
                                            $cihazTurleri = $this->Cihazlar_Model->cihazTurleri();
                                            ?>
                                            <div class="form-group m-0 p-0">
                                                <select class="form-control" name="cihaz_turu" aria-label="Cihaz türü" required>
                                                    <option value="" selected>Cihaz Türü Seçin *</option>
                                                    <?php
                                                    foreach ($cihazTurleri as $cihazTuru) {
                                                        echo '<option value="' . $cihazTuru->id . '"' . ($cihaz->cihaz_turu == $cihazTuru->isim ? " selected" : "") . '>' . $cihazTuru->isim . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Markası:</th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="text" name="cihaz" value="<?= $cihaz->cihaz; ?>" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Modeli:</th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="text" name="cihaz" placeholder="Modeli" value="<?= $cihaz->cihaz_modeli; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Seri Numarası:</th>
                                        <td class="align-middle">
                                            <div class="form-group m-0 p-0">
                                                <input class="form-control m-0" type="text" placeholder="Cihazın Seri Numarası" name="seri_no" value="<?= $cihaz->seri_no; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="teknik-servis-bilgileri" role="tabpanel" aria-labelledby="teknik-servis-bilgileri">
                        Teknik servis bilgileri
                    </div>
                    <div class="tab-pane fade" id="aksesuar-bilgileri" role="tabpanel" aria-labelledby="aksesuar-bilgileri-bilgileri">
                        Aksesuar bilgileri
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