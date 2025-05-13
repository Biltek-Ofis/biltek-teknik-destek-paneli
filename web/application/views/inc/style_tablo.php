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

.bg-warning,
table.dataTable tbody tr.bg-warning th,
table.dataTable tbody tr.bg-warning td  {
  background-color: rgba(255, 193, 7, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-pink,
table.dataTable tbody tr.bg-pink th,
table.dataTable tbody tr.bg-pink td  {
  background-color: rgba(232, 62, 140, var(--transparan-kirmizi)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-primary,
table.dataTable tbody tr.bg-primary th,
table.dataTable tbody tr.bg-primary td  {
  background-color: rgba(0, 123, 255, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-danger:not(.badge),
table.dataTable tbody tr.bg-danger:not(.badge) th,
table.dataTable tbody tr.bg-danger:not(.badge) td  {
  background-color: rgba(220, 53, 69, var(--transparan-kirmizi)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-success,
table.dataTable tbody tr.bg-success th,
table.dataTable tbody tr.bg-success td  {
  background-color: rgba(40, 167, 69, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}

.bg-secondary,
table.dataTable tbody tr.bg-secondary th,
table.dataTable tbody tr.bg-secondary td  {
  background-color: rgba(108, 117, 125, var(--transparan)) !important;
  color: var(--yazi-rengi) !important;
}
</style>';