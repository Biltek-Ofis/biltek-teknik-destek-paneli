<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="gsm_mail" autocomplete="off" class="form-control" type="text" name="gsm_mail" placeholder="GSM & E-Mail *" value="';
if (isset($gsm_mail_value)) {
    echo $gsm_mail_value;
}
echo '" required>
</div>';
