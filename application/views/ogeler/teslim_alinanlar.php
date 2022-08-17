<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <textarea id="teslim_alinanlar" autocomplete="off" name="teslim_alinanlar" class="form-control" rows="3" placeholder="Teslim Alınanlar" required>';
if (isset($teslim_alinanlar_value)) {
    echo $teslim_alinanlar_value;
}
echo '</textarea>
</div>';
