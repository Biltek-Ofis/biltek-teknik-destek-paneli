var islemBilgileriHover = [false, false, false, false, false];
var stok_bilgileri_onaylandi = [false, false, false, false, false];
$(document).ready(function () {
	for (let i = 1; i <= 10; i++) {
		$("#yapilanIslem" + i).focus;
		$("#stok_liste_" + i).hover(
			function () {
				islemBilgileriHover[i - 1] = true;
			},
			function () {
				islemBilgileriHover[i - 1] = false;
			}
		);
		$("#yapilanIslem" + i).focusout(function () {
			if (!islemBilgileriHover[i - 1]) {
				$("#stok_liste_" + i).hide();
			}
		});
		$("#yapilanIslem" + i).focus(function () {
			var yapilanIslem = $("#yapilanIslem" + i).val();
			if (!stok_bilgileri_onaylandi[i - 1]) {
				stoklariGetir(yapilanIslem, i);
			}
		});
		$("#yapilanIslem" + i).on("change keyup", function () {
			$("#stokKodText" + i).html("Yok");
			$("#yapilanIslemStokKod" + i).val("");
			var yapilanIslem = $("#yapilanIslem" + i).val();
			if (yapilanIslem.length > 0) {
				$("#yapilanIslemMiktar" + i).prop("required", true);
				$("#yapilanIslemFiyat" + i).prop("required", true);
			} else {
				$("#yapilanIslemMiktar" + i).prop("required", false);
				$("#yapilanIslemFiyat" + i).prop("required", false);
			}
			stoklariGetir(yapilanIslem, i);
		});
		$(
			"#yapilanIslemMiktar" +
				i +
				", #yapilanIslemFiyat" +
				i +
				", #yapilanIslemKdv" +
				i
		).on("change keyup", function () {
			islemHesapla(i);
		});
	}
});
function islemHesapla(i) {
	var yapilanIslemMiktar = $("#yapilanIslemMiktar" + i).val() ?? 0;
	var yapilanIslemFiyat = $("#yapilanIslemFiyat" + i).val() ?? 0;
	var yapilanIslemKdv = $("#yapilanIslemKdv" + i).val() ?? 0;
	var tutar = yapilanIslemMiktar * yapilanIslemFiyat;
	var kdv = (tutar / 100) * yapilanIslemKdv;
	var toplamKdvli = tutar+kdv;
	$("#yapilanIslemTutar" + i).html(
		tutar > 0 ? parseFloat(tutar).toFixed(2) + " TL" : ""
	);
	$("#yapilanIslemTopKdv" + i).html(
		kdv > 0 ? parseFloat(kdv).toFixed(2) + " TL (" + yapilanIslemKdv + "%)" : ""
	);
	var toplamKdvli = 
	$("#yapilanIslemToplam" + i).html(
		kdv > 0 && tutar > 0? (parseFloat(toplamKdvli).toFixed(2)) + " TL" : ""
	);
	tutarHesapla();
}
function tutarHesapla() {
	var toplam = 0;
	var kdv = 0;
	for (let i = 1; i <= 10; i++) {
		var miktar = $("#yapilanIslemMiktar" + i).val() ?? 0;
		var birim_fiyati = $("#yapilanIslemFiyat" + i).val() ?? 0;
		var kdv_orani = $("#yapilanIslemKdv" + i).val() ?? 0;
		var tutar = miktar * birim_fiyati;
		var top_kdv = (tutar / 100) * kdv_orani;
		kdv = kdv + top_kdv;
		toplam = toplam + tutar;
	}
	var genel_toplam = toplam + kdv;
	$("#yapilanIslemToplam").html(
		toplam > 0 ? parseFloat(toplam).toFixed(2) + " TL" : ""
	);

	$("#yapilanIslemKdv").html(kdv > 0 ? parseFloat(kdv).toFixed(2) + " TL" : "");

	$("#yapilanIslemGenelToplam").html(
		genel_toplam > 0 ? parseFloat(genel_toplam).toFixed(2) + " TL" : ""
	);
}
function stoklariGetir(yapilanIslem, i) {
	/*if (yapilanIslem.length > 1) {
		$.post(base_url + "/js/stok", { ara: yapilanIslem }, function (data) {
			var jsonData = JSON.parse(data);
			if (Object.keys(jsonData).length > 0) {
				$("#stok_liste_" + i).html("");
				$.each(JSON.parse(data), function (index, value) {
					var oge = $(
						'<li class="active"><a class="dropdown-item" href="javascript:void(0);" id="stok_adi_liste_oge_' +
							i +
							"_" +
							index +
							'" role="option">' +
							value.STOK_ADI +
							"</a></li>"
					);
					$("#stok_liste_" + i).append(oge);
					$("#stok_adi_liste_oge_" + i + "_" + index).on("click", function () {
						stokVerileri(value, i);
					});
				});
				$("#stok_liste_" + i).show();
			} else {
				$("#stok_liste_" + i).html("");
				$("#stok_liste_" + i).hide();
			}
		});
	}*/
}
function stokVerileri(value, i) {
	$("#stokKodText" + i).html(value.STOK_KODU ? value.STOK_KODU : "Yok");
	$("#yapilanIslemStokKod" + i).val(value.STOK_KODU ? value.STOK_KODU : "");
	$("#yapilanIslemMiktar" + i).val(1);
	$("#yapilanIslem" + i).val(value.STOK_ADI ? value.STOK_ADI : "");
	$("#yapilanIslemFiyat" + i).val(
		parseFloat(value.SATIS_FIAT1 ? value.SATIS_FIAT1 : 0).toFixed(2)
	);
	$("#yapilanIslemKdv" + i).val(value.KDV_ORANI ? value.KDV_ORANI : 0);
	stok_bilgileri_onaylandi[i - 1] = true;
	$("#stok_liste_" + i).hide();
	islemHesapla(i);
}
function _(abc) {
	return document.getElementById(abc);
}

