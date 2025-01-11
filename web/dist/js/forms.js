$(document).ready(function () {
	$("#cihazDuzenleForm, #yapilanIslemlerForm, #upload_form").on(
		"keyup keypress",
		function (e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) {
				e.preventDefault();
				return false;
			}
		}
	);
});
