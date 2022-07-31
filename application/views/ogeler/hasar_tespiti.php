<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <textarea id="hasar_tespiti" name="hasar_tespiti" class="form-control" rows="3" placeholder="Teslim alınırken yapılan hasar tespiti"><?php if(isset($hasar_tespiti_value)) {echo $hasar_tespiti_value;} ?></textarea>
</div>