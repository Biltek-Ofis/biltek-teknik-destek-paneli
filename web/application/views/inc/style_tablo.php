<?php

$ayarlar = $this->Ayarlar_Model->getir();
$tema = $this->Ayarlar_Model->kullaniciTema();
echo '
<style>
:root {
  --transparan: 0.3;
  --transparan-kirmizi: 0.4;
  ';
  if($tema->id == 0){
    echo '--yazi-rengi: #1f2d3d;';
  }else{
    
    echo '--yazi-rengi: '.$tema->yazi_rengi.'';
  }
  
  echo '
}

.bg-warning {
  background-color: rgba(255, 193, 7, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-pink {
  background-color: rgba(232, 62, 140, var(--transparan-kirmizi)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-primary {
  background-color: rgba(0, 123, 255, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-danger {
  background-color: rgba(220, 53, 69, var(--transparan-kirmizi)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-success {
  background-color: rgba(40, 167, 69, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-secondary {
  background-color: rgba(108, 117, 125, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}
</style>';