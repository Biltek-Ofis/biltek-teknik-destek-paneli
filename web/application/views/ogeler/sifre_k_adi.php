<?php
if (!isset($sifre_k_adi_label)) {
    $sifre_k_adi_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($sifre_k_adi_label) {
    echo '<label class="form-label" for="sifre_k_adi';
if (isset($id)) {
    echo $id;
}
echo '">Kullanıcı Adı:</label>';
}
echo '
    <input id="sifre_k_adi';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="k_adi" placeholder="Kullanıcı Adı" value="';
if (isset($sifre_k_adi_value)) {
    echo $sifre_k_adi_value;
}
echo '"'.(isset($sifre_k_adi_readonly) ? ($sifre_k_adi_readonly ? " readonly" : "") : "").' required>
</div>';
