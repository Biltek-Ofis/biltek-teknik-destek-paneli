<?php $this->load->view("inc/datatables_scripts");
echo '<style>
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
</style>';
$this->load->view("inc/style_tablo");

$this->load->view("inc/tarayici_uyari");
echo '
<script>
$(document).ready(function() {
    var tabloDiv = "#urun_tablosu";
    var urunlerTablosu = $(tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari("[[ 0, \"asc\" ]]", "true", ' "aoColumns": [
      null,
      null,
      null,
      null,
      null,
      null,
      null
    ],') . ');
});
</script>
';
$urunler = $this->Urunler_Model->urunler();
echo '<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>' . $baslik . '</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item active">' . $baslik . '</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">';
echo '<div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end"><button id="yeniUrunEkleBtn" type="button" class="btn btn-primary me-2 mb-2" style="" data-toggle="modal" data-target="#yeniUrunEkleModal">
                            Yeni Ürün Ekle
                        </button>
                    </div>
                </div>';
            echo '<div id="urunTablosu" class="table-responsive">';
            echo '<table id="urun_tablosu" class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th scope="col">Srok Kodu</th>
                    <th scope="col">Barkod</th>
                    <th scope="col">Ürün Adı</th>
                    <th scope="col">Alış Fiyatı</th>
                    <th scope="col">Satış Fiyatı</th>
                    <th scope="col">İndirimli Fiyatı</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>';
            foreach($urunler as $urun){
                
                echo '<tr>
                    <th>'.$urun->stokkodu.'</th>
                    <th>'.$urun->barkod.'</th>
                    <th>'.$urun->isim.'</th>
                    <td>'.$urun->alis.'</td>
                    <td>'.$urun->satis.'</td>
                    <td>'.$urun->indirimli.'</td>
                    <td class="text-center">
                        <a href="'.base_url("urun/".$urun->id).'" class="btn btn-info">Düzenle</a>
                        <button class="btn btn-danger" onclick="urunuSilModalAc(\''.$urun->id.'\', \''.$urun->isim.'\')">Sil</button>
                    </td>
                </tr>';
            }
            echo '
            </tbody>
            </table>';
            echo '</div>';
echo '</div>
        </div>
    </section>
</div>';

echo '<div class="modal fade" id="yeniUrunEkleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="yeniUrunEkleModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniUrunEkleModalTitle">Yeni Ürün Girişi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="yeniUrunForm" autocomplete="off" method="post" action="' . base_url("urunler/ekle/") . '">
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>';
$this->load->view("icerikler/urunler/form");
echo '                    
</form>
</div>
<div class="modal-footer">
';
echo '<input id="yeniUrunEkleBtn" type="submit" class="btn btn-success" form="yeniUrunForm" value="Ekle" />
    <button type="button" class="btn btn-danger" data-dismiss="modal">İptal</button>
</div>
</div>
</div>
</div>';

echo '
<script>
function urunuSilModalAc(id, isim){
    $("#UrunAdi5").html(isim);
    $("#silOnayBtn").attr("href", "'.base_url("urunler/sil/").'" + id);
    $("#urunSilModal").modal("show");
}';
echo '
$(document).ready(function(){
    $("#urunSilModal").on("hidden.bs.modal", function (e) {
        $("#UrunAdi5").html("");
        $("#silOnayBtn").attr("href", "#");
    });
});
</script>
<div class="modal fade" id="urunSilModal" tabindex="-1" role="dialog" aria-labelledby="urunSilModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="urunSilModalLabel">Ürün Silme İşlemini Onaylayın</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Bu üünü (<span id="UrunAdi5"></span>) silmek istediğinize emin misiniz?
      </div>
      <div class="modal-footer">
        <a id="silOnayBtn" href="#" class="btn btn-success">Evet</a>
        <button class="btn btn-danger" data-dismiss="modal">Hayır</button>
      </div>
    </div>
  </div>
</div>';