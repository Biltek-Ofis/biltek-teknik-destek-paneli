<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="adres" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="adres" placeholder="Adresi" value="';
if (isset($adres_value)) {
    echo $adres_value;
}
echo '">
</div>';
