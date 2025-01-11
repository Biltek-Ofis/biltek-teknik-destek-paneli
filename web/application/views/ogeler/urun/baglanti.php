<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Ürünün Bağlantısı";
echo ' col-12">
    <label for="baglanti">'.$input_basligi.'</label>
    <input id="baglanti" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="baglanti" placeholder="'.$input_basligi.'" value="';
if (isset($baglanti_value)) {
    echo $baglanti_value;
}
echo '">
</div>';
