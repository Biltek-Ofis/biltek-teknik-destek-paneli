<?php
$cihaz_var = FALSE;
if(isset($cihaz_mevcut)){
    $cihaz_var = $cihaz_mevcut;
}
?>
<div class="modal fade" id="cagriKaydiDuzenleModal" tabindex="-1" role="dialog"
    aria-labelledby="cagriKaydiDuzenleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cagriKaydiDuzenleModalTitle">Çağrı Kaydı Duzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cagriKaydiDuzenleForm" <?= isset($form_action) ? ' action="' . $form_action . '"' : ""; ?>
                    method="post">
                    <div id="cagriKaydiDuzenleAlert" class="row alert alert-danger" role="alert" style="<?=$cihaz_var ? "" : "display:none;";?>">
                    Bu çağrıya servis kaydı açıldığı için bazı bölümler düzenlenemez. Lütfen gerekli düzenlemeleri servis kaydı üzerinde yapın. <span id="cagriDuzenleServisNo" class="fw-bold"><?=isset($cagri_servis_no) && strlen($cagri_servis_no) ? "Servis No: ".$cagri_servis_no : "";?></span>
                    </div>
                    <div class="row">
                        <h6 class="col">Gerekli alanlar * ile belirtilmiştir.</h6>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/bolge", array(
                            "bolge_value" => isset($bolge_value) ? $bolge_value : "",
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/birim", array(
                            "birim_value" => isset($birim_value) ? $birim_value : "",
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/gsm", array(
                            "telefon_numarasi_label" => TRUE,
                            "gsm_id" => "telefon_numarasi2",
                            "telefon_numarasi_value" => isset($telefon_numarasi_value) ? $telefon_numarasi_value : "",
                            "telefon_numarasi_readonly"=> $cihaz_var,
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/cihaz_turleri", array(
                            "cihaz_turleri_label" => TRUE,
                            "cihaz_turu_value" => isset($cihaz_turu_value) ? $cihaz_turu_value : "",
                            "cihaz_turu_readonly"=> $cihaz_var,
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/cihaz_markasi", array(
                            "cihaz_markasi_label" => TRUE,
                            "cihaz_value" => isset($cihaz_value) ? $cihaz_value : "",
                            "cihaz_readonly"=> $cihaz_var,
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/cihaz_modeli", array(
                            "cihaz_modeli_label" => TRUE,
                            "cihaz_modeli_value" => isset($cihaz_modeli_value) ? $cihaz_modeli_value : "",
                            "cihaz_modeli_readonly"=> $cihaz_var,
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/seri_no", array(
                            "seri_no_label" => TRUE,
                            "seri_no_value" => isset($seri_no_value) ? $seri_no_value : "",
                            "seri_no_readonly"=> $cihaz_var,
                        ));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        $this->load->view("ogeler/ariza_aciklamasi", array(
                            "ariza_aciklamasi_label" => TRUE,
                            "ariza_aciklamasi_value" => isset($ariza_aciklamasi_value) ? $ariza_aciklamasi_value : "",
                            "ariza_aciklamasi_readonly"=> $cihaz_var,
                        ));
                        ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="cagriKaydiDuzenleKaydetBtn" class="btn btn-success" type="submit"
                    form="cagriKaydiDuzenleForm">Kaydet</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
            </div>
        </div>
    </div>
</div>