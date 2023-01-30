<?php
echo '<script>
$(document).ready(function() {
    $("#fatura_durumu").on("change", function() {
        var fatura_durumu = $(this).val();
        if(fatura_durumu == '.(count($this->Islemler_Model->faturaDurumu) - 1).'){
            $("#fatura_durumu_td").prop("colspan", "1");
            $("#fis_no_td").prop("colspan", "1");
            $("#fis_no_td").show();
            $("#fis_no").prop("required", "required");
        }else{
            $("#fatura_durumu_td").prop("colspan", "2");
            $("#fis_no_td").hide();
            $("#fis_no_td").prop("colspan", "0");
            $("#fis_no").val("");
            $("#fis_no").removeAttr("required");
        }
    });
});
</script>';
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <select id="fatura_durumu" class="form-control" name="fatura_durumu" aria-label="Fatura Durumu">';
for ($i = 0; $i < count($this->Islemler_Model->faturaDurumu); $i++) {
    echo '<option value="' . $i . '"';
    if (isset($fatura_durumu_value) && $fatura_durumu_value == $i) {
        echo " selected";
    }
    echo '>';
    echo $this->Islemler_Model->faturaDurumu[$i];
    echo '</option>';
}
echo '
    </select>
</div>';
