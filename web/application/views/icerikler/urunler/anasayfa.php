<?php
defined('BASEPATH') or exit('No direct script access allowed');

$urunler = $this->Urunler_Model->urunler();

$this->load->view("inc/datatables_scripts");
?>
<style>
    .modal.modal-fullscreen .modal-dialog {
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
        max-width: none;
    }

    .modal.modal-fullscreen .modal-content {
        height: auto;
        height: 100vh;
        border-radius: 0;
        border: none;
    }

    .modal.modal-fullscreen .modal-body {
        overflow-y: auto;
    }
</style>
<?php
$this->load->view("inc/style_tablo");
$this->load->view("inc/tarayici_uyari");
$this->load->view("inc/styles_important");
?>
<script>
    $(document).ready(function () {
        var tabloDiv = "#urun_tablosu";
        var urunlerTablosu = $(tabloDiv).DataTable(<?= $this->Islemler_Model->datatablesAyarlari("[[ 0, \"asc\" ]]", "true", ' "aoColumns": [
      null,
      null,
      null,
      null,
      null,
      null,
      null
    ],'); ?>);
    });
</script>
<div class="content-wrapper">
    <?php
    $this->load->view("inc/content_header", array(
        "contentHeader" => array(
            "baslik" => $baslik,
            "items" => array(
                array(
                    "link" => base_url(),
                    "text" => "Anasayfa",
                ),
                array(
                    "active" => TRUE,
                    "text" => $baslik,
                ),
            ),
        ),
    ));
    ; ?>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button id="yeniUrunEkleBtn" type="button" class="btn btn-primary me-2 mb-2"
                            data-bs-toggle="modal" data-bs-target="#yeniUrunEkleModal">
                            Yeni Ürün Ekle
                        </button>
                    </div>
                </div>
                <div id="urunTablosu" class="table-responsive">
                    <table id="urun_tablosu" class="table table-bordered mt-2" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Barkod</th>
                                <th scope="col">Stok Kodu</th>
                                <th scope="col">Stok Adeti</th>
                                <th scope="col">Bağlantı</th>
                                <th scope="col">Ürün Adı</th>
                                <th scope="col">Alış Fiyatı</th>
                                <th scope="col">Satış Fiyatı</th>
                                <th scope="col">İndirimli Fiyatı</th>
                                <th scope="col">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($urunler as $urun) {
                                ?>
                                <tr>
                                    <th><?= $urun->barkod; ?></th>
                                    <th><?= $urun->stokkodu; ?></th>
                                    <th><?= $urun->stokadeti; ?></th>
                                    <th><a href="<?= $urun->baglanti; ?>" target="_blank">Tıklayın</a></th>
                                    <th><?= $urun->isim; ?></th>
                                    <td><?= $urun->alis; ?></td>
                                    <td><?= $urun->satis; ?></td>
                                    <td><?= $urun->indirimli; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url("urun/" . $urun->id); ?>" class="btn btn-info">Düzenle</a>
                                        <button class="btn btn-danger"
                                            onclick="urunuSilModalAc('<?= $urun->id; ?>', '<?= $urun->isim; ?>')">Sil</button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="yeniUrunEkleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="yeniUrunEkleModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniUrunEkleModalTitle">Yeni Ürün Girişi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="yeniUrunForm" autocomplete="off" method="post" action="<?= base_url("urunler/ekle/"); ?>">
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>
                    <?php
                    $this->load->view("icerikler/urunler/form");
                    ?>
                </form>
            </div>
            <div class="modal-footer"></div>
            <input id="yeniUrunEkleBtn" type="submit" class="btn btn-success" form="yeniUrunForm" value="Ekle" />
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
        </div>
    </div>
</div>
</div>
<script>
    function urunuSilModalAc(id, isim) {
        $("#UrunAdi5").html(isim);
        $("#silOnayBtn").attr("href", "<?= base_url("urunler/sil/"); ?>" + id);
        $("#urunSilModal").modal("show");
    }
    $(document).ready(function () {
        $("#urunSilModal").on("hidden.bs.modal", function (e) {
            $("#UrunAdi5").html("");
            $("#silOnayBtn").attr("href", "#");
        });
    });

</script>
<div class="modal fade" id="urunSilModal" tabindex="-1" role="dialog" aria-labelledby="urunSilModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="urunSilModalLabel">Ürün Silme İşlemini Onaylayın</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bu üünü (<span id="UrunAdi5"></span>) silmek istediğinize emin misiniz?
            </div>
            <div class="modal-footer">
                <a id="silOnayBtn" href="#" class="btn btn-success">Evet</a>
                <button class="btn btn-danger" data-bs-dismiss="modal">Hayır</button>
            </div>
        </div>
    </div>
</div>