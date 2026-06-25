<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="kullanici_sifreler';
if (isset($id)) {
    echo $id;
}
echo '">Müşteri Şifreleri</label>
    <select id="kullanici_sifreler';
if (isset($id)) {
    echo $id;
}

echo '" class="form-select" name="sifreler" aria-label="Müşteri Şifreleri"'.((isset($yonetici) && $yonetici == 1) ? " disabled" : "" ).'>
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
