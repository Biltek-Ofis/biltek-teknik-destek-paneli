<form id="<?=$form_ad;?>MalzemeTeslimiForm" method="post">
    <div class="row">
        <?php
        $this->load->view("ogeler/malzemeteslimi/firma", array(
            "id" => $form_id,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/malzemeteslimi/teslim_eden", array(
            "id" => $form_id,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/malzemeteslimi/teslim_alan", array(
            "id" => $form_id,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/malzemeteslimi/siparis_tarihi", array(
            "id" => $form_id,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/malzemeteslimi/teslim_tarihi", array(
            "id" => $form_id,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/malzemeteslimi/vade_tarihi", array(
            "id" => $form_id,
        ));
        ?>
    </div>
    <div class="row">
        <?php
        $this->load->view("ogeler/malzemeteslimi/odeme_durumu", array(
            "id" => $form_id,
        ));
        ?>
    </div>
    <table class="table table-flush">
        <thead>
            <tr>
                <th>#</th> <!--<th>SK</th>-->
                <th>Malzeme</th>
                <th>Adet</th>
                <th>Birim Fiyat (TL)</th>
                <th>KDV Oranı (%)</th>
                <th>KDV</th>
                <th>Tutar (KDV'siz)</th>
                <th>Toplam</th>
            </tr>
        </thead>
        <tbody id="<?=$form_ad;?>yapilanIslemBody">
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "1",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "2",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "3",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "4",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "5",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "6",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "7",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "8",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "9",
                ));
                ?>
            </div>
            <div class="row">

                <?php
                $this->load->view("ogeler/malzemeteslimi/islem", array(
                    "id" => $form_id,
                    "index" => "10",
                ));
                ?>
            </div>
        </tbody>
    </table>
</form>