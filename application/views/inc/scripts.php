<?php
echo '<script src="' . base_url("plugins/jquery/jquery.min.js") . '"></script>
<script src="' . base_url("plugins/bootstrap/js/bootstrap.bundle.min.js") . '"></script>
<script src="' . base_url("dist/js/panel.min.js") . '"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
	$(document).ready(function(){
		$.ajaxSetup({
			error: function(xhr, status, error) {
				//alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
				console.log("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
			} 
		});
	});
	function formuYazdir(id) {
		$("#teslimAlanModal").modal("show");
		$("#teslimAlanYazdir").attr("onclick", "formuYazdirOnay(" + id + ")")
	}
	function formuYazdirOnay(id){
		$("#teslimAlanModal").modal("hide");
		var url = "' . base_url("cihaz/teknik_servis_formu") . '/" + id;
		var alan = $("#teslim_alan_form").val();
		if(alan.length > 0){
			url = url + "?alan=" + alan;
		}
		teknikServisFormuPencere = window.open(
			url,
			"teknikServisFormuPencere" + id,
			\'status=1,width=\' + screen.availWidth + \',height=\' + screen.availHeight
		);
		$(teknikServisFormuPencere).ready(function() {
			//teknikServisFormuPencere.print();
		});
	}
	function barkoduYazdir(id) {
		barkodPencere = window.open(
			\'' . base_url("cihaz/barkod") . '/\' + id,
			"barkodPencere" + id,
			\'status=1,width=\' + screen.availWidth + \',height=\' + screen.availHeight
		);
		$(barkodPencere).ready(function() {
			//barkodPencere.print();
		});
	}
	function servisKabulYazdir(id) {
		servisKabulPencere = window.open(
			\'' . base_url("cihaz/servis_kabul") . '/\' + id,
			"servisKabulPencere" + id,
			\'status=1,width=\' + screen.availWidth + \',height=\' + screen.availHeight
		);
		$(servisKabulPencere).ready(function() {
			//servisKabulPencere.print();
		});
	}
</script>';
