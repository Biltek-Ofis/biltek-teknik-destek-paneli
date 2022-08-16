<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="bildirim_tarihi" autocomplete="off" class="form-control" type="datetime-local" name="bildirim_tarihi" value="';
if (isset($bildirim_tarihi_value)) {
    echo  $this->Islemler_Model->tarihDonusturInput($bildirim_tarihi_value);
}
echo '">
</div>';
