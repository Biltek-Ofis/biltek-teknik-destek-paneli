<?php
if(!isset($musteri_adi_oto)){
    $musteri_adi_oto = TRUE;
}

echo '<div class="col-12';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="musteri_kod" name="musteri_kod" type="hidden" value="';
if (isset($musteri_kod_value)) {
    echo $musteri_kod_value;
}
echo '">
    <input id="musteri_adi'.$musteri_adi_sayi.'" data-mainform="'.$musteri_adi_form.'" data-oto="'.($musteri_adi_oto ? "true" : "false").'" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control musteri_adi" type="text" name="musteri_adi" placeholder="Müşteri Adı Soyadı *" value="';
if (isset($musteri_adi_value)) {
    echo $musteri_adi_value;
}
echo '" required>
<ul id="musteri_adi_liste" class="typeahead dropdown-menu col musteri_adi_liste" style="max-height:300px;overflow-y: auto;" role="listbox">

</ul>
</div>';
