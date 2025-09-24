<?php
function getDuzenle($str, $varsayilan = ""){
    return (isset($_GET[$str]) ? htmlspecialchars($_GET[$str], ENT_QUOTES) : $varsayilan);
}
echo '<script>
    var yeniCihazGirisiAcik = false;
    $(document).ready(function(){
        $("#yeniCihazEkleModal").on("show.bs.modal", function(e) {
            yeniCihazGirisiAcik = true;
        });
        $("#yeniCihazEkleModal").on("hidden.bs.modal", function(e) {
            yeniCihazGirisiAcik = false;
        });
        ';
        if(isset($_GET['yeniCihaz']) && $_GET['yeniCihaz']==1) {
            echo '$("#yeniCihazEkleModal").modal("show");';
        }
        echo '
    });
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
    function cihazEkle(yazdir){
        var ceForm = document.getElementById("yeniCihazForm");
        if (!ceForm.checkValidity()) {
            ceForm.reportValidity();
            return;
        }
        $("#yeniCihazEkleBtn").prop("disabled", true);
        $("#yeniCihazEkleBarkodBtn").prop("disabled", true);
        $("#kaydediliyorModal").modal("show");
        var formData = $("#yeniCihazForm").serialize();
        $.post("' . base_url("cihazyonetimi/cihazEkle/post") . '", formData)
        .done(function(msg){
            $("#yeniCihazEkleBtn").prop("disabled", false);
            $("#yeniCihazEkleBarkodBtn").prop("disabled", false);
            $("#kaydediliyorModal").modal("hide");
            try{
                data = $.parseJSON( msg );
                if(data["sonuc"]==1){
                    $("#yeniCihazEkleModal").modal("hide");
                    $(\'#yeniCihazForm\')[0].reset();
                    $("#basarili-mesaji").html("Yeni kayıt başarıyla eklendi.");
                    $("#statusSuccessModal").modal("show");
                    ';
                    if(isset($_GET['yeniCihaz']) && $_GET['yeniCihaz']==1) {
                        echo '
                        const newUrl = window.location.origin + window.location.pathname;
                        window.history.replaceState({}, document.title, newUrl);';
                    }
                    echo '
                    if(yazdir){
                        barkoduYazdir(data["id"]);
                    }
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
            $("#yeniCihazEkleBarkodBtn").prop("disabled", false);
            $("#kaydediliyorModal").modal("hide");
            $("#hata-mesaji").html(error);
            $("#statusErrorsModal").modal("show");
        });
    }
    $(document).ready(function() {
        $("#yeniCihazGirisiBtn").show();
        var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash).click();
        }
        tarih_girisi("#tarih_girisi");
        $("#yeniCihazForm #tarih_girisi").on("change", function(e) {
            tarih_girisi(this);
            $("#yeniCihazEkleBtn").prop("disabled", false);
            $("#yeniCihazEkleBarkodBtn").prop("disabled", false);
            //console.log(this.value, clickedIndex, newValue, oldValue)
        });
        $("#yeniCihazForm #cihaz_turu").on("change", function() {
            cihazTurleriSifre($(this).val());
            $("#yeniCihazEkleBtn").prop("disabled", false);
            $("#yeniCihazEkleBarkodBtn").prop("disabled", false);
        });
        cihazTurleriSifre("#yeniCihazForm", $("#yeniCihazForm #cihaz_turu").val());
        $("#yeniCihazForm #fatura_durumu").on("change", function() {
            faturaDurumuInputlar("#yeniCihazForm", $(this).val())
            $("#yeniCihazEkleBtn").prop("disabled", false);
            $("#yeniCihazEkleBarkodBtn").prop("disabled", false);
        });
        //#yeniCihazForm #tarih_girisi, #yeniCihazForm #cihaz_turu, #yeniCihazForm #fatura_durumu
        $("#yeniCihazForm #sorumlu, #yeniCihazForm #cihazdaki_hasar, #yeniCihazForm #servis_turu, #yeniCihazForm #yedek_durumu").on("change", function() {
            $("#yeniCihazEkleBtn").prop("disabled", false);
            $("#yeniCihazEkleBarkodBtn").prop("disabled", false);
        });
    });
</script>
<div class="content-wrapper">';
$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> "Cihaz Yönetimi",
        "items"=> array(
            array(
                "link"=> base_url(),
                "text"=> "Anasayfa",
            ),
            array(
                "active"=> TRUE,
                "text"=> "Cihaz Yönetimi",
            ),
        ),
    ),
));
echo '<section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cihazlar</h3>
            </div>
            <div class="card-body px-0 mx-0">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">';
                        if(TEST_ACIK){
                            echo '<a class="btn btn-primary mr-3 mb-2" href="'.base_url("cihazyonetimi/musterileriAktar").'">Müşterileri Aktar</a>';
                            echo '<a class="btn btn-primary mr-3 mb-2" href="'.base_url("cihazyonetimi/yapilanIslemleriAktar").'">Yapilan İşlemleri Aktar</a>';
                        }
                        echo'<button id="yeniCihazGirisiBtn" type="button" class="btn btn-primary me-2 mb-2" style="display:none;" data-bs-toggle="modal" data-bs-target="#yeniCihazEkleModal">
                            Yeni Cihaz Girişi
                        </button>
                    </div>
                </div>';
