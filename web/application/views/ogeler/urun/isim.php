<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "İsim *";
echo ' col-12">
    <label for="isim">'.$input_basligi.'</label>
    <input id="isim" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="isim" placeholder="'.$input_basligi.'" value="';
if (isset($isim_value)) {
    echo $isim_value;
}
echo '" required>
</div>';
