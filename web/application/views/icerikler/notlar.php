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
        var notlarTablosu = null;
        var notlar = [];
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
            $("#silOnayBtn").attr("onclick", "notSil('" + id + "')");
            $("#notSilModal").modal("show");
        }
        function yeniEkle() {
            var formData = $("#yeniNotForm").serialize();
            formBaslangic("#yeniNotGirisiBtn");
            $.post('<?= base_url("notlar/ekle"); ?>', formData).done(function (data) {
                var resp = JSON.parse(data);
                if (resp.sonuc == 1) {
                    $("#statusSuccessModal").modal("show");
                    $('#yeniNotForm')[0].reset();
                    $("#yeniNotEkleModal").modal("hide");
                    notlariGetir();
                } else {
                    $("#hata-mesaji").html(resp["mesaj"]);
                    $("#statusErrorsModal").modal("show");
                }
                formBitis("#yeniNotGirisiBtn");
            }).fail(function (xhr, status, error) {
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
                formBitis("#yeniNotGirisiBtn");
            });
        }
        function duzenleGoster(id) {
            $("#not2").val(notlar[id].aciklama);
            $("#kaydetNotBtn").attr("onclick", "duzenle(" + id + ")");
            $("#notDuzenleModal").modal("show");
        }
        function duzenle(id) {
            var formData = $("#duzenleNotForm").serialize();
            formBaslangic("#kaydetNotBtn");
            $.post('<?= base_url("notlar/duzenle"); ?>/' + id, formData).done(function (data) {
                var resp = JSON.parse(data);
                $("#notDuzenleModal").modal("hide");
                if (resp["sonuc"]) {
                    $("#statusSuccessModal").modal("show");
                    notlariGetir();
                } else {
                    $("#hata-mesaji").html(resp["mesaj"]);
                    $("#statusErrorsModal").modal("show");
                }
                formBitis("#kaydetNotBtn");
            }).fail(function (xhr, status, error) {
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
                formBitis("#kaydetNotBtn");
            });
        }
        function notSil(id) {
            $.get('<?= base_url("notlar/sil"); ?>/' + id, {}).done(function (data) {
                var ogeler = JSON.parse(data);
                if (ogeler.sonuc == 1) {
                    $("#notSilModal").modal("hide");
                    notlariGetir();
                } else {
                    alert("Not silinemedi");
                }
            });
        }
        function notlariGetir() {
            $.get('<?= base_url("notlar/getir"); ?> ', {}).done(function (data) {
                var ogeler = JSON.parse(data);
                if (ogeler.sonuc == 1) {
                    notlarTablosu.clear();
                    notlar = [];
                    $.each(ogeler.data, function (index, value) {
                        notlar[value.id.toString()] = value;
                        var tablo = '<tr>';
                        tablo += '<th scope="row">' + value.id + '</th>';
                        tablo += '<td>' + value.aciklama + '</td>';
                        tablo += '<td>' + value.tarih + '</td>';
                        tablo += '<td>' + value.olusturan + '</td>';
                        tablo += '<td>' + (value.son_duzenleme == value.tarih ? "-" : value.son_duzenleme) + '</td>';
                        tablo += '<td>' + (value.son_duzenleme == value.tarih ? "-" : value.duzenleyen) + '</td>';
                        tablo += '<td class="text-center">';
                        tablo += '<button class="btn btn-info text-white" onclick="duzenleGoster(' + value.id + ')">Düzenle</button>';
                        tablo += '<button class="btn btn-danger" onclick="silOnay(\'' + value.id + '\')">Sil</button>';
                        tablo += '</td>';
                        tablo += '</tr>';
                        notlarTablosu.row.add($(tablo));
                    });
                    notlarTablosu.draw();
                    notlarTablosu.columns.adjust();
                } else {
                    alert("Notlar Görüntülenemiyor.");
                }
            });
        }

        $(document).ready(function () {
            $(document).on("show.bs.modal", ".modal", function () {
                ayrilmaEngeliIptal();
                const zIndex = 1040 + 10 * $(".modal:visible").length;
                $(this).css("z-index", zIndex);
                setTimeout(() => $(".modal-backdrop").not(".modal-stack").css("z-index", zIndex - 1).addClass("modal-stack"));
            });
            $(document).on("hide.bs.modal", "#notDuzenleModal", function () {
                $("not2").val("");
                $("kaydetNotBtn").attr("onclick", "");
            });
            var tabloDiv = "#notlarTablosu";
            notlarTablosu = $(tabloDiv).DataTable(<?= $this->Islemler_Model->datatablesAyarlari(
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
            notlariGetir();
        });
    </script>
    <section class="content">
        <div class="card">
            <div class="card-body px-0 mx-0">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button id="yeniNotGirisiBtn" type="button" class="btn btn-primary me-2 mb-2"
                            data-bs-toggle="modal" data-bs-target="#yeniNotEkleModal">
                            Yeni Not Ekle
                        </button>
                    </div>
                </div>
                <table id="notlarTablosu" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Not</th>
                            <th scope="col">Oluşturulma Tarihi</th>
                            <th scope="col">Oluşturan</th>
                            <th scope="col">Son Düzenleme</th>
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

<div class="modal fade" id="yeniNotEkleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="yeniNotEkleModalTitle" style="z-index: 1040; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniNotEkleModalTitle">Yeni Not Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $this->load->view("icerikler/not_form_div", array(
                    "form_ad" => "yeni",
                    "form_id" => "1",
                    "not_value" => "",
                )); ?>
            </div>
            <div class="modal-footer">
                <button type="submit" id="yeniNotEkleBtn" class="btn btn-success" onclick="yeniEkle()">Ekle</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="notDuzenleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="notDuzenleModalTitle" style="z-index: 1040; display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notDuzenleModalLabel">Not Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php $this->load->view("icerikler/not_form_div", array(
                    "form_ad" => "duzenle",
                    "form_id" => "2",
                    "not_value" => "",
                )); ?>
            </div>
            <div class="modal-footer">
                <button type="submit" id="kaydetNotBtn" class="btn btn-success" onclick="">Kaydet</button>
                <a id="kapatBtn" href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="notSilModal" tabindex="-1" aria-labelledby="notSilModalLabel"
    style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="notSilModalLabel">Not Silmeyi Onaylayın</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> Bu notu silmek istediğinize emin misiniz?</div>
            <div class="modal-footer">
                <button id="silOnayBtn" class="btn btn-success" onclick="">Evet</button>
                <button class="btn btn-danger" data-bs-dismiss="modal">Hayır</button>
            </div>
        </div>
    </div>
</div>