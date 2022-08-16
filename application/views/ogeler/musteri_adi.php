<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col-12">
    <input id="musteri_kod" name="musteri_kod" type="hidden" value="';
if (isset($musteri_kod_value)) {
    echo $musteri_kod_value;
}
echo '">
    <input id="musteri_adi" autocomplete="off" class="form-control" type="text" name="musteri_adi" placeholder="Müşteri Adı Soyadı *" value="';
if (isset($musteri_adi_value)) {
    echo $musteri_adi_value;
}
echo '" required>
<ul id="musteri_adi_liste" class="typeahead dropdown-menu col" style="max-height:300px;overflow-y: auto;" role="listbox">

</ul>
</div>';
