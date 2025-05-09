<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="kullanici_yonetici';
if (isset($id)) {
    echo $id;
}
echo '">Hesap Türü</label>
    <select id="kullanici_yonetici';
if (isset($id)) {
    echo $id;
}
$hesapTuru = -1;
if(isset($kullaniciTuru)){
    $hesapTuru = $kullaniciTuru;
}
echo '" class="form-select" name="yonetici" aria-label="Yönetici">
        <option value="0"';
if (isset($value) && $value == 0) {
    echo " selected";
}else if($hesapTuru == 0){
    echo " selected";
}
echo '>Personel</option>
        <option value="1"';
if (isset($value) && $value == 1) {
    echo " selected";
}else if($hesapTuru == 1){
    echo " selected";
}
echo '>Yönetici</option>
    </select>
</div>';
