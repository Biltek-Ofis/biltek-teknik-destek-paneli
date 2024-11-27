<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="satis" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="satis" placeholder="Satış Fiyatı *" value="';
if (isset($satis_value)) {
    echo $satis_value;
}
echo '" required>
</div>';
