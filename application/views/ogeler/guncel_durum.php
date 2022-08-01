<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <select id="guncel_durum" class="form-control" name="guncel_durum" aria-label="Güncel Durum">
        <option value="0"<?php if(isset($guncel_durum_value) && $guncel_durum_value==0) {echo " selected";} ?>>Güncel Durum Seçin (Sırada Bekliyor)</option>
        <option value="1"<?php if(isset($guncel_durum_value) && $guncel_durum_value==1) {echo " selected";} ?>><?= $this->Islemler_Model->cihazDurumu(1); ?></option>
        <option value="2"<?php if(isset($guncel_durum_value) && $guncel_durum_value==2) {echo " selected";} ?>><?= $this->Islemler_Model->cihazDurumu(2); ?></option>
        <option value="3"<?php if(isset($guncel_durum_value) && $guncel_durum_value==3) {echo " selected";} ?>><?= $this->Islemler_Model->cihazDurumu(3); ?></option>
    </select>
</div>