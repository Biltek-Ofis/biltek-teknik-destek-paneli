<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="fis_no" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="fis_no" placeholder="Fiş No" value="';
if (isset($fis_no_value)) {
    echo $fis_no_value;
}
echo '">
</div>';