$this->load->view("icerikler/cihaz_tablosu");
echo '</div>
        </div>
    </section>
</div>
<div class="modal fade" id="yeniCihazEkleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="yeniCihazEkleModalTitle" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yeniCihazEkleModalTitle">Yeni Cihaz Girişi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="yeniCihazForm" method="post">
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>
                    <input type="hidden" name="cagri_id" id="cagri_id" value="'.getDuzenle("cagri_id", 0).'">
                    <input type="hidden" name="kull_id" id="kull_id" value="'.getDuzenle("musteri_id", 0).'">
                    <div id="giris_tarihi_div" class="row">';
$this->load->view("ogeler/tarih_girisi");
echo '</div>
                    <div id="tarih_row" class="row">';
$this->load->view("ogeler/tarih");
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/musteri_adi", array(
    "musteri_adi_form" => "#yeniCihazForm", 
    "musteri_adi_sayi" => "1",
    "musteri_adi_value" => getDuzenle("musteri_adi", ""),
));
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
$this->load->view("ogeler/cihaz_turleri", array(
    "cihaz_turu_value" => getDuzenle("cihazTuru", "")
));
echo '</div>';

//if ($this->Kullanicilar_Model->yonetici()) {

    echo '<div class="row">';
    $this->load->view("ogeler/sorumlu_select");
    echo '</div>';
//} else {
//    $this->load->view("ogeler/sorumlu_text");
//}

echo '<div class="row">';
$this->load->view("ogeler/cihaz_markasi", array(
    "cihaz_value" => getDuzenle("cihaz", "")
));
echo '</div>
<div class="row">';
$this->load->view("ogeler/cihaz_modeli",
    array(
        "cihaz_modeli_value" => getDuzenle("model", "")
    )
);
echo '</div>
<div class="row">';
$this->load->view("ogeler/seri_no",
    array(
        "seri_no_value" => getDuzenle("seri_no", "")
    )
);
echo '</div>
<div class="row">';
$this->load->view("ogeler/cihaz_sifresi", array("formID" => "yeniCihazForm"));
echo '</div>
<div class="row">';
$this->load->view("ogeler/ariza_aciklamasi",
    array(
        "ariza_aciklamasi_value" => getDuzenle("ariza", "")
    )
);
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
echo '<button id="yeniCihazEkleBtn" class="btn btn-success" onclick="cihazEkle(false)">Ekle</button>
    <button id="yeniCihazEkleBarkodBtn" class="btn btn-primary" onclick="cihazEkle(true)">Ekle ve Barkodu Yazdır</button>
    <button type="button" onclick="$(\'#yeniCihazForm\')[0].reset();" class="btn btn-primary">Temizle</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
</div>
</div>
</div>
</div>';
