<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="kullanici_sifre';
if (isset($id)) {
    echo $id;
}
echo '">Şifre</label>
    <input onClick="this.select();" id="kullanici_sifre';
if (isset($id)) {
    echo $id;
}
echo '"';
if(isset($doldurma)){
    if($doldurma == FALSE){
        echo ' autocomplete="'.$this->Islemler_Model->rastgele_yazi().'"';
    }
}
echo ' class="form-control" type="password" name="sifre" minlength="6" placeholder="Şifre" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" value="';
if (isset($value)) {
    echo $value;
}
echo '" required>
</div>';
