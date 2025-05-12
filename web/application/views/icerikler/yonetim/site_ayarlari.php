<?php
$ayarlar = $this->Ayarlar_Model->getir();
echo '<div class="content-wrapper">';

$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> $baslik,
        "items"=> array(
            array(
                "link"=> base_url(),
                "text"=> "Anasayfa",
            ),
            array(
                "text"=> "Yonetim",
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
            <div class="card-body">
                <form method="post" action="'.base_url("yonetim/ayarDuzenle").'">
                    <div class="col">
                        <label class="form-label" for="db_baslik">Site Başlığı</label>
                        <input id="db_baslik" name="db_baslik" autocomplete="off" class="form-control" type="text" placeholder="Site Başlığı" value="' . $ayarlar->site_basligi . '" required>
                    </div>
                    <div class="col">
                        <label class="form-label" for="db_anasayfa">Şirketinizin Websitesi</label>
                        <input id="db_anasayfa" name="db_anasayfa" autocomplete="off" class="form-control" type="text" placeholder="Şirketinizin Websitesi" value="' . $ayarlar->firma_url . '" required>
                    </div>
                    <div class="row w-100">
                        <div class="col-6 col-lg-6">
                        </div>
                        <div class="col-6 col-lg-6 text-end">
                            <input type="submit" class="btn btn-success mt-2 mr-2" value="Kaydet" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>';
