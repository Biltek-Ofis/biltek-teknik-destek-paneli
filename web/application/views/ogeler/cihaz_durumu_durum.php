<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <label for="durum';
if (isset($id)) {
    echo $id;
}
echo '">İsim</label>
    <input id="durum';
if (isset($id)) {
    echo $id;
}
echo '" class="form-control" type="text" name="durum" minlength="3" placeholder="İsim" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" value="';
if (isset($cihaz_durumu_durum_value)) {
    echo $cihaz_durumu_durum_value;
}
echo '" required>
</div>';
