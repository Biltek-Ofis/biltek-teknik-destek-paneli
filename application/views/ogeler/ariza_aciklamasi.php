<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <textarea id="ariza_aciklamasi" autocomplete="off" name="ariza_aciklamasi" class="form-control" rows="3" placeholder="Belirtilen arıza açıklaması *" required><?php if(isset($ariza_aciklamasi_value)) {echo $ariza_aciklamasi_value;} ?></textarea>
</div>