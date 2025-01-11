<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <select id="servis_turu" class="form-control" name="servis_turu" aria-label="Servis Türü">
        <option value="0"';
if (isset($servis_turu_value) && $servis_turu_value == 0) {
    echo " selected";
}
echo '>Servis Türü Seçin</option>
        <option value="1"';
if (isset($servis_turu_value) && $servis_turu_value == 1) {
    echo " selected";
}
echo '>' . $this->Islemler_Model->servisTuru(1) . '</option>
        <option value="2"';
if (isset($servis_turu_value) && $servis_turu_value == 2) {
    echo " selected";
}
echo '>' . $this->Islemler_Model->servisTuru(2) . '</option>
        <option value="3"';
if (isset($servis_turu_value) && $servis_turu_value == 3) {
    echo " selected";
}
echo '>' . $this->Islemler_Model->servisTuru(3) . '</option>
        <option value="4"';
if (isset($servis_turu_value) && $servis_turu_value == 4) {
    echo " selected";
}
echo '>' . $this->Islemler_Model->servisTuru(4) . '</option>
    </select>
</div>';
