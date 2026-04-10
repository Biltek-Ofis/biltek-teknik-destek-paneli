<form id="<?=$form_ad;?>NotForm" method="post">
    <div class="row">
        <?php
        $this->load->view("ogeler/not", array(
            "id" => $form_id,
            "not" => $not_value,
        ));
        ?>
    </div>
</form>