<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="teslim_eden';
if (isset($id)) {
    echo $id;
}
echo '">Teslim Eden</label>
    <input id="teslim_eden';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="teslim_eden" placeholder="Teslim Eden">
</div>';
