<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <label for="kullanici_sifre';
if (isset($id)) {
    echo $id;
}
echo '">Şifre</label>
    <input onClick="this.select();" id="kullanici_sifre';
if (isset($id)) {
    echo $id;
}
echo '" class="form-control" type="password" name="sifre" minlength="6" placeholder="Şifre" autocomplete="off" value="';
if (isset($value)) {
    echo $value;
}
echo '" required>
</div>';
