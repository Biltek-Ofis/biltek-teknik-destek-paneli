<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="isim" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="isim" placeholder="İsim *" value="';
if (isset($isim_value)) {
    echo $isim_value;
}
echo '" required>
</div>';
