<?php
echo '<div class="col-12';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "İndirimli Fiyatı";
echo '">
    <label class="form-label" for="indirimli">'.$input_basligi.'</label>
    <input id="indirimli" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="indirimli" placeholder="'.$input_basligi.'" value="';
if (isset($indirimli_value)) {
    echo $indirimli_value;
}
echo '">
</div>';
