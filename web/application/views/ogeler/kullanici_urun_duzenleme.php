<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <label for="kullanici_urunduzenleme';
if (isset($id)) {
    echo $id;
}
echo '">Ürün Düzenleme</label>
    <select id="kullanici_urunduzenleme';
if (isset($id)) {
    echo $id;
}

echo '" class="form-control" name="urunduzenleme" aria-label="Ürün Düzenleme"'.((isset($yonetici) && $yonetici == 1) ? " disabled" : "" ).'>
        <option value="1"';
$onceki_secildi = FALSE;
if ((isset($value) && $value == 1) || (isset($yonetici) && $yonetici == 1)) {
    $onceki_secildi = TRUE;
    echo " selected";
}
echo '>Evet</option>
        <option value="0"';
if (isset($value) && $value == 0 && !$onceki_secildi) {
    echo " selected";
}
echo '>Hayır</option>
    </select>
</div>';
