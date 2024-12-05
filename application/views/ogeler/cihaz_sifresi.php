<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <button id="'.$formID.'DesenGirBtn" type="button" class="btn btn-info" onclick="desenGir'.$formID.'()">Desen Gir</button>
    <input id="cihaz_sifresi" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="cihaz_sifresi" placeholder="Cihaz Sifresi * (Şifre yoksa belirtin)" value="';
if (isset($cihaz_sifresi_value)) {
    echo $cihaz_sifresi_value;
}
echo '" required>
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
    function inputlariDuzenle'.$formID.'(pattern){
        if(pattern.toString() != "NaN"){
            $("#'.$formID.' #cihaz_deseni").val(pattern);
        }else{
            $("#'.$formID.' #cihaz_deseni").val(""); 
        }
    }
    function desenGir'.$formID.'(){
        var sifreVal = $("#'.$formID.' #cihaz_sifresi").val();
        if(sifreVal.length == 0){
            $("#'.$formID.' #cihaz_sifresi").val(" ");
        }
        $("#'.$formID.' #cihaz_sifresi").attr("type", "hidden");
        $("#'.$formID.'Desen").show();
        $("#'.$formID.'DesenGirBtn").text("Şifre Gir");
        $("#'.$formID.'DesenGirBtn").attr("onclick", "sifreGir'.$formID.'()");
        if('.$formID.'DesenP.getPattern().toString() != "NaN"){
            inputlariDuzenle'.$formID.'('.$formID.'DesenP.getPattern());
        }
    }
    function sifreGir'.$formID.'(){
        var sifreVal = $("#'.$formID.' #cihaz_sifresi").val();
        if(sifreVal == " "){
            $("#'.$formID.' #cihaz_sifresi").val("");
        }
        $("#'.$formID.' #cihaz_sifresi").attr("type", "text");
        $("#'.$formID.'Desen").hide();
        $("#'.$formID.'DesenGirBtn").text("Desen Gir");
        $("#'.$formID.'DesenGirBtn").attr("onclick", "desenGir'.$formID.'()");
        $("#'.$formID.' #cihaz_deseni").val("");
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