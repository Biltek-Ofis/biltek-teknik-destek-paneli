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
                    <ol class="breadcrumb float-sm-end">
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
