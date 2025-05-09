<?php
echo '<div class="col-12';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Satış Fiyatı";
echo '">
    <label class="form-label" for="satis">'.$input_basligi.'</label>
    <input id="satis" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="satis" placeholder="'.$input_basligi.'" value="';
if (isset($satis_value)) {
    echo $satis_value;
}
echo '">
</div>';
