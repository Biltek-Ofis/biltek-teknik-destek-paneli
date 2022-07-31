<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <select id="servis_turu" class="form-control" name="servis_turu" aria-label="Servis Türü">
        <option value="0"<?php if(isset($servis_turu_value) && $servis_turu_value==0) {echo " selected";} ?>>Servis Türü Seçin</option>
        <option value="1"<?php if(isset($servis_turu_value) && $servis_turu_value==1) {echo " selected";} ?>><?= $this->Islemler_Model->servisTuru(1); ?></option>
        <option value="2"<?php if(isset($servis_turu_value) && $servis_turu_value==2) {echo " selected";} ?>><?= $this->Islemler_Model->servisTuru(2); ?></option>
        <option value="3"<?php if(isset($servis_turu_value) && $servis_turu_value==3) {echo " selected";} ?>><?= $this->Islemler_Model->servisTuru(3); ?></option>
        <option value="4"<?php if(isset($servis_turu_value) && $servis_turu_value==4) {echo " selected";} ?>><?= $this->Islemler_Model->servisTuru(4); ?></option>
    </select>
</div>