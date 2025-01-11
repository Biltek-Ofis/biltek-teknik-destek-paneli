<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "KG (Kargo Ücreti hesaplaması için)";
echo ' col-12">
    <label for="kg">'.$input_basligi.'</label>
    <input id="kg" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="kg" placeholder="'.$input_basligi.'" value="';
if (isset($kg_value)) {
    echo $kg_value;
}
echo '">
</div>';
