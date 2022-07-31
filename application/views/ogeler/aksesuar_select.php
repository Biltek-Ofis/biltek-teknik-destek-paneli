<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <select id="<?= $id; ?>" class="form-control" name="<?= $id; ?>" aria-label="<?= $isim; ?> Hasar Durumu">
        <option value="0"<?php if(isset($value) && $value==0) {echo " selected";} ?>><?= $isim; ?> (Varsa) Hasar Durumu</option>
        <option value="1"<?php if(isset($value) && $value==1) {echo " selected";} ?>><?= $this->Islemler_Model->hasarDurumu(1); ?></option>
        <option value="2"<?php if(isset($value) && $value==2) {echo " selected";} ?>><?= $this->Islemler_Model->hasarDurumu(2); ?></option>
    </select>
</div>