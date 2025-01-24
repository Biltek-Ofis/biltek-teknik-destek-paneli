<?php
defined('BASEPATH') or exit('No direct script access allowed');
$urun = array();
if (isset($urun_id)) {
    $urun = $this->Urunler_Model->urunGetir($urun_id)[0];
}
?>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/isim", array("isim_value" => isset($urun_id) ? $urun->isim : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/aciklama", array("aciklama_value" => isset($urun_id) ? $urun->aciklama : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/baglanti", array("baglanti_value" => isset($urun_id) ? $urun->baglanti : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/barkod", array("barkod_value" => isset($urun_id) ? $urun->barkod : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/stokkodu", array("stokkodu_value" => isset($urun_id) ? $urun->stokkodu : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/stokadeti", array("stokadeti_value" => isset($urun_id) ? $urun->stokadeti : "0"));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/alis", array("alis_value" => isset($urun_id) ? $urun->alis : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/satis", array("satis_value" => isset($urun_id) ? $urun->satis : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/indirimli", array("indirimli_value" => isset($urun_id) ? $urun->indirimli : ""));
    ?>
</div>
<div class="row">
    <?php
    $this->load->view("ogeler/urun/kg", array("kg_value" => isset($urun_id) ? $urun->kg : ""));
    ?>
</div>