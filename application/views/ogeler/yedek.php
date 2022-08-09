<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <select id="yedek_durumu" class="form-control" name="yedek_durumu" aria-label="Yedekleme İşlemi">
        <?php
        for ($i = 0; $i < count($this->Islemler_Model->evetHayir); $i++) {
            echo '<option value="' . $i . '"';
            if (isset($yedek_durumu_value) && $yedek_durumu_value == $i) {
                echo " selected";
            }
            if ($i == 0) {
                echo '>Yedek alınacak mı?';
            } else {
                $this->Islemler_Model->evetHayir[$i];
            }
            echo '</option>';
        }
        ?>
    </select>
</div>