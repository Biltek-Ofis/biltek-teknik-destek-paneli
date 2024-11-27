<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="stokkodu" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="stokkodu" placeholder="Stok Kodu *" value="';
if (isset($stokkodu_value)) {
    echo $stokkodu_value;
}
echo '" required>
</div>';
