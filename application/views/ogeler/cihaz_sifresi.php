<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="cihaz_sifresi" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="cihaz_sifresi" placeholder="Cihaz Sifresi * (Şifre yoksa belirtin)" value="';
if (isset($cihaz_sifresi_value)) {
    echo $cihaz_sifresi_value;
}
echo '" required>
</div>';
