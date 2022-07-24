<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?=$baslik;?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Cihazlar</li>
                        <li class="breadcrumb-item active"><?=$baslik;?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?php $this->load->view("icerikler/cihaz_tablosu", array("tur"=> $suankiCihazTuru, "cihazTuruGizle"=>true,"silButonuGizle"=>true));?>
            </div>
        </div>
    </section>
</div>