<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label for="bolge" class="form-label">Bölge (*):</label>
    <input id="bolge" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="bolge" placeholder="Bölge *" value="';
if (isset($bolge_value)) {
    echo $bolge_value;
}
echo '" required>
</div>';