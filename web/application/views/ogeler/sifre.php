<?php
if (!isset($sifre_label)) {
    $sifre_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($sifre_label) {
    echo '<label class="form-label" for="sifre">Şifre:</label>';
}
echo '
    <input id="sifre';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="new-password" class="form-control" type="';
if(isset($sifre_type) && strlen($sifre_type) > 0){
    echo $sifre_type;
}else{
    echo "password";
}
echo '" name="sifre" placeholder="Şifre" value="';
if (isset($sifre_value)) {
    echo $sifre_value;
}
echo '"'.(isset($sifre_readonly) ? ($sifre_readonly ? " readonly" : "") : "").' required> <a href="#" class="btn btn-sm btn-primary ms-2" onclick="sifreGoster(\'sifre';
if (isset($id)) {
    echo $id;
}
echo '\')">Göster</a>
</div>';
