<?php
$cihazTurleri = $this->Cihazlar_Model->cihazTurleri();
?>
<script>
    <?php
    echo '
    function cihazTurleriSifre(value){
        var sifreGerekli = true;
        switch(value){';
    foreach ($cihazTurleri as $cihazTuruJQ) {
        echo '
            case "' . $cihazTuruJQ->id . '":
                sifreGerekli = ' . ($cihazTuruJQ->sifre == 1 ? "true" : "false") . ';
                break;';
    }
    echo '
            default:
                sifreGerekli = false;
                break;';
    echo '
        }
        $("#cihaz_sifresi").prop("required", sifreGerekli);
        $("#cihaz_sifresi").attr("placeholder", sifreGerekli ? "Cihaz Sifresi * (Şifre yoksa belirtin)" : "Cihaz Şifresi");
    }';
    ?>

    $(document).ready(function() {
        $("#cihaz_turu").on("change", function() {
            cihazTurleriSifre($(this).val());
        });
    });
</script>
<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <select id="cihaz_turu" class="form-control" name="cihaz_turu" aria-label="Cihaz türü" required>
        <option value="">Cihaz Türü Seçin *</option>
        <?php
        foreach ($cihazTurleri as $cihazTuru) {
            echo '<option value="' . $cihazTuru->id . '"';
            if (isset($cihaz_turu_value) && ($cihaz_turu_value == $cihazTuru->isim or $cihaz_turu_value == $cihazTuru->id)) {
                echo " selected";
            }
            echo '>' . $cihazTuru->isim . '</option>';
        }
        ?>
    </select>
</div>