<?php
if (!isset($cihaz_markasi_label)) {
    $cihaz_markasi_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($cihaz_markasi_label) {
    echo '<label class="form-label" for="cihaz">Cihaz Markası (*):</label>';
}
echo '
    <input id="cihaz" autocomplete="' . $this->Islemler_Model->rastgele_yazi() . '" class="form-control" type="text" name="cihaz" placeholder="Cihaz Markası *" value="';
if (isset($cihaz_value)) {
    echo $cihaz_value;
}
echo '" required'.(isset($cihaz_readonly) ? ($cihaz_readonly ? " readonly" : "") : "").'>
</div>';
