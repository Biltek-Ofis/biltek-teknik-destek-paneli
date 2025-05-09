<?php
echo '<div class="col-12';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="teslim_eden" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="teslim_eden" placeholder="Teslim Eden Kişi" value="';
if (isset($teslim_eden_value)) {
    echo $teslim_eden_value;
}
echo '">

</div>';
