<?php
if (!isset($ariza_aciklamasi_label)) {
    $ariza_aciklamasi_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($ariza_aciklamasi_label) {
    echo '<label class="form-label" for="ariza_aciklamasi">Arıza Açıklaması (*):</label>';
}
echo '
    <textarea id="ariza_aciklamasi" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="ariza_aciklamasi" class="form-control" rows="3" placeholder="Arıza Açıklaması *" required>';
if (isset($ariza_aciklamasi_value)) {
    echo $ariza_aciklamasi_value;
}
echo '</textarea>
</div>';
