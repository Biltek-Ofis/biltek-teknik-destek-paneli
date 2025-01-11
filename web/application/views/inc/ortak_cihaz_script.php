<?php
echo '
function faturaDurumuInputlar(par, val_fd){
	if(val_fd == '.(count($this->Islemler_Model->faturaDurumu) - 1).'){
		$(par+" #fatura_durumu_td").prop("colspan", "1");
		$(par+" #fis_no_td").prop("colspan", "1");
		$(par+" #fis_no_td").show();
		$(par+" #fis_no").prop("required", "required");
	}else{
		$(par+" #fatura_durumu_td").prop("colspan", "2");
		$(par+" #fis_no_td").prop("colspan", "0");
		$(par+" #fis_no_td").hide();
		$(par+" #fis_no").val("");
		$(par+" #fis_no").removeAttr("required");
	}
}
    ';

echo '
function cihazTurleriSifre(par, value){
    var sifreGerekli = true;
    switch(value){';
$cihazTurleri = $this->Cihazlar_Model->cihazTurleri();
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
    //$(par+" #cihaz_sifresi").prop("required", sifreGerekli);
}
    ';