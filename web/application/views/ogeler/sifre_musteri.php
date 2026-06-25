<?php
if (!isset($sifre_musteri_label)) {
    $sifre_musteri_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($sifre_musteri_label) {
    echo '<label class="form-label" for="sifre_musteri';
if (isset($id)) {
    echo $id;
}
echo '">Müşteri İsmi:</label>';
}
echo '
    <input id="sifre_musteri';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="musteri_adi" placeholder="Müşteri İsmi" value="';
if (isset($sifre_musteri_value)) {
    echo $sifre_musteri_value;
}
echo '"'.(isset($sifre_musteri_readonly) ? ($sifre_musteri_readonly ? " readonly" : "") : "").' required>
</div>';
