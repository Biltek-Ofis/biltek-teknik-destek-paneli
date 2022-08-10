<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <select id="cihazdaki_hasar" class="form-control" name="cihazdaki_hasar" aria-label="Servis Türü">
        <?php
        for($i = 0; $i < count($this->Islemler_Model->cihazdakiHasar); $i++){
            echo '<option value="'.$i.'" ';
            if (isset($cihazdaki_hasar_value) && $cihazdaki_hasar_value == $i) {
                echo " selected";
            }
            echo '>';
            if($i == 0){
                echo 'Hasar Türü Belirtin';
            }else{
                echo $this->Islemler_Model->cihazdakiHasar[$i];
            }
            echo '</option>';
        }
        ?>
    </select>
</div>