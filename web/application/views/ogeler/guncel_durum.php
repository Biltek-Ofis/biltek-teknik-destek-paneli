<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input type="hidden" name="guncel_durum_suanki" value="' . (isset($guncel_durum_value) ? $guncel_durum_value : 0) . '">
    <select id="guncel_durum" class="form-select" name="guncel_durum" aria-label="Güncel Durum">';
$cihazDurumlari = $this->Cihazlar_Model->cihazDurumlari();
foreach ($cihazDurumlari as $cihazDurumu) {
    echo '<option value="' . $cihazDurumu->id . '"';
    if (isset($guncel_durum_value) && $guncel_durum_value == $cihazDurumu->id) {
        echo " selected";
    }
    echo '>';
    if ($cihazDurumu->varsayilan > 0) {
        echo 'Güncel Durum Seçin (';
    }
    echo $cihazDurumu->durum;
    if ($cihazDurumu->varsayilan > 0) {
        echo ')';
    }
    echo '</option>';
}
echo '
    </select>
</div>';
