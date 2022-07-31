<div class="form-group<?php if(isset($sifirla)) {echo " p-0 m-0";} ?> col">
    <select id="yedek_durumu" class="form-control" name="yedek_durumu" aria-label="Yedekleme İşlemi">
        <option value="0"<?php if(isset($value) && $value==0) {echo " selected";} ?>>Yedek alınacak mı?</option>
        <option value="1"<?php if(isset($value) && $value==1) {echo " selected";} ?>><?= $this->Islemler_Model->evetHayir(1); ?></option>
        <option value="2"<?php if(isset($value) && $value==2) {echo " selected";} ?>><?= $this->Islemler_Model->evetHayir(2); ?></option>
    </select>
</div>