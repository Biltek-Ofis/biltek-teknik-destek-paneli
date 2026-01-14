<?php $this->load->view("inc/datatables_scripts");

echo '<script>
    ayrilma_durumu_tetikle = false;
    $(document).ready(function() {
        ayrilma_durumu_tetikle = false;
        var tabloKategoriDiv = "#kategori_tablosu";
        var kategoriTablosu = $(tabloKategoriDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari('[0, "asc"]') . ');
        var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash).modal(\'show\');
        }
    });
</script>';
echo '<div class="content-wrapper">';

$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> "İşlem Ücretleri",
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
                "text"=> "İşlem Ücretleri",
            ),
        ),
    ),
));
echo '<section class="content">
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                        <h3>Ücretler</h3>
                    </div>
                    <div class="col-6 col-lg-6 text-end">';

                    if($this->Kullanicilar_Model->yonetici()){
                            echo '
                        <button type="button" class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#yeniUcretEkleModal">
                            Yeni Ucret Ekle
                        </button>';
                    }
                    echo '</div>
                </div>';
                if($this->Kullanicilar_Model->yonetici()){
                        echo '
                    <div class="modal fade" id="yeniUcretEkleModal" tabindex="-1" aria-labelledby="yeniUcretEkleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="yeniUcretEkleModalLabel">Ucret Ekle</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="ucretEkleForm" autocomplete="off" method="post" action="' . base_url("yonetim/ucretEkle") . '">
                                <div class="row">';
$this->load->view("ogeler/ucret_kategori");
echo '</div>
<div class="row">';
$this->load->view("ogeler/ucret_isim");
echo '</div>
<div class="row">';
$this->load->view("ogeler/ucret_fiyat");
echo '</div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" form="ucretEkleForm" value="Ekle" />
                            <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                        </div>
                    </div>
                </div>
            </div>';
                }
                echo '
                <div class="table-responsive">
                    <table id="ucret_tablosu" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kod</th>
                                <th>Kategori</th>
                                <th>İsim</th>
                                <th>Fiyat</th>';
                                if($this->Kullanicilar_Model->yonetici()){
                                    echo '<th>İşlemler</th>';
                                }
                                echo '
                            </tr>
                        </thead>
                        <tbody>';
foreach ($this->Ucretler_Model->ucretler() as $ucret) {
    echo '<tr>
                                    <td>
                                        ' . $ucret->id . '
                                    </td>
                                    <td>
                                        ';
                                      $kategori = $this->Ucretler_Model->kategoriBul($ucret->cat_id);
                                      if($kategori != null && $kategori->num_rows() > 0){
                                            echo $kategori->first_row()->isim;
                                      }else if($ucret->cat_id == DIGER_ID){
                                            echo "DİĞER";
                                      }else{
                                            echo "Belirtilmemiş";
                                      }
                                    echo '
                                    </td>
                                    <td>
                                        ' . $ucret->isim . '
                                    </td>
                                    <td>
                                        ' . $ucret->ucret . ' TL
                                    </td>';
                                    if($this->Kullanicilar_Model->yonetici()){
                                        echo '<td class="align-middle text-center">
                                        <a href="#" class="btn btn-info text-white ml-1" data-bs-toggle="modal" data-bs-target="#ucretDuzenleModal' . $ucret->id . '">Düzenle</a>
                                        <a href="#" class="btn btn-danger ml-1" data-bs-toggle="modal" data-bs-target="#ucretSilModal' . $ucret->id . '">Sil</a>
                                        </td>';
                                    }
                                    
                                echo '</tr>';
                    if($this->Kullanicilar_Model->yonetici()){
                        echo '<div class="modal fade" id="ucretSilModal' . $ucret->id . '" tabindex="-1" aria-labelledby="ucretSilModal' . $ucret->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content modal-danger">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ucretSilModal' . $ucret->id . 'Label">Ucret Sil</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="fw-bold">' . $ucret->isim . '</span> ücretini silmek istediğinize emin misiniz?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="' . base_url("yonetim/ucretSil/" . $ucret->id) . '" class="btn btn-danger">Evet</a>
                                                    <a href="#" class="btn btn-success" data-bs-dismiss="modal">Hayır</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="ucretDuzenleModal' . $ucret->id . '" tabindex="-1" aria-labelledby="ucretDuzenleModal' . $ucret->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ucretDuzenleModal' . $ucret->id . 'Label">Ucret Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="ucretDuzenleForm' . $ucret->id . '" autocomplete="off" method="post" action="' . base_url("yonetim/ucretDuzenle/" . $ucret->id) . '">
                                                        <div class="row">';
                                                        $this->load->view("ogeler/ucret_kategori", array("kategori_value" => $ucret->cat_id, "id" => $ucret->id));
                                                        echo '</div>
                                                        <div class="row">';
                                                        $this->load->view("ogeler/ucret_isim", array("ucret_isim_value" => $ucret->isim, "id" => $ucret->id));
                                                        echo '</div>
                                                        <div class="row">';
                                                        $this->load->view("ogeler/ucret_fiyat", array("ucret_value" => $ucret->ucret, "id" => $ucret->id));
                                                        echo '</div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-success" form="ucretDuzenleForm' . $ucret->id . '" value="Kaydet" />
                                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                    }
}
                        echo '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>';
