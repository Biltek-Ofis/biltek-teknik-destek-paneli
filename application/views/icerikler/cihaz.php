<?php
echo '<script>
    $(document).ready(function() {
        /*var hash = location.hash.replace(/^#/, \'\');
        if (hash) {
            $(\'#\' + hash + \'-tab\').click();
        }
        $(\'.nav-tabs a\').on(\'shown.bs.tab\', function(e) {
            window.location.hash = e.target.hash;
        });*/
    });
</script>
<script src="' . base_url("dist/js/cihaz.min.js") . '"></script>
<script src="' . base_url("dist/js/cihazyonetimi.min.js") . '"></script>
<script src="' . base_url("dist/js/forms.js") . '"></script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>' . $baslik . '</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item active">' . $baslik . '</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="genel-bilgiler-tab" data-toggle="pill" href="#genel-bilgiler" role="tab" aria-controls="genel-bilgiler" aria-selected="false">Genel Bilgiler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="yapilan-islemler-tab" data-toggle="pill" href="#yapilan-islemler" role="tab" aria-controls="yapilan-islemler" aria-selected="false">Yapılan İşlemler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="medyalar-tab" data-toggle="pill" href="#medyalar" role="tab" aria-controls="medyalar" aria-selected="false">Medyalar</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="genel-bilgiler" role="tabpanel" aria-labelledby="genel-bilgiler-tab">
                        <form id="cihazDuzenleForm" autocomplete="off" method="post" action="' . base_url("cihaz/duzenle/" . $cihaz->id."/get") . '">
                            <div class="table-responsive">
                                <table class="table table-flush">
                                    <thead></thead>
                                    <tbody>

                                        <!--<tr>
                                            <th class="align-middle">Müşteri Kodu: </th>
                                            <td id="musteri_kod_text" class="align-middle">
                                                ' . (isset($cihaz->musteri_kod) ? $cihaz->musteri_kod : "Yok") . '
                                            </td>
                                        </tr>-->
                                        <tr>
                                            <th class="align-middle">Müşteri Adı: </th>
                                            <td class="align-middle">';
$this->load->view("ogeler/musteri_adi", array("sifirla" => true, "musteri_adi_value" => $cihaz->musteri_adi, "musteri_kod_value" => $cihaz->musteri_kod));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Adresi: </th>
                                            <td class="align-middle">';
$this->load->view("ogeler/adres", array("sifirla" => true, "adres_value" => $cihaz->adres));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">GSM *: </th>
                                            <td class="align-middle">';
$this->load->view("ogeler/gsm", array("sifirla" => true, "telefon_numarasi_value" => $cihaz->telefon_numarasi));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Cihaz Türü:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/cihaz_turleri", array("sifirla" => true, "cihaz_turu_value" => $cihaz->cihaz_turu));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Sorumlu Personel:</th>
                                            <td class="align-middle">';

if ($this->Kullanicilar_Model->yonetici()) {

    $this->load->view("ogeler/sorumlu_select", array("sifirla" => true, "sorumlu_value" => $cihaz->sorumlu));
} else {
    echo $cihaz->sorumlu;
}

echo ' </td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Markası:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/cihaz_markasi", array("sifirla" => true, "cihaz_value" => $cihaz->cihaz));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Modeli:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/cihaz_modeli", array("sifirla" => true, "cihaz_modeli_value" => $cihaz->cihaz_modeli));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Seri Numarası:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/seri_no", array("sifirla" => true, "seri_no_value" => $cihaz->seri_no));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Cihaz Şifresi:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/cihaz_sifresi", array("sifirla" => true, "cihaz_sifresi_value" => $cihaz->cihaz_sifresi));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Teslim alınırken belirlenen hasar türü:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/hasar_turu", array("sifirla" => true, "cihazdaki_hasar_value" => $cihaz->cihazdaki_hasar));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Teslim alınırken yapılan hasar tespiti:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/hasar_tespiti", array("sifirla" => true, "hasar_tespiti_value" => $cihaz->hasar_tespiti));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Arıza Açıklaması:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/ariza_aciklamasi", array("sifirla" => true, "ariza_aciklamasi_value" => $cihaz->ariza_aciklamasi));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Teslim Alınanlar:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/teslim_alinanlar", array("sifirla" => true, "teslim_alinanlar_value" => $cihaz->teslim_alinanlar));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Servis Türü:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/servis_turu", array("sifirla" => true, "servis_turu_value" => $cihaz->servis_turu));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Yedek Alınacak mı?:</th>
                                            <td class="align-middle">';
