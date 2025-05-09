<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <textarea id="ariza_aciklamasi" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="ariza_aciklamasi" class="form-control" rows="3" placeholder="Belirtilen arıza açıklaması *" required>';
if (isset($ariza_aciklamasi_value)) {
    echo $ariza_aciklamasi_value;
}
echo '</textarea>
</div>';
