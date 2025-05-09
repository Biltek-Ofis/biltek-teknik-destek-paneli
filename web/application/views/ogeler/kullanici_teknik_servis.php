<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="kullanici_teknikservis';
if (isset($id)) {
    echo $id;
}
echo '">Teknik Servis Elemanı</label>
    <select id="kullanici_teknikservis';
if (isset($id)) {
    echo $id;
}
echo '" class="form-select" name="teknikservis" aria-label="Teknik Servis Elemanı">
        <option value="1"';
if (isset($value) && $value == 1) {
    echo " selected";
}
echo '>Evet</option>
        <option value="0"';
if (isset($value) && $value == 0) {
    echo " selected";
}
echo '>Hayır</option>
    </select>
</div>';
