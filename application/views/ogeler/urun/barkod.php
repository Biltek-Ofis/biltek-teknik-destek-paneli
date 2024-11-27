<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="barkod" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="barkod" placeholder="Barkod *" value="';
if (isset($barkod_value)) {
    echo $barkod_value;
}
echo '" required>
</div>';
