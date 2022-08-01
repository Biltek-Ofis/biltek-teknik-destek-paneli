<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <input id="seri_no" autocomplete="one-time-code" class="form-control" type="text" name="seri_no" placeholder="Cihazın Seri Numarası" value="<?php if(isset($seri_no_value)) {echo $seri_no_value;} ?>">
</div>