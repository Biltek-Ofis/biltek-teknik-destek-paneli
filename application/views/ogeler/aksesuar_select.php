<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <select id="<?= $id; ?>" class="form-control" name="<?= $id; ?>" aria-label="<?= $isim; ?> Hasar Durumu">
        <?php
        for ($i = 0; $i < count($this->Islemler_Model->hasarDurumu); $i++) {
            echo '<option value="' . $i . '"';
            if (isset($aksesuar_value) && $aksesuar_value == $i) {
                echo " selected";
            }
            echo '>';
            if ($i == 0) {
                echo $isim . ' (Varsa) Hasar Durumu';
            } else {
                echo $this->Islemler_Model->hasarDurumu[$i];
            }
            echo '</option>';
        }
        ?>
    </select>
</div>