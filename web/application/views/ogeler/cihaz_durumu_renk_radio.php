<?php
if(!isset($renk_kodu) || !isset($renk_ismi)){
    throw new Exception("Renk ismi veya kodu veya değeri belirtilmemiş.");
}
echo '<div class="row">
<label class="form-check-label" for="renk_'.$renk_kodu.'';
if (isset($id)) {
    echo $id;
}
echo '">
    <input id="renk_'.$renk_kodu.'';
if (isset($id)) {
    echo $id;
}
echo '" class="form-check-input" type="radio" name="renk" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" value="bg-'.$renk_kodu.'"';
if (isset($cihaz_durumu_renk_value)) {
    if($cihaz_durumu_renk_value == "bg-".$renk_kodu){
        echo " checked";
    }
}
echo ' required>
    <i class="bg-'.$renk_kodu.'" style="border: .5px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</i> '.$renk_ismi.'</label>
</div>';
?>