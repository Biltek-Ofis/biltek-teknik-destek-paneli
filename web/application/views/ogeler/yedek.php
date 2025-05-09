<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <select id="yedek_durumu" class="form-select" name="yedek_durumu" aria-label="Yedekleme İşlemi">';
for ($i = 0; $i < count($this->Islemler_Model->evetHayir); $i++) {
    echo '<option value="' . $i . '"';
    if (isset($yedek_durumu_value) && $yedek_durumu_value == $i) {
        echo " selected";
    }
    echo ">";
    if ($i == 0) {
        echo 'Yedek alınacak mı?';
    } else {
        echo $this->Islemler_Model->evetHayir[$i];
    }
    echo '</option>';
}

echo '</select>
</div>';
