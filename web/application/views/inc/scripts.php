<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
	crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		$('input, textarea').on("keyup change", function(){
			var val = $(this).val();
			var corrected = val.replace(/sarz|şarz/gi, function(match) {
				return match === match.toUpperCase() ? "ŞARJ" : "şarj";
			});
			if (corrected !== val) {
				$(this).val(corrected);
			}
		});
	});
</script>
<?php
$this->load->view("inc/ortak/scripts");