<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="ucret';
if (isset($id)) {
    echo $id;
}
echo '">Ücret</label>
    <input id="ucret';
if (isset($id)) {
    echo $id;
}
echo '" class="form-control" type="number" step="0.01" name="ucret" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" value="';
if (isset($ucret_value)) {
    echo $ucret_value;
}
echo '" required>
</div>';
