<?php

echo '<script>
    function createDateAsUTC(date) {
        return new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes()));
    }
    function tarih_girisi(oge){
        var secilen = $(oge).find("option:selected").val();
        if (secilen == "el") {
            $("#tarih_row").show();
            $("#tarih").attr("name", "tarih");
            $("#tarih").attr("type", "datetime-local");
            $("#tarih").attr("required","required");
        } else{
            $("#tarih_row").hide();
            $("#tarih").attr("name", "tarih1");
            $("#tarih").attr("type", "hidden");
            $("#tarih").removeAttr("required");
        }
    }
        ';
$this->load->view("inc/ortak_cihaz_script.php");
echo '        
    $(document).ready(function() {
        $("#yeniCihazGirisiBtn").show();
        $("#yeniCihazForm").submit(function(e){
            $("#yeniCihazEkleBtn").prop("disabled", true);
            $("#kaydediliyorModal").modal("show");
            var formData = $("#yeniCihazForm").serialize();
            $.post("' . base_url("cihazyonetimi/cihazEkle/post") . '", formData)
            .done(function(msg){
                $("#yeniCihazEkleBtn").prop("disabled", false);
                $("#kaydediliyorModal").modal("hide");
                try{
                    data = $.parseJSON( msg );
                    if(data["sonuc"]==1){
                        $("#yeniCihazEkleModal").modal("hide");
                        $(\'#yeniCihazForm\')[0].reset();
                        $("#basarili-mesaji").html("Yeni kayıt başarıyla eklendi.");
                        $("#statusSuccessModal").modal("show");
                    }else{
                        $("#hata-mesaji").html(data["mesaj"]);
                        $("#statusErrorsModal").modal("show");
                    }
                }catch(error){
                    $("#hata-mesaji").html(error);
                    $("#statusErrorsModal").modal("show");
                }
            })
            .fail(function(xhr, status, error) {
                $("#yeniCihazEkleBtn").prop("disabled", false);
                $("#kaydediliyorModal").modal("hide");
                $("#hata-mesaji").html(error);
                $("#statusErrorsModal").modal("show");
            });
            return false;
        });
        var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash).click();
        }
        /*$(\'#yeniCihazEkleModal\').on(\'show.bs.modal\', function(e) {
            var tarih = createDateAsUTC(new Date());
            $("#tarih").val(tarih.toJSON().slice(0, 19));
        });*/
        tarih_girisi("#tarih_girisi");
        $("#yeniCihazForm #tarih_girisi").on("change", function(e) {
            tarih_girisi(this);
            $("#yeniCihazEkleBtn").prop("disabled", false);
            //console.log(this.value, clickedIndex, newValue, oldValue)
        });
        $("#yeniCihazForm #cihaz_turu").on("change", function() {
            cihazTurleriSifre($(this).val());
            $("#yeniCihazEkleBtn").prop("disabled", false);
        });
        cihazTurleriSifre("#yeniCihazForm", $("#yeniCihazForm #cihaz_turu").val());
        $("#yeniCihazForm #fatura_durumu").on("change", function() {
            faturaDurumuInputlar("#yeniCihazForm", $(this).val())
            $("#yeniCihazEkleBtn").prop("disabled", false);
        });
        //#yeniCihazForm #tarih_girisi, #yeniCihazForm #cihaz_turu, #yeniCihazForm #fatura_durumu
        $("#yeniCihazForm #sorumlu, #yeniCihazForm #cihazdaki_hasar, #yeniCihazForm #servis_turu, #yeniCihazForm #yedek_durumu").on("change", function() {
            $("#yeniCihazEkleBtn").prop("disabled", false);
        });
    });
</script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cihaz Yönetimi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Cihaz Yönetimi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cihazlar</h3>
            </div>
            <div class="card-body">
                <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">';
                    if(TEST_ACIK){
                        echo '<a class="btn btn-primary mr-3 mb-2" href="'.base_url("cihazyonetimi/musterileriAktar").'">Müşterileri Aktar</a>';
                        echo '<a class="btn btn-primary mr-3 mb-2" href="'.base_url("cihazyonetimi/yapilanIslemleriAktar").'">Yapilan İşlemleri Aktar</a>';
                    }
                    echo'<button id="yeniCihazGirisiBtn" type="button" class="btn btn-primary me-2 mb-2" style="display:none;" data-toggle="modal" data-target="#yeniCihazEkleModal">
                            Yeni Cihaz Girişi
                        </button>
                    </div>
                </div>';
$this->load->view("icerikler/cihaz_tablosu");
echo '</div>
        </div>
    </section>
</div>
<div class="modal fade" id="yeniCihazEkleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="yeniCihazEkleModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniCihazEkleModalTitle">Yeni Cihaz Girişi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="yeniCihazForm" method="post">
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>
                    <div id="giris_tarihi_div" class="row">';
$this->load->view("ogeler/tarih_girisi");
echo '</div>
                    <div id="tarih_row" class="row">';
$this->load->view("ogeler/tarih");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/musteri_adi");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/teslim_eden");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/adres");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/musteriyi_kaydet");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/gsm", array("telefon_numarasi_label"=>TRUE));
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/cihaz_turleri");
echo '</div>';

//if ($this->Kullanicilar_Model->yonetici()) {

    echo '<div class="row">';
    $this->load->view("ogeler/sorumlu_select");
    echo '</div>';
//} else {
//    $this->load->view("ogeler/sorumlu_text");
//}

echo '<div class="row">';
$this->load->view("ogeler/cihaz_markasi");
echo '</div>
<div class="row">';
$this->load->view("ogeler/cihaz_modeli");
echo '</div>
<div class="row">';
$this->load->view("ogeler/seri_no");
echo '</div>
<div class="row">';
$this->load->view("ogeler/cihaz_sifresi", array("formID" => "yeniCihazForm"));
echo '</div>
<div class="row">';
$this->load->view("ogeler/ariza_aciklamasi");
echo '</div>
<div class="row">';
$this->load->view("ogeler/teslim_alinanlar");
echo '</div>
<div class="row">
    <h5 class="col">Cihazın Hasar Bilgisi</h5>
</div>
<div class="row">';
$this->load->view("ogeler/hasar_tespiti");
echo '</div>
<div class="row">';
$this->load->view("ogeler/hasar_turu");
echo '</div>
<div class="row">';
$this->load->view("ogeler/servis_turu");
echo '</div>
<div class="row">';
$this->load->view("ogeler/yedek");
echo '</div>
</form>
</div>
<div class="modal-footer">
';
echo '<input id="yeniCihazEkleBtn" type="submit" class="btn btn-success" form="yeniCihazForm" value="Ekle" />
    <button type="button" onclick="$(\'#yeniCihazForm\')[0].reset();" class="btn btn-primary">Temizle</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">İptal</button>
</div>
</div>
</div>
</div>';
