<?php
$cihazTurleri = $this->Cihazlar_Model->cihazTurleri();

echo '
<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <select id="cihaz_turu" class="form-select" name="cihaz_turu" aria-label="Cihaz türü" required>
        <option value="">Cihaz Türü Seçin *</option>';
foreach ($cihazTurleri as $cihazTuru) {
    echo '<option value="' . $cihazTuru->id . '"';
    if (isset($cihaz_turu_value) && ($cihaz_turu_value == $cihazTuru->isim or $cihaz_turu_value == $cihazTuru->id)) {
        echo " selected";
    }
    echo '>' . $cihazTuru->isim . '</option>';
}
echo '</select>
</div>';
