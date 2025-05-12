<?php 
echo '<div class="content-wrapper">';
$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> "Anasayfa",
        "items"=> array(
            array(
                "link"=> base_url(),
                "text"=> "Anasayfa",
            ),
            array(
                "active"=> TRUE,
                "text"=> ">Boş Sayfa",
            ),
        ),
    ),
));
echo '<section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Anasayfa Başlık</h3>
            </div>
            <div class="card-body">
                Anasayfa İçerik
            </div>
        </div>
    </section>
</div>';