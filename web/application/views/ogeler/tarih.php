<?php
if(!isset($tarih_id)){
    $tarih_id = "tarih";
}
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="'.$tarih_id.'" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="datetime-local" name="tarih" value="';
if (isset($tarih_value)) {
    echo  $this->Islemler_Model->tarihDonusturInput($tarih_value);
}
echo '">
</div>';
