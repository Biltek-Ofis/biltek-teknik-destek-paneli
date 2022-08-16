<?php
echo '<script src="'. base_url("plugins/jquery/jquery.min.js").'"></script>
<script src="'. base_url("plugins/bootstrap/js/bootstrap.bundle.min.js").'"></script>
<script src="'. base_url("dist/js/panel.min.js").'"></script>
<script>
	function formuYazdir(id) {
		teknikServisFormuPencere = window.open(
			\''. base_url("cihaz/teknik_servis_formu").'/\' + id,
			"teknikServisFormuPencere" + id,
			\'status=1,width=\' + screen.availWidth + \',height=\' + screen.availHeight
		);
		$(teknikServisFormuPencere).ready(function() {
			teknikServisFormuPencere.print();
		});
	}
	function barkoduYazdir(id) {
		barkodPencere = window.open(
			\''. base_url("cihaz/barkod").'/\' + id,
			"barkodPencere" + id,
			\'status=1,width=\' + screen.availWidth + \',height=\' + screen.availHeight
		);
		$(barkodPencere).ready(function() {
			barkodPencere.print();
		});
	}
</script>';