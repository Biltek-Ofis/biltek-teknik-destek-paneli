<script>
    $(document).ready(function() {
        var hash = location.hash.replace(/^#/, '');
        if (hash) {
            $('#' + hash+'-tab').click();
        }
        $('.nav-tabs a').on('shown.bs.tab', function(e) {
            window.location.hash = e.target.hash;
        })
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
                        <li class="breadcrumb-item active">Cihaz</li>
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
                                                <input class="form-control m-0" type="text" name="adres" placeholder="Adres" value="<?= $cihaz->gsm_mail; ?>">
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="cihaz-bilgileri" role="tabpanel" aria-labelledby="cihaz-bilgileri-tab">
                        Cihaz Bilgileri
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>