<?php
if (!isset($cihaz_modeli_label)) {
    $cihaz_modeli_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($cihaz_modeli_label) {
    echo '<label class="form-label" for="cihaz_modeli">Modeli:</label>';
}
echo '
    <input id="cihaz_modeli" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="cihaz_modeli" placeholder="Modeli" value="';
if (isset($cihaz_modeli_value)) {
    echo $cihaz_modeli_value;
}
echo '"'.(isset($cihaz_modeli_readonly) ? ($cihaz_modeli_readonly ? " readonly" : "") : "").'>
</div>';
