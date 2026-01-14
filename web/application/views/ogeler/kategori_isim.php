<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="isim';
if (isset($id)) {
    echo $id;
}
echo '">İsim</label>
    <input id="isim';
if (isset($id)) {
    echo $id;
}
echo '" class="form-control" type="text" name="isim" minlength="3" placeholder="İsim" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" value="';
if (isset($kategori_isim_value)) {
    echo $kategori_isim_value;
}
echo '" required>
</div>';
