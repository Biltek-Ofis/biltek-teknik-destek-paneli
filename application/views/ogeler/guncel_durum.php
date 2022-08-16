<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input type="hidden" name="guncel_durum_suanki" value="' . (isset($guncel_durum_value) ? $guncel_durum_value : 0) . '">
    <select id="guncel_durum" class="form-control" name="guncel_durum" aria-label="Güncel Durum">';
for ($i = 0; $i < count($this->Islemler_Model->cihazDurumu); $i++) {
    echo '<option value="' . $i . '"';
    if (isset($guncel_durum_value) && $guncel_durum_value == $i) {
        echo " selected";
    }
    echo '>';
    if ($i == 0) {
        echo 'Güncel Durum Seçin (';
    }
    echo $this->Islemler_Model->cihazDurumu[$i];
    if ($i == 0) {
        echo ')';
    }
    echo '</option>';
}
echo '
    </select>
</div>';
