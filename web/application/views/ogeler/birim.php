<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label for="birim" class="form-label">Birim (*):</label>
    <input id="birim" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="birim" placeholder="Birim *" value="';
if (isset($birim_value)) {
    echo $birim_value;
}
echo '" required>
</div>';