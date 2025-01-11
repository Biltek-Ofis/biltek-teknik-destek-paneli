<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Açıklama";
echo ' col">
    <label for="aciklama">'.$input_basligi.'</label>
    <textarea id="aciklama" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="aciklama" class="form-control" rows="3" placeholder="'.$input_basligi.'">';
if (isset($aciklama_value)) {
    echo $aciklama_value;
}
echo '</textarea>
</div>';
