<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="cihaz" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="cihaz" placeholder="Cihaz Markası *" value="';
if (isset($cihaz_value)) {
    echo $cihaz_value;
}
echo '" required>
</div>';
