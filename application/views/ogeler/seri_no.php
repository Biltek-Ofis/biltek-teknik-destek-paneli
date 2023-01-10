<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="seri_no" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="seri_no" placeholder="Cihazın Seri Numarası" value="';
if (isset($seri_no_value)) {
    echo $seri_no_value;
}
echo '">
</div>';
