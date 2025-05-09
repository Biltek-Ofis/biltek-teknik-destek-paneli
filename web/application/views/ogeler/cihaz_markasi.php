<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="cihaz" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="cihaz" placeholder="Cihaz Markası *" value="';
if (isset($cihaz_value)) {
    echo $cihaz_value;
}
echo '" required>
</div>';
