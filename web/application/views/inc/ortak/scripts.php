<?php
echo '
<script src="' . base_url("dist/js/panel.min.js") . '"></script>
<script src="' . base_url("dist/js/patternlock/patternlock.js") . '" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>
<script src="' . base_url("dist/js/kis.js") . '" defer></script>';
echo '
<script>
	$(document).ready(function(){';
$ayarlar = $this->Ayarlar_Model->getir();

echo '
		$.ajaxSetup({
			error: function(xhr, status, error) {
				//alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
				if(error != "abort"){				
					console.log("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
				}
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
	function kargoBilgisiYazdir(id){
		kargoBilgisiPencere = window.open(
			\'' . base_url("cihaz/kargo_bilgisi") . '/\' + id,
			"kargoBilgisiPencere" + id,
			\'status=1,width=\' + screen.availWidth + \',height=\' + screen.availHeight
		);
		$(kargoBilgisiPencere).ready(function() {
			//kargoBilgisiPencere.print();
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

?>
<script>
	var ayrilma_durumu_tetikle = true;
	var ayrilma_durumu_etkin = false;
	function ayrilmaEngeliIptal() {
		ayrilma_durumu_etkin = false;
		window.onbeforeunload = null;
	}
	const ayrilmaMesaji = "Değişiklikler kaydedilmedi. Emin misiniz?";
	function ayrilmaOnay() {
		return "";
	}
	function ayrilmaEngelle() {
		if (ayrilma_durumu_tetikle) {
			window.onbeforeunload = ayrilmaOnay;
			ayrilma_durumu_etkin = true;
		}
	}
	$(document).ready(function () {
		$("input").each(function () {
			var type = $(this).attr("type");
			var id = $(this).attr("id");
			const ignoreInpIds = [
				"karanlikTema",
				"kisModu"
			]
			const ignoreInpTypes = [
				"search"
			]

			var engellenebilir = true;

			if (ignoreInpIds.includes(id) || ignoreInpTypes.includes(type)) {
				engellenebilir = false;
			}

			if (engellenebilir) {
				$(this).on("keyup change", function () {
					ayrilmaEngelle();
				});
			}
		});
		$("select").each(function () {
			$(this).on("change", function () {
				ayrilmaEngelle();
			});
		});
		$("textarea").each(function () {
			$(this).on("change", function () {
				ayrilmaEngelle();
			});
		});
		$(".modal").each(function () {
			$(this).on("hidden.bs.modal", function () {
				$(this).attr("aria-hidden", true);
				if ($(this).find("input").length !== 0 || $(this).find("select").length !== 0 || $(this).find("textarea").length !== 0) {
					ayrilmaEngeliIptal();
				}
			});
			$(this).on("show.bs.modal", function () {
				$(this).attr("aria-hidden", false);
				var id = $(this).attr("id");
				console.log("Kapa");
				if (id == "statusSuccessModal") {
					setTimeout(function () {
						$("#statusSuccessModal").modal("hide");
					}, 1000);
				}
			});
		});
	});

	const karanlikTemaStorageKey = "karanlikTema";

	function karanlikTemaBul() {
		return (localStorage.getItem(karanlikTemaStorageKey) || "false") == "true";
	}
	function karanlikTemaKaydet(durum) {
		if (durum) {
			localStorage.setItem(karanlikTemaStorageKey, "true");
		} else {
			localStorage.removeItem(karanlikTemaStorageKey);
		}
	}
	function karanlikTemaUygulanabilir() {
		var attr = $("html").attr("data-bs-theme");
		if (typeof attr !== 'undefined' && attr !== false) {
			return true;
		}
		return false;
	}
	function karanlikTemaDurum(durum) {
		if (karanlikTemaUygulanabilir()) {
			karDurdur();
			if (durum) {
				$("html").attr("data-bs-theme", "dark");
				$(".btn-dark").addClass("btn-light");
				$(".btn-dark").addClass("text-black");
				$(".btn-dark").removeClass("text-light");
				$(".btn-dark").removeClass("btn-dark");
				<?php
				if (KIS_MODU) {
					?>
					if (kisModuBul()) {
						karYagdir("#FFFFFF", 100);
					}
					<?php
				}
				?>
			} else {
				$("html").attr("data-bs-theme", "light");
				$(".btn-light").addClass("btn-dark");
				$(".btn-light").addClass("text-light");
				$(".btn-light").removeClass("text-black");
				$(".btn-light").removeClass("btn-light");
				<?php
				if (KIS_MODU) {
					?>
					if (kisModuBul()) {
						karYagdir("#1786d0", 100);
					}
					<?php
				}
				?>
			}
			karanlikTemaKaydet(durum);
		}
	}
	function karanlikTemaToggle() {
		if (karanlikTemaUygulanabilir()) {
			var attr = $("html").attr("data-bs-theme");
			karanlikTemaDurum(attr != "dark")
		}
	}
	function karanlikTemaYukle() {
		const karanlikTema = karanlikTemaBul();
		$("#karanlikTema").prop("checked", karanlikTema).change();
	}

	const kisModuStorageKey = "kisModu";
	function kisModuBul() {
		return (localStorage.getItem(kisModuStorageKey) || "true") == "true";
	}
	function kisModuKaydet(durum) {
		if (durum) {
			localStorage.setItem(kisModuStorageKey, "true");
		} else {
			localStorage.setItem(kisModuStorageKey, "false");
		}
	}
	function kisModuDurum(durum) {
		if (durum) {
			if (karanlikTemaBul()) {
				karYagdir("#FFFFFF", 100);
			} else {
				karYagdir("#1786d0", 100);
			}
			$("#santa").show();
			$("#santa-container").show();
		} else {
			karDurdur();

			$("#santa").hide();
			$("#santa-container").hide();
		}
		kisModuKaydet(durum);
	}
	function kisModuToggle() {
		const kisModu = kisModuBul();
		kisModuDurum(!kisModu);
	}
	function kisModuYukle() {
		const kisModu = kisModuBul();
		$("#kisModu").prop("checked", kisModu).change();
	}
	$(document).ready(function () {
		$("#karanlikTema").on("change", function () {
			karanlikTemaDurum($(this).prop("checked") == true);
		});
		karanlikTemaYukle();
		<?php
		if (!KIS_MODU) {
			?>
			localStorage.removeItem(kisModuStorageKey);
			<?php
		}
		?>
		$("#kisModu").on("change", function () {
			kisModuDurum($(this).prop("checked") == true);
		});
		<?php
		if (KIS_MODU) {
			?>
			kisModuYukle();
			<?php
		}
		?>
	});
</script>