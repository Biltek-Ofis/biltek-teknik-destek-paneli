<?php
echo '<div class="form-check';
if (isset($sifirla)) {
    echo " p-0 ml-3";
}else{
    echo " ml-2";
}
echo '">
    <input class="form-check-input" type="checkbox" name="musteri_cihazlarini_guncelle[]" id="musteri_cihazlarini_guncelle">
    <label class="form-check-label" for="musteri_cihazlarini_guncelle">
        Bilgileri müşterinin cihazları için de güncelle.
    </label>
</div>';