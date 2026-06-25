<?php
if (!isset($sifre_aciklama_label)) {
    $sifre_aciklama_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($sifre_aciklama_label) {
    echo '<label class="form-label" for="sifre_aciklama';
if (isset($id)) {
    echo $id;
}
echo '">Şifre Açıklaması:</label>';
}
echo '
    <input id="sifre_aciklama';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="aciklama" placeholder="Şifre Açıklaması" value="';
if (isset($sifre_aciklama_value)) {
    echo $sifre_aciklama_value;
}
echo '"'.(isset($sifre_aciklama_readonly) ? ($sifre_aciklama_readonly ? " readonly" : "") : "").' required>
</div>';
