<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view("inc/style_tablo");
$this->load->view("inc/styles_important");
?>
<div class="content-wrapper"><?php
$this->load->view("inc/content_header", array(
    "contentHeader" => array(
        "baslik"=> "Cihaz Durumları",
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
                "text"=> "Cihaz Durumları",
            ),
        ),
    ),
));
?>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-6 col-lg-6">
                    </div>
                    <div class="col-6 col-lg-6 text-end">
                        <button type="button" class="btn btn-primary me-2 mb-2" data-bs-toggle="modal"
                            data-bs-target="#yeniCihazDurumuEkleModal">
                            Yeni Cihaz Durumu Ekle
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="yeniCihazDurumuEkleModal" tabindex="-1"
                    aria-labelledby="yeniCihazDurumuEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniCihazDurumuEkleModalLabel">Cihaz Durumu Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="cihazDurumuEkleForm" autocomplete="off" method="post"
                                    action="<?= base_url("yonetim/cihazDurumuEkle"); ?>">
                                    <div class="row">
                                        <?php
                                        $this->load->view("ogeler/cihaz_durumu_durum");
                                        ?>
                                    </div>
                                    <div class="row">
                                        <?php
                                        $this->load->view("ogeler/cihaz_durumu_kilitle");
                                        ?>
                                    </div>
                                    <?php
                                    $this->load->view("ogeler/cihaz_durumu_renk");
                                    ?>


                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="cihazDurumuEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="cihaz_turu_tablosu" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sıra</th>
                                <th>Durum</th>
                                <th class="text-center">Cihaz Düzenlemeyi Kilitle <i class="fas fa-question-circle"
                                        style="color:grey;"
                                        title="Evet olarak ayarlandığında cihaz artık düzenlemeye kapatılır. (Yönetici Hesapları Hariç)"></i>
                                </th>
                                <th class="text-center">Sıralama <i class="fas fa-question-circle" style="color:grey;"
                                        title="Cihazlar sayfasındaki cihazların sıralamasını belirler."></i></th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cihazDurumlari = $this->Cihazlar_Model->cihazDurumlari();
                            foreach ($cihazDurumlari as $cihazDurumu) {
                                ?>
                                <tr class="<?= $cihazDurumu->renk; ?>">
                                    <td>
                                        <?= $cihazDurumu->siralama; ?>
                                    </td>
                                    <td>
                                        <?= $cihazDurumu->durum; ?>
                                        <?php
                                        if ($cihazDurumu->varsayilan > 0) {
                                            ?>
                                            &nbsp;(Varsayılan)
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= ($cihazDurumu->kilitle == 0 ? "Hayır" : "Evet"); ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($cihazDurumu->siralama > 1) {
                                            ?>
                                            <a href="<?= base_url("yonetim/cihazDurumuYukariTasi/" . $cihazDurumu->id); ?>"
                                                class="btn btn-primary" title="Yukarı Taşı"><i class="fas fa-arrow-up"></i></a>
                                            <?php
                                        }
                                        if ($cihazDurumu->siralama < count($cihazDurumlari)) {
                                            ?>
                                            <a href="<?= base_url("yonetim/cihazDurumuAltaTasi/" . $cihazDurumu->id); ?>"
                                                class="btn btn-primary ml-1" title="Alta Taşı"><i
                                                    class="fas fa-arrow-down"></i></a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($cihazDurumu->varsayilan == 0) {
                                            ?>
                                            <a href="<?= base_url("yonetim/cihazDurumuVarsayilanYap/" . $cihazDurumu->id); ?>"
                                                class="btn btn-secondary">Varsayılan Yap</a>
                                            <?php
                                        }
                                        ?>
                                        <a href="#" class="btn btn-info text-white ml-1" data-bs-toggle="modal"
                                            data-bs-target="#cihazDurumuDuzenleModal<?= $cihazDurumu->id; ?>">Düzenle</i></a>
                                        <a href="<?= base_url("yonetim/cihazDurumuSil/" . $cihazDurumu->id); ?>"
                                            class="btn btn-danger ml-1">Sil</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="cihazDurumuDuzenleModal<?= $cihazDurumu->id; ?>" tabindex="-1"
                                    aria-labelledby="cihazDurumuDuzenleModal<?= $cihazDurumu->id; ?>Label"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="cihazDurumuDuzenleModal<?= $cihazDurumu->id; ?>Label">Cihaz Durumu
                                                    Ekle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="cihazDurumuDuzenleForm<?= $cihazDurumu->id; ?>" autocomplete="off"
                                                    method="post"
                                                    action="<?= base_url("yonetim/cihazDurumuDuzenle/" . $cihazDurumu->id); ?>">
                                                    <div class="row">
                                                        <?php
                                                        echo '';
                                                        $this->load->view("ogeler/cihaz_durumu_durum", array("cihaz_durumu_durum_value" => $cihazDurumu->durum, "id" => $cihazDurumu->id));
                                                        ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php
                                                        $this->load->view("ogeler/cihaz_durumu_kilitle", array("cihaz_durumu_kilitle_value" => $cihazDurumu->kilitle, "id" => $cihazDurumu->id));
                                                        ?>
                                                    </div>
                                                    <?php
                                                    $this->load->view("ogeler/cihaz_durumu_renk", array("cihaz_durumu_renk_value" => $cihazDurumu->renk, "id" => $cihazDurumu->id));
                                                    ?>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-success"
                                                    form="cihazDurumuDuzenleForm<?= $cihazDurumu->id; ?>" value="Kaydet" />
                                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">İptal</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>