$this->load->view("ogeler/yedek", array("sifirla" => true, "yedek_durumu_value" => $cihaz->yedek_durumu));
echo '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div id="container w-100 m-0 p-0">
                            <div class="row m-0 p-0 d-flex justify-content-end">
                                <input type="submit" class="btn btn-success mt-2 mr-2" form="cihazDuzenleForm" value="Kaydet" />
                                <a href="javascript:void(0);" id="sifirlaGenel" class="btn btn-secondary mt-2 mr-2">
                                    Sıfırla
                                </a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#servisKabulYazdirModal" class="btn btn-dark text-white mt-2 mr-2">Servis Kabul Formunu Yazdır</a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#barkoduYazdirModal" class="btn btn-dark text-white mt-2 mr-2">Bardkodu Yazdır</a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#formuYazdirModal" class="btn btn-dark text-white mt-2 mr-2">Formu Yazdır</a>
                                <a href="javascript:history.go(-1);" class="btn btn-danger text-white mt-2">Geri</a>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            var adres = $("#adres").val();
                            var pil = $("#pil").prop(\'selectedIndex\');
                            var ariza_aciklamasi = $("#ariza_aciklamasi").val();
                            var cihaz = $("#cihaz").val();
                            var cihaz_modeli = $("#cihaz_modeli").val();
                            var cihaz_turu = $("#cihaz_turu").prop(\'selectedIndex\');
                            var teslim_alinanlar = $("#teslim_alinanlar").val();
                            var telefon_numarasi = $("#telefon_numarasi").val();
                            var hasar_tespiti = $("#hasar_tespiti").val();
                            var cihazdaki_hasar = $("#cihazdaki_hasar").prop(\'selectedIndex\');
                            var musteri_adi = $("#musteri_adi").val();
                            var seri_no = $("#seri_no").val();
                            var servis_turu = $("#servis_turu").prop(\'selectedIndex\');
                            var tarih = $("#tarih").val();
                            var bildirim_tarihi = $("#bildirim_tarihi").val();
                            var cikis_tarihi = $("#cikis_tarihi").val();
                            var yedek_durumu = $("#yedek_durumu").prop(\'selectedIndex\');
                            $("#sifirlaGenel").on("click", function() {
                                $("#adres").val(adres);
                                $("#pil").prop(\'selectedIndex\', pil);
                                $("#ariza_aciklamasi").val(ariza_aciklamasi);
                                $("#cihaz").val(cihaz);
                                $("#cihaz_modeli").val(cihaz_modeli);
                                $("#cihaz_turu").prop(\'selectedIndex\', cihaz_turu);
                                $("#teslim_alinanlar").val(teslim_alinanlar);
                                $("#telefon_numarasi").val(telefon_numarasi);
                                $("#hasar_tespiti").val(hasar_tespiti);
                                $("#cihazdaki_hasar").prop(\'selectedIndex\', cihazdaki_hasar);
                                $("#musteri_adi").val(musteri_adi);
                                $("#seri_no").val(seri_no);
                                $("#servis_turu").prop(\'selectedIndex\', servis_turu);
                                $("#tarih").val(tarih);
                                $("#bildirim_tarihi").val(bildirim_tarihi);
                                $("#cikis_tarihi").val(cikis_tarihi);
                                $("#yedek_durumu").prop(\'selectedIndex\', yedek_durumu);
                            });
                        });
                    </script>
                    <div class="tab-pane fade" id="yapilan-islemler" role="tabpanel" aria-labelledby="yapilan-islemler">
                        <div class="table-responsive">
                            <form id="yapilanIslemlerForm" autocomplete="off" method="post" action="' . base_url("cihaz/yapilanIslemDuzenle/" . $cihaz->id . "/get") . ' ">
                                <table class="table table-flush">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="form">
                                        <tr>
                                            <th class="align-middle" colspan="2">Giriş Tarihi:</th>
                                            <td class="align-middle" colspan="2">';
$this->load->view("ogeler/tarih", $cihaz->tarih == "" ? array("isim" => "tarih", "sifirla" => true) : array("isim" => "tarih", "sifirla" => true, "tarih_value" => $cihaz->tarih));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle" colspan="2">Bildirim Tarihi:</th>
                                            <td class="align-middle" colspan="2">';
$this->load->view("ogeler/bildirim_tarihi", $cihaz->bildirim_tarihi == "" ? array("sifirla" => true) : array("sifirla" => true, "bildirim_tarihi_value" => $cihaz->bildirim_tarihi));
echo '</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle" colspan="2">Çıkış Tarihi:</th>
                                            <td class="align-middle" colspan="2">';
$this->load->view("ogeler/cikis_tarihi", $cihaz->cikis_tarihi == "" ? array("isim" => "cikis_tarihi", "sifirla" => true) : array("isim" => "cikis_tarihi", "sifirla" => true, "cikis_tarihi_value" => $cihaz->cikis_tarihi));
echo '</td>
                                        </tr>
                                        <tr>
                                        <th class="align-middle" colspan="2">Güncel Durum:</th>
                                        <td class="align-middle" colspan="2">';
$this->load->view("ogeler/guncel_durum", array("sifirla" => true, "guncel_durum_value" => $cihaz->guncel_durum));
echo '</td>
</tr>
<tr>
<th class="align-middle" colspan="2">Tahsilat Şekli:</th>
<td class="align-middle" colspan="2">';
$this->load->view("ogeler/tahsilat_sekli", array("sifirla" => true, "tahsilat_sekli_value" => $cihaz->tahsilat_sekli));
echo '</td>
</tr>
<tr>
<th class="align-middle" colspan="2">Fatura Durumu:</th>
<td id="fatura_durumu_td" class="align-middle" colspan="'.($cihaz->fatura_durumu == (count($this->Islemler_Model->faturaDurumu) - 1) ? 1 : 2).'">';
$this->load->view("ogeler/fatura_durumu", array("sifirla" => true, "fatura_durumu_value" => $cihaz->fatura_durumu));
echo '</td>
<td id="fis_no_td" class="align-middle" style="'.($cihaz->fatura_durumu == (count($this->Islemler_Model->faturaDurumu) - 1) ? "" : "display:none;").'" colspan="'.($cihaz->fatura_durumu == (count($this->Islemler_Model->faturaDurumu) - 1) ? 1 : 0).'">';
$this->load->view("ogeler/fis_no", array("sifirla" => true, "fis_no_value" => $cihaz->fis_no));
echo '</td>
</tr>
                                    </tbody>
                                </table>
                                <table class="table table-flush">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!--<th>SK</th>-->
                                            <th>Malzeme/İşçilik</th>
                                            <th>Miktar</th>
                                            <th>Birim Fiyat (TL)</th>
                                            <th>KDV Oranı (%)</th>
                                            <th>Tutar</th>
                                            <th>KDV</th>
                                        </tr>
                                    </thead>
                                    <tbody id="yapilanIslemBody">';

$toplam = 0;
$kdv = 0;
$genel_toplam = 0;
foreach($cihaz->islemler as $islem){
    $toplam_islem_fiyati_suan = $islem->birim_fiyat * $islem->miktar;
    $toplam_kdv_suan = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_suan / 100) * $islem->kdv);
    $kdv = $kdv + $toplam_kdv_suan;
    $toplam = $toplam + $toplam_islem_fiyati_suan;
}
$genel_toplam = $toplam + $kdv;
for($i = 1; $i <= $this->Islemler_Model->maxIslemSayisi; $i++){
    $islem_sira = $i - 1;
    $this->load->view("ogeler/yapilan_islem", array("index" => $i, "yapilanIslemArr" => isset($cihaz->islemler[$islem_sira]) ? array(
        "islem" => $cihaz->islemler[$islem_sira]->ad,
        "miktar" => $cihaz->islemler[$islem_sira]->miktar,
        "birim_fiyati" => $cihaz->islemler[$islem_sira]->birim_fiyat,
        "kdv" => $cihaz->islemler[$islem_sira]->kdv
    ) : null));
}
echo '<tr>
                                            <th colspan="5">Toplam</th>
                                            <td colspan="2" id="yapilanIslemToplam">' . ($toplam > 0 ? $toplam . " TL" : "") . ' </td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">KDV</th>
                                            <td colspan="2" id="yapilanIslemKdv">' . ($kdv > 0 ? $kdv . " TL" : "") . '</td>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Genel Toplam</th>
                                            <td colspan="2" id="yapilanIslemGenelToplam">' . ($genel_toplam > 0 ? $genel_toplam . " TL" : "") . ' </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <div class="form-group p-0 m-0 col">
                                                    <textarea id="yapilan_islem_aciklamasi" autocomplete="off" name="yapilan_islem_aciklamasi" class="form-control" rows="3" placeholder="Yapılan işlem açıklaması">' . $cihaz->yapilan_islem_aciklamasi . '</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div id="container w-100 m-0 p-0">
                            <div class="row m-0 p-0 d-flex justify-content-end">
                                <input type="submit" class="btn btn-success mt-2 mr-2" form="yapilanIslemlerForm" value="Kaydet" />
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#servisKabulYazdirModal" class="btn btn-dark text-white mt-2 mr-2">Servis Kabul Formunu Yazdır</a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#barkoduYazdirModal" class="btn btn-dark text-white mt-2 mr-2">Bardkodu Yazdır</a>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#formuYazdirModal" class="btn btn-dark text-white mt-2 mr-2">Formu Yazdır</a>
                                <a href="javascript:history.go(-1);" class="btn btn-danger text-white mt-2">Geri</a>
                            </div>
                        </div>
                        <script>

                        </script>
                    </div>
                    <script>

                    </script>
                    <div class="tab-pane fade" id="medyalar" role="tabpanel" aria-labelledby="medyalar">';
$this->load->view("icerikler/medyalar", array("id" => $cihaz->id, "silButonu" => true));
echo '<div class="row text-center">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <form id="upload_form" onsubmit="dosyaYukle(' . $cihaz->id . ' , function(){window.location.reload();})" enctype="multipart/form-data" method="post">
                                    <div class="form-group">
                                        <input type="file" name="yuklenecekDosya" id="yuklenecekDosya" required>
                                    </div>
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" value="Medya Yükle" name="btnSubmit" accept="image/pjpeg, image/png, image/jpeg, video/mp4">
                                    </div>
                                    <div class="form-group">
                                        <div class="progress" id="progressDiv">
                                            <progress id="progressBar" value="0" max="100" style="width:100%; height: 1.2rem;"></progress>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h3 id="durum"></h3>
                                        <p id="yukleme_durumu"></p>
                                    </div>
                                </form>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="formuYazdirModal" tabindex="-1" role="dialog" aria-labelledby="formuYazdirModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formuYazdirModalLabel">Yazdırma İşlemini Onaylayın</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yazdırma işleminden önce yaptığınız değişiklikleri kaydetmelisiniz.
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" onclick="formuYazdir(' . $cihaz->id . ');" class="btn btn-dark text-white">Yazdır</a>
                <a class="btn btn-secondary" data-dismiss="modal">Kapat</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="servisKabulYazdirModal" tabindex="-1" role="dialog" aria-labelledby="servisKabulYazdirModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="servisKabulYazdirModalLabel">Yazdırma İşlemini Onaylayın</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yazdırma işleminden önce yaptığınız değişiklikleri kaydetmelisiniz.
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" onclick="servisKabulYazdir(' . $cihaz->id . ');" class="btn btn-dark text-white">Yazdır</a>
                <a class="btn btn-secondary" data-dismiss="modal">Kapat</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="barkoduYazdirModal" tabindex="-1" role="dialog" aria-labelledby="barkoduYazdirModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barkoduYazdirModalLabel">Yazdırma İşlemini Onaylayın</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yazdırma işleminden önce yaptığınız değişiklikleri kaydetmelisiniz.
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" onclick="barkoduYazdir(' . $cihaz->id . ');" class="btn btn-dark text-white">Yazdır</a>
                <a class="btn btn-secondary" data-dismiss="modal">Kapat</a>
            </div>
        </div>
    </div>
</div>';

$this->load->view("inc/modal_medyasil");