<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Alış Fiyatı *";
echo ' col-12">
    <label for="alis">'.$input_basligi.'</label>
    <input id="alis" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="alis" placeholder="'.$input_basligi.'" value="';
if (isset($alis_value)) {
    echo $alis_value;
}
echo '" required>
</div>';
