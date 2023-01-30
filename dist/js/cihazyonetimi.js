var musteri_bilgileri_onaylandi = false;
var musteri_listesi_hover = false;
$(document).ready(function () {
	var musteri_adi_input = $("#musteri_adi");
	$("#musteri_adi_liste").hover(
		function () {
			musteri_listesi_hover = true;
		},
		function () {
			musteri_listesi_hover = false;
		}
	);
	musteri_adi_input.focusout(function () {
		if (!musteri_listesi_hover) {
			$("#musteri_adi_liste").hide();
		}
	});
	musteri_adi_input.focus(function () {
		if (!musteri_bilgileri_onaylandi) {
			musteriVerileriniGetirAd(musteri_adi_input);
		}
	});
	musteri_adi_input.keyup(function () {
		$("#musteri_kod").val("");
		$("#musteri_kod_text").html("Yok");
		musteriVerileriniGetirAd(musteri_adi_input);
	});
});
function musteriVerileriniGetirAd(musteri_adi_input) {
	var musteri_adi_input_st = musteri_adi_input.val();
	if (musteri_adi_input_st.length > 1) {
		$.post(
			base_url + "/js/musteri_adi",
			{ ara: musteri_adi_input_st },
			function (data) {
				var jsonData = JSON.parse(data);
				if (Object.keys(jsonData).length > 0) {
					$("#musteri_adi_liste").html("");
					$.each(JSON.parse(data), function (index, value) {
						var oge = $(
							'<li class="active"><a class="dropdown-item" href="javascript:void(0);" id="musteri_adi_liste_oge_' +
								index +
								'" role="option">' +
								value.musteri_adi +
								(value.telefon_numarasi ? " / " + value.telefon_numarasi : "") +
								(value.adres ? " / " + value.adres : "") +
								"</a></li>"
						);
						$("#musteri_adi_liste").append(oge);
						$("#musteri_adi_liste_oge_" + index).on("click", function () {
							cihazGirisiVerileri(value);
						});
					});
					$("#musteri_adi_liste").show();
				} else {
					$("#musteri_adi_liste").html("");
					$("#musteri_adi_liste").hide();
				}
			}
		);
	}
}
function cihazGirisiVerileri(value) {
	$("#musteri_adi").val(value.musteri_adi ? value.musteri_adi : "");
	$("#adres").val(value.adres ? value.adres : "");
	$("#telefon_numarasi").val(value.telefon_numarasi ? value.telefon_numarasi : "");
	$("#musteri_kod").val(value.id ? value.id : "");
	$("#musteri_kod_text").html(value.id ? value.id : "");
	musteri_bilgileri_onaylandi = true;
	$("#musteri_adi_liste").hide();
}