function dosyaYukle(id, tamamlama_func) {
	var dosya = _("yuklenecekDosya").files[0];
	var formdata = new FormData();
	formdata.append("yuklenecekDosya", dosya);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", ilerlemeDurumu, false);
	ajax.addEventListener("load", function(event){tamamlamaDurumu(event,tamamlama_func);}, false);
	ajax.addEventListener("error", hataDurumu, false);
	ajax.addEventListener("abort", iptalDurumu, false);
	ajax.open("POST", base_url + "/cihaz/medyaYukle/" + id);
	ajax.send(formdata);
}

function ilerlemeDurumu(event) {
	var loaded = new Number(event.loaded / 1048576);
	var total = new Number(event.total / 1048576);
	_("yukleme_durumu").innerHTML =
		"Yüklendi: " +
		loaded.toPrecision(5) +
		" MB / " +
		total.toPrecision(5) +
		" MB";
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("durum").innerHTML = Math.round(percent) + "% yüklendi";
}

function tamamlamaDurumu(event, tamamlama_func) {
	var dt = event.target.responseText.split("}");
	var nDt = dt[0] + "}";
	console.log(dt[0]);
	var response = JSON.parse(nDt);
	_("durum").innerHTML = response.mesaj;
	_("progressBar").value = 0;
	document.getElementById("progressDiv").style.display = "none";
	if (response.sonuc == 0) {
		_("yukleme_durumu").innerHTML = "";
	}
	if (response.sonuc == 1) {
		$("#yuklenecekDosya").val("");
		tamamlama_func();
	}
}

function hataDurumu(event) {
	_("durum").innerHTML = "Yükleme Başarısız";
}

function iptalDurumu(event) {
	_("durum").innerHTML = "Yükleme İptal Edildi";
}

function medyaSil(cihaz_id, id){
    $.post(base_url+"/cihaz/medyaSil/"+cihaz_id+"/"+id+"/post", {})
    .done(function(msg){
      try{
        data = $.parseJSON( msg );
        if(data["sonuc"]==1){
			if($("#list-medyalar").length > 0){
				$("#list-medyalar #medyaGoster"+id).remove();
				if($('#list-medyalar .medyaGoster').length==0){
					$("#list-medyalar #medyaYok").show();
				}
			}
			if($("#dt-medyalar").length > 0){
				$("#dt-medyalar #medyaGoster"+id).remove();
				if($('#dt-medyalar .medyaGoster').length==0){
					$("#dt-medyalar #medyaYok").show();
				}
			}
			if($("#medyaSilModal").length > 0){
				$("#medyaSilModal").modal("hide");
			}
			console.log("Medya Silindi");
        }else{
			alert("Medya Silinemedi! Lütfen daha sonra tekrar deneyin");
			console.log("Medya Silinemedi: "+data["sonuc"]);
        }
      }catch(error){
		alert("Medya Silinemedi! Lütfen daha sonra tekrar deneyin");
		console.log("Medya Silinemedi: "+error);
      }
    })
    .fail(function(xhr, status, error) {
		alert("Medya Silinemedi! Lütfen daha sonra tekrar deneyin");
		console.log("Medya Silinemedi: "+error);
    });
}