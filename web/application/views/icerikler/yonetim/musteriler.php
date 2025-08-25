<?php $this->load->view("inc/datatables_scripts");

echo '<script>
    $(document).ready(function() {
        var tabloDiv = "#musteri_tablosu";
        var cihazlarTablosu = $(tabloDiv).DataTable('.$this->Islemler_Model->datatablesAyarlari('[0, "asc"]').');
        var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash).modal(\'show\');
        }
    });
</script>';
echo '<div class="content-wrapper">';

$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> $baslik,
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
                "text"=> $baslik,
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
                        <button type="button" class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#yeniMusteriEkleModal">
                            Yeni Müşteri Ekle
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="yeniMusteriEkleModal" tabindex="-1" aria-labelledby="yeniMusteriEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniMusteriEkleModalLabel">Müşteri Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="musteriEkleForm" autocomplete="off" method="post" action="' . base_url("yonetim/musteriEkle/") . '">
                                <div class="row">';
                                    $this->load->view("ogeler/musteri_adi", array("musteri_adi_form" => "#musteriEkleForm", "musteri_adi_sayi" => "3", "musteri_adi_oto" => FALSE));
                                echo '</div>
                                <div class="row">';
                                    $this->load->view("ogeler/adres");
                                echo '</div>
                                <div class="row">';
                                    $this->load->view("ogeler/gsm", array("gsm_id" => "telefon_numarasi1"));
                                echo '</div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="musteriEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="musteri_tablosu" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Müşteri Kodu</th>
                                <th>Müşteri Adı</th>
                                <th>Adres</th>
                                <th>GSM</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>';

foreach ($this->Kullanicilar_Model->musteriBilgileri() as $musteri) {

    echo '<tr>
                                    <td>
                                        ' . $musteri->id . '
                                    </td>
                                    <td>
                                        ' . $musteri->musteri_adi;
    echo '</td>
                                    <td>
                                        ' . $musteri->adres . '
                                    </td>
                                    <td>
                                        ' . $musteri->telefon_numarasi . '
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="#" class="btn btn-info text-white ml-1" data-bs-toggle="modal" data-bs-target="#musteriDuzenleModal' . $musteri->id . '">Düzenle</a><a href="#" class="btn btn-danger ml-1" data-bs-toggle="modal" data-bs-target="#musteriSilModal' . $musteri->id . '">Sil</a>
                                    </td>
                                </tr>';

        echo '<div class="modal fade" id="musteriSilModal' . $musteri->id . '" tabindex="-1" aria-labelledby="musteriSilModal' . $musteri->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content modal-danger">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="musteriSilModal' . $musteri->id . 'Label">Müşteri Sil</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="fw-bold">' . $musteri->musteri_adi . '</span> isimli müşteriyi silmek istediğinize emin misiniz?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="' . base_url("yonetim/musteriSil/" . $musteri->id) .'" class="btn btn-danger">Evet</a>
                                                    <a href="#" class="btn btn-success" data-bs-dismiss="modal">Hayır</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="musteriDuzenleModal' . $musteri->id . '" tabindex="-1" aria-labelledby="musteriDuzenleModal' . $musteri->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="musteriDuzenleModal' . $musteri->id . 'Label">Müşteri Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="musteriDuzenleForm' . $musteri->id . '" autocomplete="off" method="post" action="' . base_url("yonetim/musteriDuzenle/" . $musteri->id) . '">
                                                    <div class="row">';
                                                        $this->load->view("ogeler/musteri_adi", array("musteri_adi_value" => $musteri->musteri_adi, "musteri_kod_value" => $musteri->id, "musteri_adi_form" => "#musteriDuzenleForm" . $musteri->id, "musteri_adi_sayi" => "4_". $musteri->id, "musteri_adi_oto" => FALSE));
    echo '</div>
                                                    <div class="row">';
                                                        $this->load->view("ogeler/adres", array("adres_value" => $musteri->adres));
echo '</div>
                                                    <div class="row">';
                                                        $this->load->view("ogeler/gsm", array("gsm_id" => "telefon_numarasi2", "telefon_numarasi_value" => $musteri->telefon_numarasi));
echo '</div>
                                                    <div class="row">';
                                                        $this->load->view("ogeler/musteri_cihazlarini_guncelle");
echo '</div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-success" form="musteriDuzenleForm' . $musteri->id . '" value="Kaydet" />
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
