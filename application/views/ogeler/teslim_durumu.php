<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?>">
    <select class="form-control" name="teslim_edildi" aria-label="Teslim Durumu">
        <option value="0" <?php if (isset($value) && $value == 0) {
                                echo " selected";
                            } ?>>Teslim Edilmedi</option>
        <option value="1" <?php if (isset($value) && $value == 1) {
                                echo " selected";
                            } ?>>Teslim Edildi</option>
    </select>
</div>