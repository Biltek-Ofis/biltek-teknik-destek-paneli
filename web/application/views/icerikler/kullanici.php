<?php
$kullanici = $this->Kullanicilar_Model->kullaniciBilgileri();
echo '<script>
$(document).ready(function(){
    ayrilma_durumu_tetikle = false;
    $("input").each(function(){
        $(this).on("change keyup", function(){
            ayrilmaEngeliIptal();
        });
    });
});
</script>';
echo '<div class="content-wrapper">';
$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik" => $kullanici["ad_soyad"],
        "items" => array(
            array(
                "link" => base_url(),
                "text" => "Anasayfa",
            ),
            array(
                "active" => TRUE,
                "text" => $kullanici["ad_soyad"],
            ),
        ),
    ),
));
echo '<section class="content">
        <div class="card">
            <div class="card-body">
                <form autocomplete="off" method="post" action="' . (DEMO ? "" : base_url("kullanici/guncelle")) . '">
                    <div class="row">';
$this->load->view("ogeler/kullanici_ad", array("value" => $kullanici["ad_soyad"]));
echo '</div>
                    <div class="row">
                        <input type="hidden" name="kullanici_adi_orj" value="' . $kullanici["kullanici_adi"] . '">';
$this->load->view("ogeler/kullanici_adi", array("value" => $kullanici["kullanici_adi"]));
echo '</div>
                    <input type="hidden" name="sifre" value="">
                    <div class="row">';
$this->load->view("ogeler/kullanici_sifre", array(
    "value" => "",
    "label" => "Eski Şifre",
    "name" => "eski_sifre",
));
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/kullanici_sifre", array(
    "value" => "",
    "label" => "Yeni Şifre",
    "name" => "yeni_sifre",
    "required" => FALSE,
));
echo '</div>
                    <div class="row">';
$this->load->view("ogeler/kullanici_sifre", array(
    "value" => "",
    "label" => "Yeni Şifre Tekrar",
    "name" => "yeni_sifre_tekrar",
    "required" => FALSE,
));
echo '</div>
                    <div class="row w-100">
                        <div class="col-6 col-lg-6">
                        </div>';
if (!DEMO) {
    echo '<div class="col-6 col-lg-6 text-end">
                                <input type="submit" class="btn btn-success me-2 mb-2" value="Kaydet">
                            </div>';
} else {
    echo '<div class="col-6 col-lg-6">
                        </div>';
}
echo '
                    </div>
                </form>';
if (DEMO) {
    echo '<div class="row">
                <div class="col-6 col-lg-6">
                        </div>
                        <div class="col-6 col-lg-6 text-end">
                                <button type="submit" class="btn btn-success me-2 mb-2" onclick="alert(\'Demo sürümde bu işlemi gerçekleştiremezsiniz!\')">Kaydet</button>
                            </div>
        </div>';
}
echo '
            </div>
        </div>
    </section>
</div>';