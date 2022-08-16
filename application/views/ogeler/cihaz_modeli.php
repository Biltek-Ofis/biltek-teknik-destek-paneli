<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="cihaz_modeli" autocomplete="off" class="form-control" type="text" name="cihaz_modeli" placeholder="Modeli" value="';
if (isset($cihaz_modeli_value)) {
    echo $cihaz_modeli_value;
}
echo '">
</div>';
