<?php $this->load->view("inc/datatables_scripts");

echo '<script>
    $(document).ready(function() {
        var tabloDiv = "#tahsilat_sekli_tablosu";
        var tahsilatTablosu = $(tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari('[0, "asc"]') . ');
        var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash).modal(\'show\');
        }
    });
</script>';
echo '<div class="content-wrapper">';

$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> "Tahsilat Şekilleri",
        "items"=> array(
            array(
                "link"=> base_url(),
                "text"=> "Anasayfa",
            ),
            array(
                "text"=> "Yonetim",
            ),
            array(
                "active"=> TRUE,
                "text"=> "Tahsilat Şekilleri",
            ),
        ),
    ),
));
echo '<section class="content">
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button type="button" class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#yeniTahsilatSekliEkleModal">
                            Yeni Tahsilat Şekli Ekle
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="yeniTahsilatSekliEkleModal" tabindex="-1" aria-labelledby="yeniTahsilatSekliEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniTahsilatSekliEkleModalLabel">Tahsilat Sekli Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="tahsilatSekliEkleForm" autocomplete="off" method="post" action="' . base_url("yonetim/tahsilatSekliEkle") . '">
                                    <div class="row">';
$this->load->view("ogeler/tahsilat_sekli_isim");
echo '</div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="tahsilatSekliEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tahsilat_sekli_tablosu" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kod</th>
                                <th>İsim</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>';

foreach ($this->Cihazlar_Model->tahsilatSekilleri() as $tahsilatSekli) {

    echo '<tr>
                                    <td>
                                        ' . $tahsilatSekli->id . '
                                    </td>
                                    <td>
                                        ' . $tahsilatSekli->isim . '
                                    </td>
                                    <td class="align-middle text-center">

                                        <a href="#" class="btn btn-info text-white ml-1" data-bs-toggle="modal" data-bs-target="#tahsilatSekliDuzenleModal' . $tahsilatSekli->id . '">Düzenle</a><a href="#" class="btn btn-danger ml-1" data-bs-toggle="modal" data-bs-target="#tahsilatSekliSilModal' . $tahsilatSekli->id . '">Sil</a>
                                    </td>
                                </tr>';

    echo '<div class="modal fade" id="tahsilatSekliSilModal' . $tahsilatSekli->id . '" tabindex="-1" aria-labelledby="tahsilatSekliSilModal' . $tahsilatSekli->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content modal-danger">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tahsilatSekliSilModal' . $tahsilatSekli->id . 'Label">Tahsilat Şekli Sil</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="fw-bold">' . $tahsilatSekli->isim . '</span> türünü silmek istediğinize emin misiniz?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="' . base_url("yonetim/tahsilatSekliSil/" . $tahsilatSekli->id) . '" class="btn btn-danger">Evet</a>
                                                    <a href="#" class="btn btn-success" data-bs-dismiss="modal">Hayır</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="tahsilatSekliDuzenleModal' . $tahsilatSekli->id . '" tabindex="-1" aria-labelledby="tahsilatSekliDuzenleModal' . $tahsilatSekli->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tahsilatSekliDuzenleModal' . $tahsilatSekli->id . 'Label">Tahsilat Şekli Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="tahsilatSekliDuzenleForm' . $tahsilatSekli->id . '" autocomplete="off" method="post" action="' . base_url("yonetim/tahsilatSekliDuzenle/" . $tahsilatSekli->id) . '">
                                                        <div class="row">';
    $this->load->view("ogeler/tahsilat_sekli_isim", array("tahsilat_sekli_isim_value" => $tahsilatSekli->isim, "id" => $tahsilatSekli->id));
    echo '</div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-success" form="tahsilatSekliDuzenleForm' . $tahsilatSekli->id . '" value="Kaydet" />
                                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
}
echo
'</tbody>
</table>
</div>
</div>
</div>
</section>
</div>';
