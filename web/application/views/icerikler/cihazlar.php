<?php echo '<div class="content-wrapper">';
$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> $baslik,
        "items"=> array(
            array(
                "link"=> base_url(),
                "text"=> "Anasayfa",
            ),
            array(
                "active"=> TRUE,
                "text"=> "Cihazlar",
            ),
            array(
                "active"=> TRUE,
                "text"=> $baslik,
            ),
        ),
    ),
));
echo '<section class="content">
        <div class="card">
            <div class="card-body px-0 mx-0">';
$this->load->view("icerikler/cihaz_tablosu", array("sorumlu_personel" => $sorumlu_personel, "silButonuGizle" => true));
echo '</div>
        </div>
    </section>
</div>';
