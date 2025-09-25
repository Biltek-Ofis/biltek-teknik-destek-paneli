<?php
if (!isset($seri_no_label)) {
    $seri_no_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($seri_no_label) {
    echo '<label class="form-label" for="seri_no">Cihazın Seri Numarası:</label>';
}
echo '
    <input id="seri_no" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="seri_no" placeholder="Cihazın Seri Numarası" value="';
if (isset($seri_no_value)) {
    echo $seri_no_value;
}
echo '">
</div>';
