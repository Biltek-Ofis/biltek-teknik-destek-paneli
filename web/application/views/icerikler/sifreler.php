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
        function donusturOnclick(oge) {
            if (oge) {
                return oge.replaceAll(/(?:\r\n|\r|\n)/g, "<br>").replaceAll("'", "\\'");
            } else {
                return "";
            }
        }
        var sifrelerTablosu = null;
        var sifreler = [];
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
        function silOnay(id) {
            $("#silOnayBtn").attr("onclick", "sifreSil('" + id + "')");
            $("#sifreSilModal").modal("show");
        }
        function yeniEkle() {
            var formData = $("#yeniSifreForm").serialize();
            formBaslangic("#yeniSifreEkleBtn");
            formBaslangic("#yeniSifreIptalBtn");
            formBaslangic("#yeniSifreKapatBtn");
            $.post('<?= base_url("sifreler/ekle"); ?>', formData).done(function (data) {
                var resp = JSON.parse(data);
                if (resp.sonuc == 1) {
                    $("#statusSuccessModal").modal("show");
                    $('#yeniSifreForm')[0].reset();
                    $("#yeniSifreEkleModal").modal("hide");
                    sifreleriGetir();
                } else {
                    $("#hata-mesaji").html(resp["mesaj"]);
                    $("#statusErrorsModal").modal("show");
                }
                formBitis("#yeniSifreEkleBtn");
                formBitis("#yeniSifreIptalBtn");
                formBitis("#yeniSifreKapatBtn");
            }).fail(function (xhr, status, error) {
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
                formBitis("#yeniSifreEkleBtn");
                formBitis("#yeniSifreIptalBtn");
                formBitis("#yeniSifreKapatBtn");
            });
        }
        function duzenleGoster(id) {
            $("#sifre_musteri2").val(sifreler[id].musteri_adi);
            $("#sifre_aciklama2").val(sifreler[id].aciklama);
            $("#sifre_k_adi2").val(sifreler[id].k_adi);
            $("#sifre2").val(sifreler[id].sifre);
            $("#kaydetSifreBtn").attr("onclick", "duzenle(" + id + ")");
            $("#sifreDuzenleModal").modal("show");
        }
        function duzenle(id) {
            var formData = $("#duzenleSifreForm").serialize();
            formBaslangic("#kaydetSifreBtn");
            formBaslangic("#duzenleIptalBtn");
            formBaslangic("#duzenleSifreKapatBtn");
            $.post('<?= base_url("sifreler/duzenle"); ?>/' + id, formData).done(function (data) {
                var resp = JSON.parse(data);
                $("#sifreDuzenleModal").modal("hide");
                if (resp["sonuc"]) {
                    $("#statusSuccessModal").modal("show");
                    sifreleriGetir();
                } else {
                    $("#hata-mesaji").html(resp["mesaj"]);
                    $("#statusErrorsModal").modal("show");
                }
                formBitis("#kaydetSifreBtn");
                formBitis("#duzenleIptalBtn");
                formBitis("#duzenleSifreKapatBtn");
            }).fail(function (xhr, status, error) {
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
                formBitis("#kaydetSifreBtn");
                formBitis("#duzenleIptalBtn");
                formBitis("#duzenleSifreKapatBtn");
            });
        }
        function sifreSil(id) {
            $.get('<?= base_url("sifreler/sil"); ?>/' + id, {}).done(function (data) {
                var ogeler = JSON.parse(data);
                if (ogeler.sonuc == 1) {
                    $("#sifreSilModal").modal("hide");
                    sifreleriGetir();
                } else {
                    alert("Sifre silinemedi");
                }
            });
        }
        function sifreGoster(id) {
            var inputType = $("#" + id).attr("type");
            if (inputType == "password") {
                $("#" + id).attr("type", "text");
            } else {
                $("#" + id).attr("type", "password");
            }
        }
        function sifreleriGetir() {
            $.get('<?= base_url("sifreler/getir"); ?> ', {}).done(function (data) {
                var ogeler = JSON.parse(data);
                if (ogeler.sonuc == 1) {
                    sifrelerTablosu.clear();
                    sifreler = [];
                    $.each(ogeler.data, function (index, value) {
                        sifreler[value.id.toString()] = value;
                        var tablo = '<tr>';
                        tablo += '<td>' + value.musteri_adi + '</td>';
                        tablo += '<td>' + value.aciklama + '</td>';
                        tablo += '<td>' + value.k_adi + '<button class="btn btn-sm btn-success ms-2" onclick="kopyala(\'' + donusturOnclick(value.k_adi) + '\')"><i class="fa-solid fa-copy"></i></button></td>';
                        tablo += '<td><input id="sifreInput' + value.id + '" class="musteriSifresi" type="password" value="' + value.sifre + '" readonly><button class="btn btn-sm btn-success ms-2" onclick="kopyala(\'' + donusturOnclick(value.sifre) + '\')"><i class="fa-solid fa-copy"></i></button><button class="btn btn-sm btn-primary ms-2" onclick="sifreGoster(\'sifreInput' + value.id + '\')">Göster</button></td>';
                        tablo += '<td>' + value.olusturan + '</td>';
                        tablo += '<td>' + (value.son_duzenleme == value.tarih ? "-" : value.duzenleyen) + '</td>';
                        tablo += '<td class="text-center">';
                        tablo += '<button class="btn btn-info text-white" onclick="duzenleGoster(' + value.id + ')">Düzenle</button>';
                        tablo += '<button class="btn btn-danger" onclick="silOnay(\'' + value.id + '\')">Sil</button>';
                        tablo += '</td>';
                        tablo += '</tr>';
                        sifrelerTablosu.row.add($(tablo));
                    });
                    sifrelerTablosu.draw();
                    sifrelerTablosu.columns.adjust();
                    ayrilmaEngeliIptal();
                } else {
                    alert("Şifreler Görüntülenemiyor.");
                }
            });
        }

        $(document).ready(function () {
            setTimeout(function () {
                $("#sifre1, #sifre2").attr("type", "password");
            }, 1000);
            $(document).on("show.bs.modal", ".modal", function () {
                ayrilmaEngeliIptal();
                const zIndex = 1040 + 10 * $(".modal:visible").length;
                $(this).css("z-index", zIndex);
                setTimeout(() => $(".modal-backdrop").not(".modal-stack").css("z-index", zIndex - 1).addClass("modal-stack"));
            });
            $(document).on("hide.bs.modal", "#sifreDuzenleModal", function () {
                $("#sifre_musteri2").val("");
                $("#sifre_aciklama2").val("");
                $("#sifre_k_adi2").val("");
                $("sifre2").val("");
                $("kaydetSifreBtn").attr("onclick", "");
            });
            var tabloDiv = "#sifrelerTablosu";
            sifrelerTablosu = $(tabloDiv).DataTable(<?= $this->Islemler_Model->datatablesAyarlari(
                "[[ 4, \"desc\" ]]",
                "true",
                '"aoColumns": [
            null,
            null,
            { "sType": "date-tr" },
            null,
            { "sType": "date-tr" },
            null,
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
            });
            sifreleriGetir();
        });
    </script>
    <section class="content">
        <div class="card">
            <div class="card-body px-0 mx-0">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button id="yeniSifreGirisiBtn" type="button" class="btn btn-primary me-2 mb-2"
                            data-bs-toggle="modal" data-bs-target="#yeniSifreEkleModal">
                            Yeni Şifre Ekle
                        </button>
                    </div>
                </div>
                <table id="sifrelerTablosu" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Müşteri İsmi</th>
                            <th scope="col">Açıklama</th>
                            <th scope="col">Kullanıcı Adı</th>
                            <th scope="col">Şifre</th>
                            <th scope="col">Oluşturan</th>
                            <th scope="col">Düzenleyen</th>
                            <th scope="col">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="yeniSifreEkleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="yeniSifreEkleModalTitle" style="z-index: 1040; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniSifreEkleModalTitle">Yeni Şifre Ekle</h5>
                <button id="yeniSifreKapatBtn" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $this->load->view("icerikler/sifre_form_div", array(
                    "form_ad" => "yeni",
                    "form_id" => "1",
                    "sifre_musteri_value" => "",
                    "sifre_aciklama_value" => "",
                    "k_adi_value" => "",
                    "sifre_value" => "",
                )); ?>
            </div>
            <div class="modal-footer">
                <button type="submit" id="yeniSifreEkleBtn" class="btn btn-success" onclick="yeniEkle()">Ekle</button>
                <button type="button" id="yeniSifreIptalBtn" class="btn btn-danger"
                    data-bs-dismiss="modal">İptal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sifreDuzenleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="sifreDuzenleModalTitle" style="z-index: 1040; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sifreDuzenleModalLabel">Şifre Düzenle</h5>
                <button id="duzenleSifreKapatBtn" type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php $this->load->view("icerikler/sifre_form_div", array(
                    "form_ad" => "duzenle",
                    "form_id" => "2",
                    "sifre_musteri_value" => "",
                    "sifre_aciklama_value" => "",
                    "k_adi_value" => "",
                    "sifre_value" => "",
                )); ?>
            </div>
            <div class="modal-footer">
                <button type="submit" id="kaydetSifreBtn" class="btn btn-success" onclick="">Kaydet</button>
                <button id="duzenleIptalBtn" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sifreSilModal" tabindex="-1" aria-labelledby="sifreSilModalLabel"
    style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="sifreSilModalLabel">Şifre Silmeyi Onaylayın</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> Bu sifreyi silmek istediğinize emin misiniz?</div>
            <div class="modal-footer">
                <button id="silOnayBtn" class="btn btn-success" onclick="">Evet</button>
                <button class="btn btn-danger" data-bs-dismiss="modal">Hayır</button>
            </div>
        </div>
    </div>
</div>