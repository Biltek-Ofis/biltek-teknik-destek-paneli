<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <select id="tahsilat_sekli" class="form-control" name="tahsilat_sekli" aria-label="Tahsilat Şekli">';
for ($i = 0; $i < count($this->Islemler_Model->tahsilatSekli); $i++) {
    echo '<option value="' . $i . '"';
    if (isset($tahsilat_sekli_value) && $tahsilat_sekli_value == $i) {
        echo " selected";
    }
    echo '>';
    if ($i == 0) {
        echo 'Tahsilat Şekli Seçin';
    } else {
        echo $this->Islemler_Model->tahsilatSekli[$i];
    }
    echo '</option>';
}
echo '
    </select>
</div>';
