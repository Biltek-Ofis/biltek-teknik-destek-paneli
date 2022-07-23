<?php
if(count($cihazlar)>0){
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">İşlem Kodu</th>
            <th scope="col">Müşteri Adı</th>
            <th scope="col">Cihaz Türü</th>
            <th class="d-none d-lg-table-cell" scope="col">Cihaz</th>
            <th class="d-none d-lg-table-cell" scope="col">Giriş Tarihi</th>
            <th scope="col" colspan="2">İşlem</th>
        </tr>
    </thead>
    <tbody>';
    $this->load->model("Anasayfa_Model");
    foreach ($cihazlar as $cihaz) {
        echo '<tr>
        <th scope="row">' . $cihaz->id . '</th>
        <td>' . $cihaz->musteri_adi . '</td>
        <td>' . $this->Anasayfa_Model->cihazTuru($cihaz->cihaz_turu). '</td>
        <td class="d-none d-lg-table-cell">' . $cihaz->cihaz . '</td>';
        echo '</td>
        <td class="d-none d-lg-table-cell">' . $this->Anasayfa_Model->tarihDonustur($cihaz->tarih). '</td>
        <td><a href="#" class="btn btn-info text-white">Görüntüle</a></td>
        <td><a href="#"  class="btn btn-danger text-white ms-2" data-bs-toggle="modal" data-bs-target="#cihazıSilModal'.$cihaz->id.'">Sil</a></td></tr>';
        echo '<div class="modal fade" id="cihazıSilModal'.$cihaz->id.'" tabindex="-1" aria-labelledby="cihazıSilModal'.$cihaz->id.'Label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="cihazıSilModal'.$cihaz->id.'Label">Cihaz Silme İşlemini Onaylayın</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Bu cihazı silmek istediğinize emin misiniz?
                </div>
              <div class="modal-footer">
                  <a href="'.base_url("anasayfa/cihazSil/".$cihaz->id).'" type="button" class="btn btn-success">Evet</a>
                  <a href="#" type="button" class="btn btn-danger" data-bs-dismiss="modal">Hayır</a>
              </div>
          </div>
        </div>
      </div>';
    }
    echo '
    </tbody>
</table>';
echo '</div>';
}else{
    echo '<div class="alert alert-success" role="alert">
    Bu Kategoride Cihaz Yok
</div>';
}
?>