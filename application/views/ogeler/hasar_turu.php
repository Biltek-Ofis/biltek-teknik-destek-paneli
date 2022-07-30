<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <select class="form-control" name="cihazdaki_hasar" aria-label="Servis Türü">
        <option value="0"<?php if(isset($value) && $value==0) {echo " selected";} ?>>Hasar Türü Belirtin</option>
        <option value="1"<?php if(isset($value) && $value==1) {echo " selected";} ?>><?= $this->Islemler_Model->cihazdakiHasar(1); ?></option>
        <option value="2"<?php if(isset($value) && $value==2) {echo " selected";} ?>><?= $this->Islemler_Model->cihazdakiHasar(2); ?></option>
        <option value="3"<?php if(isset($value) && $value==3) {echo " selected";} ?>><?= $this->Islemler_Model->cihazdakiHasar(3); ?></option>
        <option value="4"<?php if(isset($value) && $value==4) {echo " selected";} ?>><?= $this->Islemler_Model->cihazdakiHasar(4); ?></option>
    </select>
</div>