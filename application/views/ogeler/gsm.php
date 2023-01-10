<?php
echo '<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>';
echo '<script>
    $(document).ready(function(){
        $("#telefon_numarasi").inputmask("+99 (999) 999-9999");
    });
    </script>';
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <label for="telefon_numarasi">GSM:</label>
    <input id="telefon_numarasi" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="telefon_numarasi" class="form-control" type="tel" value="';
if (isset($telefon_numarasi_value)) {
    echo $telefon_numarasi_value;
} else {
    echo "+90";
}
echo '" required>
</div>';
