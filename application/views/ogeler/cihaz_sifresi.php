<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
   <select id="sifre_turu" class="form-control" name="sifre_turu" aria-label="Şifre Türü" required>
    <option value="">Şifre Türü Belirtin *</option>
    <option value="Pin"'.((isset($cihaz_sifresi_value) && strlen($cihaz_sifresi_value) > 0)? " selected" : "").'>Pin</option>
    <option value="Desen"'.((isset($cihaz_deseni_value) && strlen($cihaz_deseni_value) > 0)? " selected" : "").'>Desen</option>
    <option value="Yok"'.((isset($cihaz_sifresi_value) && strlen($cihaz_sifresi_value) == 0 && isset($cihaz_deseni_value) && strlen($cihaz_deseni_value) == 0) ? " selected" : "").'>Şifre Yok</option>
    </select>
</div>';

echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <input id="cihaz_sifresi" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="hidden" name="cihaz_sifresi" placeholder="Cihaz Sifresi *" value="';
if (isset($cihaz_sifresi_value)) {
    echo $cihaz_sifresi_value;
}
echo '">
    <input id="cihaz_deseni" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="hidden" name="cihaz_deseni" value="';
if (isset($cihaz_deseni_value)) {
    echo $cihaz_deseni_value;
}
echo '">
    <br>
    <style>
    #'.$formID.'Desen {
        width: 200px;
        height: 200px;
    }
    svg.patternlock g.lock-lines line {
        stroke-width: 1.5;
        stroke: black;
        opacity: 0.5;
    }
    </style>

    <script>
    $(document).ready(function(){
        $("#'.$formID.' #sifre_turu").on("change", function() {
            console.log( this.value );
            if(this.value.toString() == "Pin"){
                $("#'.$formID.' #cihaz_sifresi").attr("type", "text");
                $("#'.$formID.' #cihaz_sifresi").attr("required", "required");
                $("#'.$formID.'Desen").hide();
                $("#'.$formID.' #cihaz_deseni").val("");
                $("#'.$formID.' #cihaz_sifresi").val("");
                '.$formID.'DesenP.clear();
            }else if(this.value.toString() == "Desen"){
                $("#'.$formID.' #cihaz_sifresi").attr("type", "hidden");
                $("#'.$formID.'Desen").show();
                $("#'.$formID.' #cihaz_sifresi").val("");
                inputlariDuzenle'.$formID.'('.$formID.'DesenP.getPattern());
            }else if(this.value.toString() == "Yok"){
                $("#'.$formID.' #cihaz_sifresi").attr("type", "hidden");
                $("#'.$formID.' #cihaz_sifresi").removeAttr("required");
                $("#'.$formID.'Desen").hide();
                $("#'.$formID.' #cihaz_deseni").val("");
                $("#'.$formID.' #cihaz_sifresi").val("Yok");
                
                '.$formID.'DesenP.clear();
            }
        });
    });
    function inputlariDuzenle'.$formID.'(pattern){
        if(pattern.toString() != "NaN"){
            $("#'.$formID.' #cihaz_deseni").val(pattern);
        }else{
            $("#'.$formID.' #cihaz_deseni").val(""); 
        }
    }
    </script>
    <svg class="patternlock success" id="'.$formID.'Desen" style="display:none;" xmlns="http://www.w3.org/2000/svg">';
        
            echo '
            <g class="lock-actives"></g>
            <g class="lock-lines"></g>
            <g class="lock-dots">
                <circle cx="20" cy="20" r="5"></circle>
                <circle cx="80" cy="20" r="5"></circle>
                <circle cx="140" cy="20" r="5"></circle>
    
                <circle cx="20" cy="70" r="5"></circle>
                <circle cx="80" cy="70" r="5"></circle>
                <circle cx="140" cy="70" r="5"></circle>
    
                <circle cx="20" cy="120" r="5"></circle>
                <circle cx="80" cy="120" r="5"></circle>
                <circle cx="140" cy="120" r="5"></circle>
            </g>
            ';
    echo '
    </svg>
    <script type="text/javascript">
    var '.$formID.'DesenE = document.getElementById("'.$formID.'Desen");
    var '.$formID.'DesenP = new PatternLock('.$formID.'DesenE, {
        onPattern: function() {
            this.success();
            inputlariDuzenle'.$formID.'(this.getPattern());
        }
    });
    </script>
</div>';