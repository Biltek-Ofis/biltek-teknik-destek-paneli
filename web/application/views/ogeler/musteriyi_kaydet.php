<?php
echo '<div class="form-check';
if (isset($sifirla)) {
    echo " p-0 ml-3";
}else{
    echo " ml-2";
}
echo '">
    <input class="form-check-input" type="checkbox" name="musteriyi_kaydet[]" id="musteriyi_kaydet" checked>
    <label class="form-check-label" for="musteriyi_kaydet">
        Müşteri bilgilerini kaydet
    </label>
</div>';