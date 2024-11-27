<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <textarea id="aciklama" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="aciklama" class="form-control" rows="3" placeholder="Açıklama">';
if (isset($aciklama_value)) {
    echo $aciklama_value;
}
echo '</textarea>
</div>';
