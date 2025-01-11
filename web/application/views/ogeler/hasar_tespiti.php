<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <textarea id="hasar_tespiti" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="hasar_tespiti" class="form-control" rows="3" placeholder="Teslim alınırken yapılan hasar tespiti">';
if (isset($hasar_tespiti_value)) {
    echo $hasar_tespiti_value;
}
echo '</textarea>
</div>';
