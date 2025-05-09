<?php
echo '<div class="col-12';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Barkod";
echo '">
    <label class="form-label" for="barkod">'.$input_basligi.'</label>
    <input id="barkod" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="barkod" placeholder="'.$input_basligi.'" value="';
if (isset($barkod_value)) {
    echo $barkod_value;
}
echo '">
</div>';
