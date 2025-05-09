<?php
echo '<div class="';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="cikis_tarihi" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="datetime-local" name="cikis_tarihi" value="';
if (isset($cikis_tarihi_value)) {
    echo  $this->Islemler_Model->tarihDonusturInput($cikis_tarihi_value);
}
echo '">
</div>';
