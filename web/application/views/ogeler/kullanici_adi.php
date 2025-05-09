<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="kullanici_adi';
if (isset($id)) {
    echo $id;
}
echo '">Kullanıcı Adı</label>
    <input id="kullanici_adi';
if (isset($id)) {
    echo $id;
}
echo '"';
if(isset($doldurma)){
    if($doldurma == FALSE){
        echo ' autocomplete="'.$this->Islemler_Model->rastgele_yazi().'"';
    }
}
echo ' class="form-control" type="text" name="kullanici_adi" minlength="3" placeholder="Kullanıcı Adı" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" value="';
if (isset($value)) {
    echo $value;
}
echo '" required>
</div>';
