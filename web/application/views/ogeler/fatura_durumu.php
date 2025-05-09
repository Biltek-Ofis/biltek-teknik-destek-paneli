<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <select id="fatura_durumu" class="form-select" name="fatura_durumu" aria-label="Fatura Durumu">';
for ($i = 0; $i < count($this->Islemler_Model->faturaDurumu); $i++) {
    echo '<option value="' . $i . '"';
    if (isset($fatura_durumu_value) && $fatura_durumu_value == $i) {
        echo " selected";
    }
    echo '>';
    echo $this->Islemler_Model->faturaDurumu[$i];
    echo '</option>';
}
echo '
    </select>
</div>';
