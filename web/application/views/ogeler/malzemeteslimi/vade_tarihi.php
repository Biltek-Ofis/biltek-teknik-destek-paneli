<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="vade_tarihi';
if (isset($id)) {
    echo $id;
}
echo '">Vade Tarihi</label>
    <input id="vade_tarihi';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="date" name="vade_tarihi">
</div>';