if($this->Kullanicilar_Model->yonetici()){
echo '<section class="content">
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                        <h3>Kategoriler</h3>
                    </div>
                    <div class="col-6 col-lg-6 text-end">';
                        if($this->Kullanicilar_Model->yonetici()){
                            echo '
                        <button type="button" class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#yeniKategoriEkleModal">
                            Yeni Kategori Ekle
                        </button>';
                        }
                    echo '</div>
                </div>';
                if($this->Kullanicilar_Model->yonetici()){
                            echo '<div class="modal fade" id="yeniKategoriEkleModal" tabindex="-1" aria-labelledby="yeniKategoriEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniKategoriEkleModalLabel">Kategori Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="kategoriEkleForm" autocomplete="off" method="post" action="' . base_url("yonetim/kategoriEkle") . '">
                                    <div class="row">';
$this->load->view("ogeler/kategori_isim");
echo '</div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="kategoriEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>';
                        }
                echo '
                <div class="table-responsive">
                    <table id="kategori_tablosu" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kod</th>
                                <th>İsim</th>';
                                if($this->Kullanicilar_Model->yonetici()){
                                        echo '<th>İşlemler</th>';
                                }
                            echo '</tr>
                        </thead>
                        <tbody>';

foreach ($this->Ucretler_Model->kategoriler() as $kategori) {

    echo '<tr>
                                    <td>
                                        ' . $kategori->id . '
                                    </td>
                                    <td>
                                        ' . $kategori->isim . '
                                    </td>';
                                    if($this->Kullanicilar_Model->yonetici()){
                                        
                                    echo '
                                        <td class="align-middle text-center">
                                            <a href="#" class="btn btn-info text-white ml-1" data-bs-toggle="modal" data-bs-target="#kategoriDuzenleModal' . $kategori->id . '">Düzenle</a>
                                            <a href="#" class="btn btn-danger ml-1" data-bs-toggle="modal" data-bs-target="#kategoriSilModal' . $kategori->id . '">Sil</a>
                                        </td>';
                                    }
                                echo ' </tr>';
                        if($this->Kullanicilar_Model->yonetici()){
                            echo '<div class="modal fade" id="kategoriSilModal' . $kategori->id . '" tabindex="-1" aria-labelledby="kategoriSilModal' . $kategori->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content modal-danger">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="kategoriSilModal' . $kategori->id . 'Label">Kategori Sil</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="fw-bold">' . $kategori->isim . '</span> kategorisini silmek istediğinize emin misiniz?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="' . base_url("yonetim/kategoriSil/" . $kategori->id) . '" class="btn btn-danger">Evet</a>
                                                    <a href="#" class="btn btn-success" data-bs-dismiss="modal">Hayır</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="kategoriDuzenleModal' . $kategori->id . '" tabindex="-1" aria-labelledby="kategoriDuzenleModal' . $kategori->id . 'Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="kategoriDuzenleModal' . $kategori->id . 'Label">Kategori Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="kategoriDuzenleForm' . $kategori->id . '" autocomplete="off" method="post" action="' . base_url("yonetim/kategoriDuzenle/" . $kategori->id) . '">
                                                        <div class="row">';
    $this->load->view("ogeler/kategori_isim", array("kategori_isim_value" => $kategori->isim, "id" => $kategori->id));
    echo '</div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-success" form="kategoriDuzenleForm' . $kategori->id . '" value="Kaydet" />
                                                    <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                        }
                                
}
echo
'</tbody>
</table>
</div>
</div>
</div>
</section>';
}
echo '</div>';
