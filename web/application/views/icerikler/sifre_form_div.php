<form id="<?=$form_ad;?>SifreForm" method="post">
    <div class="row">
        <?php
        $this->load->view("ogeler/sifre_musteri", array(
            "id" => $form_id,
            "sifre_musteri_label" => TRUE,
            "sifre_musteri_value" => $sifre_musteri_value,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/sifre_aciklama", array(
            "id" => $form_id,
            "sifre_aciklama_label" => TRUE,
            "sifre_aciklama_value" => $sifre_aciklama_value,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/sifre_k_adi", array(
            "id" => $form_id,
            "sifre_k_adi_label" => TRUE,
            "sifre_k_adi_value" => $k_adi_value,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/sifre", array(
            "id" => $form_id,
            "sifre_label" => TRUE,
            "sifre_value" => $sifre_value,
        ));
        ?>
    </div>
</form>