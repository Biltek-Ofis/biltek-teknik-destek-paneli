<?php
$this->load->view("inc/style_tablo");
echo '<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cihaz Durumları</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yonetim</li>
                        <li class="breadcrumb-item active">Cihaz Durumları</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>';
    echo '<section class="content">
        <div class="card">
            <div class="card-body">
                <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary me-2 mb-2" data-toggle="modal" data-target="#yeniCihazDurumuEkleModal">
                            Yeni Cihaz Durumu Ekle
                        </button>
                    </div>
                </div>
                
                <div class="modal fade" id="yeniCihazDurumuEkleModal" tabindex="-1" aria-labelledby="yeniCihazDurumuEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="yeniCihazDurumuEkleModalLabel">Cihaz Durumu Ekle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="cihazDurumuEkleForm" autocomplete="off" method="post" action="' . base_url("yonetim/cihazDurumuEkle") . '">
                                    <div class="row">';
$this->load->view("ogeler/cihaz_durumu_durum");
echo '</div>';
echo '<div class="row">';
$this->load->view("ogeler/cihaz_durumu_kilitle");
echo '</div>';
$this->load->view("ogeler/cihaz_durumu_renk");
echo '

                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="cihazDurumuEkleForm" value="Ekle" />
                                <a href="#" class="btn btn-danger" data-dismiss="modal">İptal</a>
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
                                <th class="text-center">Cihaz Düzenlemeyi Kilitle <i class="fas fa-question-circle" style="color:grey;" title="Evet olarak ayarlandığında cihaz artık düzenlemeye kapatılır. (Yönetici Hesapları Hariç)"></i></th>
                                <th class="text-center">Sıralama <i class="fas fa-question-circle" style="color:grey;" title="Cihazlar sayfasındaki cihazların sıralamasını belirler."></i></th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                        $cihazDurumlari = $this->Cihazlar_Model->cihazDurumlari();
                        
                        foreach ($cihazDurumlari as $cihazDurumu) {
                            
                            echo '<tr class="'.$cihazDurumu->renk.'">';
                            echo '<td>';
                            echo $cihazDurumu->siralama;
                            echo '</td>';
                            echo '<td>';
                            echo $cihazDurumu->durum;
                            if($cihazDurumu->varsayilan > 0){
                                echo ' (Varsayılan)';
                            }
                            echo '</td>';
                            echo '<td class="text-center">';
                            echo $cihazDurumu->kilitle == 0 ? "Hayır" : "Evet";
                            echo '</td>';
                            echo '<td class="text-center">';
                            if($cihazDurumu->siralama > 1){
                                echo '<a href="'.base_url("yonetim/cihazDurumuYukariTasi/" . $cihazDurumu->id).'" class="btn btn-primary" title="Yukarı Taşı"><i class="fas fa-arrow-up"></i></a>';
                            }
                            if($cihazDurumu->siralama < count($cihazDurumlari)){
                                echo '<a href="'.base_url("yonetim/cihazDurumuAltaTasi/" . $cihazDurumu->id).'" class="btn btn-primary ml-1" title="Alta Taşı"><i class="fas fa-arrow-down"></i></a>';
                            }
                            echo '</td>';
                            echo '<td class="text-center">';
                            
                            if($cihazDurumu->varsayilan == 0){
                                echo '<a href="'.base_url("yonetim/cihazDurumuVarsayilanYap/" . $cihazDurumu->id).'" class="btn btn-secondary">Varsayılan Yap</a>';
                            }
                            echo '<a href="#" class="btn btn-info text-white ml-1" data-toggle="modal" data-target="#cihazDurumuDuzenleModal' . $cihazDurumu->id . '">Düzenle</i></a>';
                            echo '<a href="'.base_url("yonetim/cihazDurumuSil/" . $cihazDurumu->id).'" class="btn btn-danger ml-1">Sil</a>';
                            echo '</td>';
                            echo '</tr>';
                            echo '<div class="modal fade" id="cihazDurumuDuzenleModal' . $cihazDurumu->id . '" tabindex="-1" aria-labelledby="cihazDurumuDuzenleModal' . $cihazDurumu->id . 'Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cihazDurumuDuzenleModal' . $cihazDurumu->id . 'Label">Cihaz Durumu Ekle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="cihazDurumuDuzenleForm' . $cihazDurumu->id . '" autocomplete="off" method="post" action="' . base_url("yonetim/cihazDurumuDuzenle/".$cihazDurumu->id) . '">
                                    <div class="row">';
$this->load->view("ogeler/cihaz_durumu_durum", array("cihaz_durumu_durum_value"=>$cihazDurumu->durum, "id"=>$cihazDurumu->id));
echo '</div>';
echo '<div class="row">';
$this->load->view("ogeler/cihaz_durumu_kilitle", array("cihaz_durumu_kilitle_value"=>$cihazDurumu->kilitle, "id"=>$cihazDurumu->id));
echo '</div>';
$this->load->view("ogeler/cihaz_durumu_renk", array("cihaz_durumu_renk_value"=>$cihazDurumu->renk, "id"=>$cihazDurumu->id));
echo '

                                </form>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" form="cihazDurumuDuzenleForm' . $cihazDurumu->id . '" value="Kaydet" />
                                <a href="#" class="btn btn-danger" data-dismiss="modal">İptal</a>
                            </div>
                        </div>
                    </div>
                </div>';
                        }
                        echo '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>';
?>