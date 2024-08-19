<?php
$ayarlar = $this->Ayarlar_Model->getir();
echo '<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>' . $baslik . '</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yonetim</li>
                        <li class="breadcrumb-item active">' . $baslik . '</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>';
echo '<section class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="'.base_url("yonetim/ayarDuzenle").'">
                    <div class="form-group col">
                        <label for="db_baslik">Site Başlığı</label>
                        <input id="db_baslik" name="db_baslik" autocomplete="off" class="form-control" type="text" placeholder="Site Başlığı" value="' . $ayarlar->site_basligi . '" required>
                    </div>
                    <div class="form-group col">
                        <label for="db_anasayfa">Şirketinizin Websitesi</label>
                        <input id="db_anasayfa" name="db_anasayfa" autocomplete="off" class="form-control" type="text" placeholder="Şirketinizin Websitesi" value="' . $ayarlar->firma_url . '" required>
                    </div>
                    <div id="container w-100 m-0 p-0">
                        <div class="row m-0 p-0 d-flex justify-content-end">
                            <input type="submit" class="btn btn-success mt-2 mr-2" value="Kaydet" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>';
