<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="teslim_tarihi';
if (isset($id)) {
    echo $id;
}
echo '">Teslim Tarihi</label>
    <input id="teslim_tarihi';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="date" name="teslim_tarihi">
</div>';
