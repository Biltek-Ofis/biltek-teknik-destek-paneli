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
			<button class="btn btn-success float-end me-2" data-bs-toggle="modal" data-bs-target="#newDeviceModal">Yeni Cihaz Girişi</button>
		</div>
 	 </div>
	<h5 class="mx-2">Devam Eden Cihazlar</h5>
	
			<?php
			if(count($not_completed_devices)>0){
				echo '<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">İşlem Kodu</th>
						<th scope="col">İsim</th>
						<th scope="col">Cihaz</th>
						<th scope="col">Arıza Açıklaması</th>
						<th scope="col">Güncel Durum</th>
						<th scope="col">İşlem</th>
					</tr>
				</thead>
				<tbody>';
				
				foreach ($not_completed_devices as $not_completed_device) {
					echo "<tr>
					<th scope=\"row\">" . $not_completed_device->id . "</th>
					<td>" . $not_completed_device->musteri_adi . "</td>
					<td>" . $not_completed_device->cihaz . "</td>
					<td>" . $not_completed_device->ariza_aciklamasi . "</td>
					<td>";
					if($not_completed_device->teslim_edildi == 1){
						echo "Teslim Edildi";
					}else{
						echo "Devam Ediyor";
					}
					echo "</td>
					<td><button class=\"btn btn-info text-white\">Görüntüle</button></td></tr>";
				}
				echo '
				</tbody>
			</table>';
			}else{
				echo '<div class="alert alert-success" role="alert">
				İşlemi Devam Eden Ürün Yok
            </div>';
			}
			?>
	
	<h5 class="mx-2">Teslim Edilen Cihazlar</h5>
	
			<?php
			if(count($completed_devices)>0){
				echo '<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">İşlem Kodu</th>
						<th scope="col">İsim</th>
						<th scope="col">Cihaz</th>
						<th scope="col">Arıza Açıklaması</th>
						<th scope="col">Güncel Durum</th>
						<th scope="col">İşlem</th>
					</tr>
				</thead>
				<tbody>';
				
				foreach ($completed_devices as $completed_device) {
					echo "<tr>
					<th scope=\"row\">" . $completed_device->id . "</th>
					<td>" . $completed_device->musteri_adi . "</td>
					<td>" . $completed_device->cihaz . "</td>
					<td>" . $completed_device->ariza_aciklamasi . "</td>
					<td>";
					if($completed_device->teslim_edildi == 1){
						echo "Teslim Edildi";
					}else{
						echo "Devam Ediyor";
					}
					echo "</td>
					<td><button class=\"btn btn-info text-white\">Görüntüle</button></td></tr>";
				}
				echo '
				</tbody>
			</table>';
			}else{
				echo '<div class="alert alert-success" role="alert">
				Teslim Edilen Ürün Yok
            </div>';
			}
			?>
</div>
<div class="modal fade" id="newDeviceModal" tabindex="-1" aria-labelledby="newDeviceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
      	<div class="modal-header">
        	<h5 class="modal-title" id="newDeviceModalLabel">Yeni Cihaz Girişi</h5>
        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      	</div>
      	<div class="modal-body">
			<form id="newDeviceForm" method="post" action="<?= base_url("home/new_device");?>">
	  			<input class="form-control" type="text" name="customer_name" placeholder="Müşterinin Adı">
	  			<input class="form-control mt-3" type="text" name="device" placeholder="Cihaz">
	  			<input class="form-control mt-3" type="text" name="description" placeholder="Arıza Açıklaması">
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
