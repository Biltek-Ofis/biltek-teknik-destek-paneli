<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <input id="cihaz_sifresi" autocomplete="off" class="form-control" type="text" name="cihaz_sifresi" placeholder="Cihaz Sifresi * (Şifre yoksa belirtin)" value="<?php if(isset($cihaz_sifresi_value)) {echo $cihaz_sifresi_value;} ?>" required>
</div>