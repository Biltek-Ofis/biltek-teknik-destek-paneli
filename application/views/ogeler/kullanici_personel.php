<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <label for="kullanici_yonetici';
if (isset($id)) {
    echo $id;
}
echo '">Hesap Türü</label>
    <select id="kullanici_yonetici';
if (isset($id)) {
    echo $id;
}
echo '" class="form-control" name="yonetici" aria-label="Yönetici">
        <option value="0"';
if (isset($value) && $value == 0) {
    echo " selected";
}
echo '>Personel</option>
        <option value="1"';
if (isset($value) && $value == 1) {
    echo " selected";
}
echo '>Yönetici</option>
    </select>
</div>';
