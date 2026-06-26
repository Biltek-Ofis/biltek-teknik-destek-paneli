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
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="password" name="sifre" placeholder="Şifre" value="';
if (isset($sifre_value)) {
    echo $sifre_value;
}
echo '"'.(isset($sifre_readonly) ? ($sifre_readonly ? " readonly" : "") : "").' required> <a href="#" class="btn btn-sm btn-primary ms-2" onclick="sifreGoster(\'sifre';
if (isset($id)) {
    echo $id;
}
echo '\')">Göster</a>
</div>';
