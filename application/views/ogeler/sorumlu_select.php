<?php
$sorumlular123 = $this->Kullanicilar_Model->kullaniciListesi();
?>
<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <select id="sorumlu" class="form-control" name="sorumlu" aria-label="Sorumlu" required>
        <option value="">Sorumlu Personel Seçin *</option>
        <?php
        foreach ($sorumlular123 as $sorumlu) {
            echo '<option value="' . $sorumlu->id . '"';
            $sorumTamAd = $sorumlu->ad . " " . $sorumlu->soyad;
            if (isset($sorumlu_value) && ($sorumlu_value == $sorumTamAd || $sorumlu_value == $sorumlu->id)) {
                echo " selected";
            }
            echo '>' . $sorumTamAd . '</option>';
        }
        ?>
    </select>
</div>