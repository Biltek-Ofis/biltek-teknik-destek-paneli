<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
<label class="form-label" for="odeme_durumu';
if (isset($id)) {
    echo $id;
}
echo '">Ödeme Durumu</label>
    <select id="odeme_durumu';
if (isset($id)) {
    echo $id;
}
echo '" class="form-select" name="odeme_durumu" aria-label="Ödeme Durumu">
        <option value="0">Ödenmedi</option>
        <option value="1">Ödendi</option>
    </select>
</div>';
