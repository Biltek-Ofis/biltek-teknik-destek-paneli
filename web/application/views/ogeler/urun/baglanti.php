<?php
echo '<div class="col-12';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Ürünün Bağlantısı";
echo '">
    <label class="form-label" for="baglanti">'.$input_basligi.'</label>
    <input id="baglanti" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="0.01" name="baglanti" placeholder="'.$input_basligi.'" value="';
if (isset($baglanti_value)) {
    echo $baglanti_value;
}
echo '">
</div>';
