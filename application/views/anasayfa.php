<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Anasayfa</title>
	<?php $this->load->view("inc/styles");?>
</head>
<body>
<?php $this->load->view("inc/navbar");?>
<div id="container">
	<div class="row">
    	<div class="col-12">
			<button class="btn btn-success float-end me-2" data-bs-toggle="modal" data-bs-target="#yeniCihazEkleModal">Yeni Cihaz Girişi</button>
		</div>
 	 </div>
	<h5 class="mx-2">Devam Eden Cihazlar</h5>
	
	<?php $this->load->view("cihaz_tablosu", array("cihazlar"=>$devamEdenCihazlar));?>
	
	<h5 class="mx-2">Teslim Edilen Cihazlar</h5>
	
	<?php $this->load->view("cihaz_tablosu", array("cihazlar"=>$teslimEdilenCihazlar));?>
</div>
<div class="modal fade" id="yeniCihazEkleModal" tabindex="-1" aria-labelledby="yeniCihazEkleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
      	<div class="modal-header">
        	<h5 class="modal-title" id="yeniCihazEkleModalLabel">Yeni Cihaz Girişi</h5>
        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      	</div>
      	<div class="modal-body">
			<form id="newDeviceForm" method="post" action="<?= base_url("anasayfa/cihazEkle");?>">
	  			<input class="form-control" type="text" name="musteri_adi" placeholder="Müşterinin Adı">
	  			<input class="form-control mt-3" type="text" name="cihaz" placeholder="Cihaz">
	  			<input class="form-control mt-3" type="text" name="ariza_aciklamasi" placeholder="Arıza Açıklaması">
			</form>
      	</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
			<button type="button" onClick="$('#newDeviceForm').submit();" class="btn btn-primary">Ekle</button>
		</div>
    </div>
  </div>
</div>
<?php $this->load->view("inc/scripts");?>
</body>
</html>
