<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="indirimli" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="indirimli" placeholder="İndirimli Fiyatı *" value="';
if (isset($indirimli_value)) {
    echo $indirimli_value;
}
echo '" required>
</div>';
