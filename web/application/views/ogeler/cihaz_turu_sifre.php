<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="sifre';
if (isset($id)) {
    echo $id;
}
echo '">Cihaz Şifresi</label>
    <select id="sifre';
if (isset($id)) {
    echo $id;
}
echo '" class="form-select" name="sifre" aria-label="Şifre" required>
        <option value="">Cihaz şifresi gerekli mi?</option>
        <option value="1"';
if (isset($cihaz_turu_sifre_value) && $cihaz_turu_sifre_value == 1) {
    echo " selected";
}
echo '>Evet</option>
        <option value="0"';
if (isset($cihaz_turu_sifre_value) && $cihaz_turu_sifre_value == 0) {
    echo " selected";
}
echo '>Hayır</option>
    </select>
</div>';
