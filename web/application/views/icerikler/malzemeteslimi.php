<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view("inc/datatables_scripts");
?>
<script>
    <?php
    $this->load->view("inc/ortak_cihaz_script.php");
    ?>
</script>
<?php
$this->load->view("inc/style_tablo");
?>
<div class="content-wrapper">
    <?php
    $this->load->view("inc/content_header", array(
        "contentHeader" => array(
            "baslik" => $baslik,
            "items" => array(
                array(
                    "link" => base_url(),
                    "text" => "Anasayfa",
                ),
                array(
                    "active" => TRUE,
                    "text" => $baslik,
                ),
            ),
        ),
    ));
    ?>
    <script>
        var malzemeTeslimTablosu = null;
        var malzemeTeslimiOgeler = [];
        var suankicihaz = 0;
        function teslimFormuYazdir(id) {
            var url = "<?= base_url("malzemeteslimi/yazdir"); ?>/" + id;
            malzemeTeslimiPencere = window.open(
                url,
                "malzemeTeslimiPencere" + id,
                'status=1,width=' + screen.availWidth + ',height=' + screen.availHeight
            );
        }
        function gunFarkiHesapla(tarihStr) {
            // Tarih stringini parçala
            const [gun, ay, yil] = tarihStr.split(".").map(Number);

            // JavaScript'te aylar 0'dan başlar (0 = Ocak)
            const hedefTarih = new Date(yil, ay - 1, gun);

            // Bugünün tarihi (sadece yıl-ay-gün bazında)
            const bugun = new Date();
            bugun.setHours(0, 0, 0, 0); // Saat bilgilerini sıfırla

            // Farkı milisaniye cinsinden al, güne çevir
            const farkMs = hedefTarih - bugun;
            const farkGun = Math.floor(farkMs / (1000 * 60 * 60 * 24));

            return farkGun; // Negatifse geçmişte, pozitifse gelecekte
        }
        function tutarHesapla(adetVal, fiyatVal, kdvVal) {

            const orjAdetVal = adetVal;
            if (adetVal.length == 0) {
                adetVal = "0";
            }
            const orjFiyatVal = fiyatVal;
            if (fiyatVal.length == 0) {
                fiyatVal = "0";
            }
            if (kdvVal.length == 0) {
                kdvVal = "0";
            }
            var adet = parseInt(adetVal);
            var fiyat = parseInt(fiyatVal);
            var topFiyat = fiyat * adet;
            var kdv = (topFiyat / 100) * parseInt(kdvVal);
            var kompleToplam = topFiyat + kdv;
            return {
                kdv: orjAdetVal.length > 0 && orjFiyatVal.length > 0 ? kdv.toFixed(2) + " TL (" + kdvVal + "%)" : "",
                tutar: orjAdetVal.length > 0 && orjFiyatVal.length > 0 ? topFiyat.toFixed(2) + " TL" : "",
                toplam: orjAdetVal.length > 0 && orjFiyatVal.length > 0 ? kompleToplam.toFixed(2) + " TL" : ""
            }
        }
        function tarihDonusturInput(tarih) {
            if (tarih == "Belirtilmemiş") {
                return "";
            }
            var gun = tarih.slice(0, 2);
            var ay = tarih.slice(3, 5);
            var yil = tarih.slice(6, 10);
            return yil + "-" + ay + "-" + gun;
        }

        function tarihDonusturRead(tarih) {
            if (tarih == "Belirtilmemiş") {
                return tarih;
            }
            var gun = tarih.slice(0, 2);
            var ay = tarih.slice(3, 5);
            var yil = tarih.slice(6, 10);
            return gun + "." + ay + "." + yil;
        }
        function duzenleGoster() {
            $("#formuYazdirBtn").hide();
            $("#duzenleMalzemeTeslimiTable").hide();
            $("#duzenleMalzemeTeslimiBtn").hide();
            $("#silMalzemeTeslimiBtn").hide();
            $("#duzenleMalzemeTeslimiForm").show();
            $("#kaydetMalzemeTeslimiBtn").show();
            $("#kaydetVeYazdirMalzemeTeslimiBtn").show();
            $("#iptalMalzemeTeslimiBtn").show();
        }
        function detayGoster() {
            $("#duzenleMalzemeTeslimiForm").hide();
            $("#kaydetMalzemeTeslimiBtn").hide();
            $("#kaydetVeYazdirMalzemeTeslimiBtn").hide();
            $("#iptalMalzemeTeslimiBtn").hide();
            $("#duzenleMalzemeTeslimiBtn").show();
            $("#silMalzemeTeslimiBtn").show();
            $("#formuYazdirBtn").show();
            $("#duzenleMalzemeTeslimiTable").show();
        }
        function detayHandle(id) {
            suankicihaz = id;
            $("#formuYazdirBtn").attr("onclick", id == 0 ? "" : "teslimFormuYazdir(" + id + ")");
            var teslim_no = id == 0 ? "" : malzemeTeslimiOgeler[id.toString()]["teslim_no"];
            $("#teslimIdBaslik").html(teslim_no);
            $("#teslim_no3").html(teslim_no);
            var firma = id == 0 ? "" : malzemeTeslimiOgeler[id.toString()]["firma"];
            $("#firma2").val(firma)
            $("#firma3").html(firma);
            var teslim_eden = id == 0 ? "" : malzemeTeslimiOgeler[id.toString()]["teslim_eden"];
            $("#teslim_eden2").val(teslim_eden);
            $("#teslim_eden3").html(teslim_eden);
            var teslim_alan = id == 0 ? "" : malzemeTeslimiOgeler[id.toString()]["teslim_alan"];
            $("#teslim_alan2").val(teslim_alan);
            $("#teslim_alan3").html(teslim_alan);

            $("#siparis_tarihi2").val(id == 0 ? "" : tarihDonusturInput(malzemeTeslimiOgeler[id.toString()]["siparis_tarihi"]));
            $("#siparis_tarihi3").html(id == 0 ? "" : tarihDonusturRead(malzemeTeslimiOgeler[id.toString()]["siparis_tarihi"]));
            $("#teslim_tarihi2").val(id == 0 ? "" : tarihDonusturInput(malzemeTeslimiOgeler[id.toString()]["teslim_tarihi"]));
            $("#teslim_tarihi3").html(id == 0 ? "" : tarihDonusturRead(malzemeTeslimiOgeler[id.toString()]["teslim_tarihi"]));
            $("#vade_tarihi2").val(id == 0 ? "" : tarihDonusturInput(malzemeTeslimiOgeler[id.toString()]["vade_tarihi"]));
            $("#vade_tarihi3").html(id == 0 ? "" : tarihDonusturRead(malzemeTeslimiOgeler[id.toString()]["vade_tarihi"]));
            $("#odeme_durumu2").val(id == 0 ? "" : malzemeTeslimiOgeler[id.toString()]["odeme_durumu"]);
            $("#odeme_durumu3").html(id == 0 ? "" : $("#odeme_durumu2 option:selected").text());

            var islemlerHtml = "";
            var count = 0;
            for (var i = 1; i <= <?= $this->Islemler_Model->maxIslemSayisi; ?>; i++) {
                var islem = id == 0 ? undefined : malzemeTeslimiOgeler[id.toString()]["islemler"].find(item => item["islem_sira"].toString() === i.toString());

                var isim = "";
                var adet = "";
                var birim_fiyati = "";
                var kdv = "";
                if (islem !== undefined) {
                    count++;
                    isim = islem["isim"];
                    adet = islem["adet"];
                    birim_fiyati = islem["birim_fiyati"];
                    kdv = islem["kdv"];
                    var tutar = tutarHesapla(adet, birim_fiyati, kdv);
                    islemlerHtml += "<tr>"
                    islemlerHtml += "<th>" + count + "</th>";
                    islemlerHtml += "<th>" + isim + "</th>";
                    islemlerHtml += "<th>" + adet + "</th>";
                    islemlerHtml += "<th>" + birim_fiyati + "</th>";
                    islemlerHtml += "<th>" + kdv + "%</th>";
                    islemlerHtml += "<th>" + tutar.tutar + "</th>";
                    islemlerHtml += "<th>" + tutar.kdv + "</th>";
                    islemlerHtml += "<th>" + tutar.toplam + "</th>";
                    islemlerHtml += "</tr>"

                }
                $("#yapilanIslem" + "2_" + i).val(isim);
                $("#yapilanIslemAdet" + "2_" + i).val(adet);
                $("#yapilanIslemFiyat" + "2_" + i).val(birim_fiyati);
                $("#yapilanIslemKdv" + "2_" + i).val(kdv);
                $("#yapilanIslemAdet" + "2_" + i).trigger("input");
            }
            if (islemlerHtml.length == 0) {
                $("#islemler3").html('<tr><td class="text-center" colspan="8">Henüz bir malzeme eklenmemiş.</td></tr>');
            } else {
                $("#islemler3").html(islemlerHtml);
            }
            $("#kaydetMalzemeTeslimiBtn").attr("onclick", id == 0 ? "" : "duzenle('" + id + "', false)");
            $("#kaydetVeYazdirMalzemeTeslimiBtn").attr("onclick", id == 0 ? "" : "duzenle('" + id + "', true)");
            $("#silMalzemeTeslimiBtn").attr("onclick", id == 0 ? "" : "silOnay('" + id + "')");

            detayGoster();
            $("#malzemeTeslimDuzenleModal").modal(id == 0 ? "hide" : "show");
        }

        function detayReset() {
            detayHandle(0);
        }
        function spaniSil(veri) {
            return veri.replace(/<\/?span[^>]*>/g, "");
        }
        function tarihiFormatla(tarih12) {
            return (tarih12 < 10) ? "0" + tarih12 : tarih12;
        }
        function formBaslangic(butonDiv) {
            $("#hata-mesaji").html("");
            $(butonDiv).prop("disabled", true);
        }
        function formBitis(butonDiv) {
            $(butonDiv).prop("disabled", false);
        }
        function malzemeTeslimleriGetir() {
            $.get('<?= base_url("malzemeteslimi/malzemeTeslimleriJQ"); ?> ', {}).done(function (data) {
                var ogeler = JSON.parse(data);
                malzemeTeslimTablosu.clear();
                $.each(JSON.parse(data), function (index, value) {
                    malzemeTeslimiOgeler[value.id.toString()] = value;
                    var tablo = '<tr class="' + (value.odendi ? "bg-success" : "bg-danger") + '">';
                    tablo += '<th scope="row">' + value.teslim_no + '</th>';
                    tablo += '<td>' + value.firma + '</td>';
                    tablo += '<td>' + value.siparis_tarihi + '</td>';
                    tablo += '<td>' + value.teslim_tarihi + '</td>';
                    tablo += '<td>' + value.vade_tarihi + '</td>';
                    tablo += '<td>';
                    var vade_yazisi = "";
                    if (value.odendi) {
                        vade_yazisi = "Ödendi";
                    } else {
                        if (value.vade_tarihi.length > 0 && value.vade_tarihi != "Belirtilmemiş") {
                            var vade_suresi = gunFarkiHesapla(value.vade_tarihi);
                            if (vade_suresi < 0) {
                                vade_yazisi = "Ödenmedi (Vadesi " + vade_suresi.toString().replaceAll("-", "") + " Gün Geçmiş)";
                            } else if (vade_suresi > 0) {
                                vade_yazisi = "Ödenmedi (Vadesine " + vade_suresi.toString().replaceAll("-", "") + " Gün Kalmış)";
                            } else {
                                vade_yazisi = "Ödenmedi (Vadesi Bugün)";
                                console.log("Vade: " + value.vade_tarihi);
                            }
                        } else {
                            vade_yazisi = "Ödenmedi";
                        }
                    }
                    tablo += vade_yazisi;
                    tablo += '</td>';
                    tablo += '<td class="text-center"><button class="btn btn-info text-white" onclick="detayHandle(\'' + value.id + '\')">Detaylar</button>';
                    tablo += '</td>';
                    tablo += '</tr>';
                    malzemeTeslimTablosu.row.add($(tablo));
                });
                malzemeTeslimTablosu.draw();
                malzemeTeslimTablosu.columns.adjust();
                if (suankicihaz != 0) {
                    console.log("Cihaz: " + suankicihaz);
                    detayHandle(suankicihaz);
                }
            });
        }
        function yeniEkle(yazdir) {
            var formData = $("#yeniMalzemeTeslimiForm").serialize();
            formBaslangic("#yeniMalzemeTeslimiEkleBtn");
            $.post('<?= base_url("malzemeteslimi/malzemeTeslimiEkleJQ"); ?>', formData).done(function (data) {
                console.log(data);
                var resp = JSON.parse(data);
                if (resp["sonuc"]) {
                    $("#statusSuccessModal").modal("show");
                    $('#yeniMalzemeTeslimiForm')[0].reset();
                    $("#yeniMalzemeTeslimiEkleModal").modal("hide");
                    malzemeTeslimleriGetir();
                    if(yazdir){
                        teslimFormuYazdir(resp["id"]);
                    }
                } else {
                    $("#hata-mesaji").html(resp["mesaj"]);
                    $("#statusErrorsModal").modal("show");
                }
                formBitis("#yeniMalzemeTeslimiEkleBtn");
            }).fail(function (xhr, status, error) {
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
                formBitis("#yeniMalzemeTeslimiEkleBtn");
            });
        }
        function duzenle(id, yazdir) {
            var formData = $("#duzenleMalzemeTeslimiForm").serialize();
            formBaslangic("#kaydetMalzemeTeslimiBtn");
            formBaslangic("#kaydetVeYazdirMalzemeTeslimiBtn");
            $.post('<?= base_url("malzemeteslimi/malzemeTeslimiDuzenleJQ"); ?>/' + id, formData).done(function (data) {
                var resp = JSON.parse(data);
                if (resp["sonuc"]) {
                    $("#statusSuccessModal").modal("show");
                    malzemeTeslimleriGetir();
                    if(yazdir){
                        teslimFormuYazdir(id);
                    }
                } else {
                    $("#hata-mesaji").html(resp["mesaj"]);
                    $("#statusErrorsModal").modal("show");
                }
                formBitis("#kaydetMalzemeTeslimiBtn");
                formBitis("#kaydetVeYazdirMalzemeTeslimiBtn");
            }).fail(function (xhr, status, error) {
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
                formBitis("#kaydetMalzemeTeslimiBtn");
                formBitis("#kaydetVeYazdirMalzemeTeslimiBtn");
            });
        }

        function silOnay(id) {
            $("#silOnayBtn").attr("onclick", "sil('" + id + "')");
            $("#islemiSilModal").modal("show");
        }
        function sil(id) {
            $.post('<?= base_url("malzemeteslimi/malzemeTeslimiSilJQ"); ?>/' + id, {}).done(function (data) {
                var resp = JSON.parse(data);
                if (resp["sonuc"]) {
                    $("#statusSuccessModal").modal("show");
                    $("#islemiSilModal").modal("hide")
                    malzemeTeslimleriGetir();;
                    detayReset();
                } else {
                    $("#hata-mesaji").html(resp["mesaj"]);
                    $("#statusErrorsModal").modal("show");
                }
                formBitis("#kaydetMalzemeTeslimiBtn");
                formBitis("#kaydetVeYazdirMalzemeTeslimiBtn");
            }).fail(function (xhr, status, error) {
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
                formBitis("#kaydetMalzemeTeslimiBtn");
                formBitis("#kaydetVeYazdirMalzemeTeslimiBtn");
            });
        }
        $(document).ready(function () {
            $(document).on("show.bs.modal", ".modal", function () {
                ayrilmaEngeliIptal();
                const zIndex = 1040 + 10 * $(".modal:visible").length;
                $(this).css("z-index", zIndex);
                setTimeout(() => $(".modal-backdrop").not(".modal-stack").css("z-index", zIndex - 1).addClass("modal-stack"));
            });
            var tabloDiv = "#malzemeTeslimTablosu";
            malzemeTeslimTablosu = $(tabloDiv).DataTable(<?= $this->Islemler_Model->datatablesAyarlari(
                "[[ 5, \"desc\" ]]",
                "true",
                '"aoColumns": [
            null,
            null,
            { "sType": "date-tr" },
            { "sType": "date-tr" },
            { "sType": "date-tr" },
            { "sType": "status-tr" },
            null,
    ],'
            ); ?>);
            $.extend($.fn.dataTable.ext.type.order, {
                "date-tr-pre": function (name) {
                    name = spaniSil(name);
                    var gun = parseInt(name.slice(0, 2));
                    gun = tarihiFormatla(gun);
                    var ay = parseInt(name.slice(3, 5));
                    ay = tarihiFormatla(ay);
                    var yil = parseInt(name.slice(6, 10));
                    return parseInt(yil + "" + ay + "" + gun);
                },
                "date-tr-asc": function (a, b) {
                    return a - b;
                },
                "date-tr-desc": function (a, b) {
                    return b - a;
                },
                "status-tr-pre": function (name) {
                    name = spaniSil(name);
                    const TRILYON = 1_000_000_000_000;

                    if (name === "Ödendi") {
                        return 0;
                    }

                    // Ödenmedi (Vadesine X Gün Kalmış)
                    const kaldiRegex = /Ödenmedi \(Vadesine (\d+) Gün Kalmış\)/;
                    const kaldiMatch = name.match(kaldiRegex);
                    if (kaldiMatch) {
                        const gun = parseInt(kaldiMatch[1], 10);
                        return TRILYON - gun; // Gün arttıkça yukarı çıkar
                    }

                    // Ödenmedi (Vadesi X Gün Geçmiş)
                    const gecmisRegex = /Ödenmedi \(Vadesi (\d+) Gün Geçmiş\)/;
                    const gecmisMatch = name.match(gecmisRegex);
                    if (gecmisMatch) {
                        const gun = parseInt(gecmisMatch[1], 10);
                        return TRILYON * 2 + gun;
                    }

                    // Ödenmedi (Vadesi Bugün)
                    if (name === "Ödenmedi (Vadesi Bugün)") {
                        return TRILYON * 3;
                    }

                    if (name === "Ödenmedi") {
                        return TRILYON * 9;
                    }

                    return TRILYON * 10; // Diğer durumlar en alta
                },
                "status-tr-asc": function (a, b) {
                    return a - b;
                },
                "status-tr-desc": function (a, b) {
                    return b - a;
                },
            });
            malzemeTeslimleriGetir();
        });
    </script>
    <section class="content">
        <div class="card">
            <div class="card-body px-0 mx-0">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button id="yeniMalzemeTeslimiGirisiBtn" type="button" class="btn btn-primary me-2 mb-2"
                            data-bs-toggle="modal" data-bs-target="#yeniMalzemeTeslimiEkleModal">
                            Yeni Malzeme Teslimi Kaydı
                        </button>
                    </div>
                </div>
                <table id="malzemeTeslimTablosu" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No:</th>
                            <th scope="col">Firma</th>
                            <th scope="col">Sipariş Tarihi</th>
                            <th scope="col">Teslim Tarihi</th>
                            <th scope="col">Vade Tarihi</th>
                            <th scope="col">Ödeme Durumu</th>
                            <th scope="col">Detaylar</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="yeniMalzemeTeslimiEkleModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="yeniMalzemeTeslimiEkleModalTitle" style="z-index: 1040; display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniMalzemeTeslimiEkleModalTitle">Yeni Malzeme Teslimi Kaydı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $this->load->view("icerikler/malzeme_teslimi_form_div", array(
                    "form_ad" => "yeni",
                    "form_id" => "1",
                )); ?>
            </div>
            <div class="modal-footer">
                <button type="submit" id="yeniMalzemeTeslimiEkleBtn" class="btn btn-success"
                    onclick="yeniEkle(false)">Ekle</button>
                    <button type="submit" id="yeniVeYazdirMalzemeTeslimiEkleBtn" class="btn btn-info text-white"
                    onclick="yeniEkle(true)">Ekle ve Yazdır</button>
                <button type="button" onclick="$('#yeniMalzemeTeslimiForm')[0].reset();"
                    class="btn btn-primary">Temizle</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="malzemeTeslimDuzenleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="malzemeTeslimDuzenleModalLabel" style="z-index: 1040; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="malzemeTeslimDuzenleModalLabel">Malzeme Teslim Detaylari Duzenle <span
                        id="teslimIdBaslik"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="duzenleMalzemeTeslimiTable">
                    <table class="table table-bordered">
                        <thead style="border: none !important;">
                            <tr style="border: none !important;">
                                <?php
                                for ($i = 1; $i <= 20; $i++) {
                                    ?>
                                    <th style="border: none !important;"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <th colspan="4">No:</th>
                                <td id="teslim_no3" colspan="16"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Firma:</th>
                                <td id="firma3" colspan="16"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Teslim Eden:</th>
                                <td id="teslim_eden3" colspan="16"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Teslim Alan:</th>
                                <td id="teslim_alan3" colspan="16"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Sipariş Tarihi:</th>
                                <td id="siparis_tarihi3" colspan="16"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Teslim Tarihi:</th>
                                <td id="teslim_tarihi3" colspan="16"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Vade Tarihi:</th>
                                <td id="vade_tarihi3" colspan="16"></td>
                            </tr>
                            <tr>
                                <th colspan="4">Ödeme Durumu:</th>
                                <td id="odeme_durumu3" colspan="16"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sira</th>
                                <th>Malzeme</th>
                                <th>Adet</th>
                                <th>Birim Fiyatı</th>
                                <th>KDV Oranı</th>
                                <th>Tutar</th>
                                <th>KDV</th>
                                <th>Toplam</th>
                            </tr>
                        </thead>
                        <tbody id="islemler3">
                        </tbody>
                    </table>
                </div>
                <?php $this->load->view("icerikler/malzeme_teslimi_form_div", array(
                    "form_ad" => "duzenle",
                    "form_id" => "2",
                )); ?>
            </div>
            <div class="modal-footer">
                <button type="submit" id="kaydetMalzemeTeslimiBtn" class="btn btn-success">Kaydet</button>
                <button type="submit" id="kaydetVeYazdirMalzemeTeslimiBtn" class="btn btn-info text-white">Kaydet ve Yazdır</button>
                <button type="submit" id="iptalMalzemeTeslimiBtn" class="btn btn-danger"
                    onclick="detayGoster()">İptal</button>
                <button type="submit" id="duzenleMalzemeTeslimiBtn" class="btn btn-success"
                    onclick="duzenleGoster()">Düzenle</button>
                <button type="submit" id="silMalzemeTeslimiBtn" class="btn btn-danger">Sil</button>
                <a id="formuYazdirBtn" href="#" class="btn btn-dark text-light" style="">Formu Yazdır</a>
                <a id="kapatBtn" href="#" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="islemiSilModal" tabindex="-1" aria-labelledby="islemiSilModalLabel"
    style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="islemiSilModalLabel">İşlem Silmeyi Onaylayın</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> Bu işlemi silmek istediğinize emin misiniz?</div>
            <div class="modal-footer">
                <button id="silOnayBtn" class="btn btn-success" onclick="">Evet</button>
                <button class="btn btn-danger" data-bs-dismiss="modal">Hayır</button>
            </div>
        </div>
    </div>
</div>