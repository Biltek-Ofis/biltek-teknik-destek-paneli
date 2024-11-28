<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="kg" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="kg" placeholder="KG" value="';
if (isset($kg_value)) {
    echo $kg_value;
}
echo '">
</div>';
