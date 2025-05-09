<?php
$sorumlular123 = $this->Kullanicilar_Model->kullanicilar();

echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <select id="sorumlu" class="form-select" name="sorumlu" aria-label="Sorumlu" required>
        <option value="">Sorumlu Personel Seçin *</option>';
foreach ($sorumlular123 as $sorumlu) {
    if($sorumlu->teknikservis == 1){
        echo '<option value="' . $sorumlu->id . '"';
        if (isset($sorumlu_value) && ($sorumlu_value == $sorumlu->ad_soyad || $sorumlu_value == $sorumlu->id)) {
            echo " selected";
        }
        echo '>' . $sorumlu->ad_soyad . '</option>';
    }
}

echo '</select>
</div>';
