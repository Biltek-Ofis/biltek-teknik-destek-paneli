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
echo '">';
if(isset($label)){
    echo $label;
}else{
    echo "Şifre";
}
echo '</label>
    <input onClick="this.select();" id="kullanici_sifre';
if (isset($id)) {
    echo $id;
}
echo '" class="form-control" type="';
if(isset($sifre_type) && strlen($sifre_type) > 0){
    echo $sifre_type;
}else{
    echo "password";
}
echo '" name="';
if(isset($name)){
    echo $name;
}else{
    echo "sifre";
}
echo '" minlength="6" placeholder="Şifre" autocomplete="new-password" value="';
if (isset($value)) {
    echo $value;
}
echo '"';
if(isset($required)){
    if($required){
        echo " required";
    }
}else{
    echo " required";
}
echo '>
</div>';
