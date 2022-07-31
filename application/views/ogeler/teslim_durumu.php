<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?>">
    <select id="teslim_edildi" class="form-control" name="teslim_edildi" aria-label="Teslim Durumu">
        <option value="0" <?php if (isset($teslim_edildi_value) && $teslim_edildi_value == 0) {
                                echo " selected";
                            } ?>>Teslim Edilmedi</option>
        <option value="1" <?php if (isset($teslim_edildi_value) && $teslim_edildi_value == 1) {
                                echo " selected";
                            } ?>>Teslim Edildi</option>
    </select>
</div>