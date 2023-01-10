<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <label for="kullanici_ad';
if (isset($id)) {
    echo $id;
}
echo '">Ad Soyad</label>
    <input id="kullanici_ad';
if (isset($id)) {
    echo $id;
}
echo '"';
if(isset($doldurma)){
    if($doldurma == FALSE){
        echo ' autocomplete="'.$this->Islemler_Model->rastgele_yazi().'"';
    }
}
echo ' class="form-control" type="text" name="ad_soyad" minlength="3" placeholder="Ad Soyad" value="';
if (isset($value)) {
    echo $value;
}
echo '" required>
</div>';
