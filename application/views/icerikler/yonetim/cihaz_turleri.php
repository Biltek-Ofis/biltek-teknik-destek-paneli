<?php $this->load->view("inc/datatables_scripts");

echo '<script>
    $(document).ready(function() {
        var tabloDiv = "#cihaz_turu_tablosu";
        var cihazlarTablosu = $(tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari([0, "asc"]) . ');
        var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash).modal(\'show\');
        }
    });
</script>';
echo '<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cihaz Türleri</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yonetim</li>
                        <li class="breadcrumb-item active">Cihaz Türleri</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary me-2 mb-2" data-toggle="modal" data-target="#yeniCihazTuruEkleModal">
                            Yeni Cihaz Türü Ekle
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="yeniCihazTuruEkleModal" tabindex="-1" aria-labelledby="yeniCihazTuruEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniCihazTuruEkleModalLabel">Cihaz Türü Ekle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="cihazTuruEkleForm" autocomplete="off" method="post" action="' . base_url("yonetim/cihazTuruEkle") . '">
                                    <div class="row">';
$this->load->view("ogeler/cihaz_turu_isim");
echo '</div>
                                    <div class="row">';
$this->load->view("ogeler/cihaz_turu_sifre");
echo '</div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="cihazTuruEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="cihaz_turu_tablosu" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kod</th>
                                <th>İsim</th>
                                <th>Cihaz Şifresi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>';

foreach ($this->Cihazlar_Model->cihazTurleri() as $cihazTuru) {

    echo '<tr>
                                    <td>
                                        ' . $cihazTuru->id . '
                                    </td>
                                    <td>
                                        ' . $cihazTuru->isim . '
                                    </td>
                                    <td>
                                        ' . ($cihazTuru->sifre == 1 ? "Evet" : "Hayır") . '
                                    </td>
                                    <td class="align-middle text-center">

                                        <a href="#" class="btn btn-info text-white ml-1" data-toggle="modal" data-target="#cihazTuruDuzenleModal' . $cihazTuru->id . '">Düzenle</a><a href="#" class="btn btn-danger ml-1" data-toggle="modal" data-target="#cihazTuruSilModal' . $cihazTuru->id . '">Sil</a>
                                    </td>
                                </tr>';

    echo '<div class="modal fade" id="cihazTuruSilModal' . $cihazTuru->id . '" tabindex="-1" aria-labelledby="cihazTuruSilModal' . $cihazTuru->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="cihazTuruSilModal' . $cihazTuru->id . 'Label">Cihaz Türü Sil</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="font-weight-bold">' . $cihazTuru->isim . '</span> türünü silmek istediğinize emin misiniz?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="' . base_url("yonetim/cihazTuruSil/" . $cihazTuru->id) . '" class="btn btn-danger">Evet</a>
                                                    <a href="#" class="btn btn-success" data-dismiss="modal">Hayır</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="cihazTuruDuzenleModal' . $cihazTuru->id . '" tabindex="-1" aria-labelledby="cihazTuruDuzenleModal' . $cihazTuru->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="cihazTuruDuzenleModal' . $cihazTuru->id . 'Label">Cihaz Türü Düzenle</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="cihazTuruDuzenleForm' . $cihazTuru->id . '" autocomplete="off" method="post" action="' . base_url("yonetim/cihazTuruDuzenle/" . $cihazTuru->id) . '">
                                                        <div class="row">';
    $this->load->view("ogeler/cihaz_turu_isim", array("cihaz_turu_isim_value" => $cihazTuru->isim, "id" => $cihazTuru->id));
    echo '</div>
                                                        <div class="row">';
    $this->load->view("ogeler/cihaz_turu_sifre", array("cihaz_turu_sifre_value" => $cihazTuru->sifre, "id" => $cihazTuru->id));
    echo '</div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-success" form="cihazTuruDuzenleForm' . $cihazTuru->id . '" value="Kaydet" />
                                                    <a href="#" class="btn btn-danger" data-dismiss="modal">İptal</a>
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
