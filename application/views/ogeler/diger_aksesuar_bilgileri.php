<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="diger_aksesuar" autocomplete="off" class="form-control" type="text" name="diger_aksesuar" placeholder="Diğer aksesuar bilgileri" value="';
if (isset($diger_aksesuar_value)) {
    echo $diger_aksesuar_value;
}
echo '">
</div>';
