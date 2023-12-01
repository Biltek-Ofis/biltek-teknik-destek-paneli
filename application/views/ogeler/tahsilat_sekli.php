<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <select id="tahsilat_sekli" class="form-control" name="tahsilat_sekli" aria-label="Tahsilat Şekli">';
    echo '<option value="0">Tahsilat Şekli Seçin</option>';
foreach ($this->Cihazlar_Model->tahsilatSekilleri() as $tahsilatSekli) {
    echo '<option value="' . $tahsilatSekli->id . '"';
    if (isset($tahsilat_sekli_value) && $tahsilat_sekli_value == $tahsilatSekli->id) {
        echo " selected";
    }
    echo '>'.$tahsilatSekli->isim.'</option>';
}
echo '
    </select>
</div>';
