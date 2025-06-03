<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="siparis_tarihi';
if (isset($id)) {
    echo $id;
}
echo '">Sipariş Tarihi</label>
    <input id="siparis_tarihi';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="date" name="siparis_tarihi">
</div>';
