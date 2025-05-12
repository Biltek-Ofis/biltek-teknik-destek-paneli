<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="content-wrapper">';
<?php
$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> $baslik." - Düzenle",
        "items"=> array(
            array(
                "link"=> base_url(),
                "text"=> "Anasayfa",
            ),
            array(
                "link"=> base_url("urunler"),
                "text"=> "Ürünler",
            ),
            array(
                "active"=> TRUE,
                "text"=> $baslik,
            ),
        ),
    ),
));
?>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form id="urunDuzenleForm" autocomplete="off" method="post"
                    action="<?= base_url("urunler/duzenle/" . $urun_id); ?>">
                    <?php
                    $this->load->view("icerikler/urunler/form", array("urun_id" => $urun_id));
                    ?>
                </form>
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <input id="urunDuzenleBtn" type="submit" class="btn btn-success" form="urunDuzenleForm"
                            value="Düzenle" />
                        <a href="<?= base_url("urunler"); ?>" class="btn btn-primary ml-1">Geri</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>