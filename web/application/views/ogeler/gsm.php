<?php
if (!isset($telefon_numarasi_label)) {
    $telefon_numarasi_label = FALSE;
}
$telefonNumrasiIDOrj = "telefon_numarasi";
$telefonNumrasiID = $telefonNumrasiIDOrj;
if(isset($gsm_id)){
    $telefonNumrasiID = $gsm_id;
}
if($telefonNumrasiID != $telefonNumrasiIDOrj){
    echo '<script>
    $(document).ready(function(){
        $("#' . $telefonNumrasiID . '").inputmask("+99 (999) 999-9999");
    });
    </script>';
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if($telefon_numarasi_label){
    echo '<label class="form-label" for="' . $telefonNumrasiID . '">GSM:</label>';
}
echo '<input id="' . $telefonNumrasiID . '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="telefon_numarasi" class="form-control" type="tel" value="';
if (isset($telefon_numarasi_value)) {
    if(strlen($telefon_numarasi_value)>0){
        echo $telefon_numarasi_value;
    }else{
        echo "+90";
    }
} else {
    echo "+90";
}
echo '" required>
</div>';
