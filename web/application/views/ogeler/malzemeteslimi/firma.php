<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="firma';
if (isset($id)) {
    echo $id;
}
echo '">Firma</label>
    <input id="firma';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="firma" placeholder="Firma">
</div>';
