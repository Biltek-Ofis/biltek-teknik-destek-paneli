<?php
$cihazTurleri = $this->Cihazlar_Model->cihazTurleri();
?>
<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <select id="cihaz_turu" class="form-control" name="cihaz_turu" aria-label="Cihaz türü" required>
        <option value="">Cihaz Türü Seçin *</option>
        <?php
        foreach ($cihazTurleri as $cihazTuru) {
            echo '<option value="' . $cihazTuru->id . '"';
            if (isset($value) && ($value == $cihazTuru->isim or $value == $cihazTuru->id)) {
                echo " selected";
            }
            echo '>' . $cihazTuru->isim . '</option>';
        }
        ?>
    </select>
</div>