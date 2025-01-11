<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Barkod";
echo ' col-12">
    <label for="barkod">'.$input_basligi.'</label>
    <input id="barkod" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="barkod" placeholder="'.$input_basligi.'" value="';
if (isset($barkod_value)) {
    echo $barkod_value;
}
echo '">
</div>';
