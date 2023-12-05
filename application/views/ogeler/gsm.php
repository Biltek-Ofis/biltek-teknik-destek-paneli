<?php
if (!isset($telefon_numarasi_label)) {
    $telefon_numarasi_label = FALSE;
}
$telefonNumrasiID = "telefon_numarasi";
if(isset($gsm_id)){
    $telefonNumrasiID = $gsm_id;
}
echo '<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>';
echo '<script>
    $(document).ready(function(){
        $("#' . $telefonNumrasiID . '").inputmask("+99 (999) 999-9999");
    });
    </script>';
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">';
if($telefon_numarasi_label){
    echo '<label for="' . $telefonNumrasiID . '">GSM:</label>';
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
