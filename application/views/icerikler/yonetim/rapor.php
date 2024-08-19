<?php
$this->load->view("inc/datatables_scripts");
$this->load->view("inc/style_tablo");
echo '<style>
.dt-buttons{
    display: none;
}
</style>';
echo '<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rapor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yönetim</li>
                        <li class="breadcrumb-item active">Rapor</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
            <script>
            var tabloDiv = "rapor_tablosu";
            var musteriInput = "#musteri_ara";
            var cihazMarkaInput = "#cihaz_marka_ara";
            var cihazModelInput = "#cihaz_model_ara";
            var cihazTuruInput = "#cihaz_turu";
            var personelInput = "#personel";
            var cihazDurumuInput = "#cihaz_durumu";
            var seciliPersonel = "Tümü";
            var seciliCihazDurumu = "Hepsi";
            var yilInput = "#yil";
            var girisTarihiInput1 = "#giris_tarihi_baslangic_ara";
            var girisTarihiInput2 = "#giris_tarihi_bitis_ara";
            var girisTarBas, girisTarBit;
            var sayfaSayisiInput = "#sayfa_sayisi_goster";
            var sayfaSayisiGoster = false;
            var sayfaSayisiSelect = "#sayfaSayisiKonumu";
            var sayfaSayisiKonumu = "1";
            var ucretInput = "#ucret_goster";
            var ucretGoster = true;
            function filtreText(input, sira){
                $.fn.dataTable.ext.search.push(
                    function( settings, searchData, index, rowData, counter ) {
                        if (settings.nTable.id !== tabloDiv){
                            return true;
                        }
                        var input_val = $(input).val().toLocaleUpperCase("tr-TR");
                        var input_val_tablo = searchData[sira].toLocaleUpperCase("tr-TR").includes(input_val);
                        var input_val_goster = (!input_val || (input_val && input_val_tablo))
    
                        if (input_val_goster)
                        {
                            return true;
                        }
                        return false;
                    }
                );
            }
            function filtreBirebir(input, sira){
                $.fn.dataTable.ext.search.push(
                    function( settings, searchData, index, rowData, counter ) {
                        if (settings.nTable.id !== tabloDiv){
                            return true;
                        }
                        var input_val = $(input).val().toLocaleUpperCase("tr-TR");
                        var input_val_tablo = searchData[sira].toLocaleUpperCase("tr-TR") == input_val;
                        var input_val_goster = (!input_val || (input_val && input_val_tablo))
    
                        if (input_val_goster)
                        {
                            return true;
                        }
                        return false;
                    }
                );
            }
            function filtreStartsWith(input, sira){
                $.fn.dataTable.ext.search.push(
                    function( settings, searchData, index, rowData, counter ) {
                        if (settings.nTable.id !== tabloDiv){
                            return true;
                        }
                        var input_val = $(input).val()
                        var input_val_tablo = searchData[sira].startsWith(input_val);
                        var input_val_goster = (!input_val || (input_val && input_val_tablo))
    
                        if (input_val_goster)
                        {
                            return true;
                        }
                        return false;
                    }
                );
            }
            function filtreTarih(input1, input2, sira){
                $.fn.dataTable.ext.search.push(
                    function( settings, searchData, index, rowData, counter ) {
                        if (settings.nTable.id !== tabloDiv){
                            return true;
                        }
                        var min = girisTarBas.val();
                        var max = girisTarBit.val();
                        var date = new Date( searchData[5] );
                
                        if (
                            ( min === null && max === null ) ||
                            ( min === null && date <= max ) ||
                            ( min <= date   && max === null ) ||
                            ( min <= date   && date <= max )
                        ) {
                            return true;
                        }
                        return false;
                    }
                );
            }
            function topla(){
                $.fn.dataTable.Api.register( "sum()", function () {
                    var sum = 0;
                 
                    for ( var i=0, ien=this.length ; i<ien ; i++ ) {
                        sum += parseFloat(this[i]);
                    }
                 
                    return sum.toFixed(2);
                } );
            }
            function baslik(){
                var bugun = new Date();
                bugun.setDate(bugun.getDate() + 20);
                return "' . SITE_BASLIGI . ' Teknik Servis Raporu - " + bugun.getFullYear() + "/"
                + ("0" + bugun.getMonth()).slice(-2) + "/"
                + ("0" + bugun.getDate()).slice(-2) + " " + ("0" + (bugun.getHours())).slice(-2) + ":" + ("0" + (bugun.getMinutes())).slice(-2);
            }
            
            $(document).ready(function() {
                topla();
                var tutarHesapla = function(){
                    return cihazlarTablosu.column(7,{filter:"applied", search: "applied"}).data().sum();
                }
                var tutarHtml = function(){
                    $("#tutarToplam").html(tutarHesapla());
                }
                var kdvHesapla = function(){
                    return cihazlarTablosu.column(8,{filter:"applied", search: "applied"}).data().sum();
                }
                var kdvHtml = function(){
                    $("#kdvToplam").html(kdvHesapla());
                }
                var genelToplamHesapla = function(){
                    return cihazlarTablosu.column(9,{filter:"applied", search: "applied"}).data().sum();
                }
                var genelToplamHtml = function(){
                    $("#genelToplam").html(genelToplamHesapla());
                }
                var cihazSayisi = function(){
                    return cihazlarTablosu.column(0,{filter:"applied", search: "applied"}).data().count();
                }
                var cihazSayisiHtml = function(){
                    $("#cihazSayisi").html(cihazSayisi());
                }
                var customize = function ( doc ) {
                    /*doc["header"] = (function(page, pages) {
                        return {
                            columns: [
                                {
                                    alignment: "left",
                                    text: [
                                        { text: "Cihaz Sayısı: " + cihazSayisi() + (ucretGoster ?  ", KDV\'siz Tutar: " + tutarHesapla() + " TL, KDV: " + kdvHesapla() + " TL, Genel Toplam: " + genelToplamHesapla() + " TL" : ""), italics: true },
                                    ]
                                }
                            ],
                            margin: [10, 10],
                            fontSize:16
                        }
                    });*/
                    if(sayfaSayisiGoster){
                        doc["footer"] = (function(page, pages) {
                            return {
                                columns: [
                                    sayfaSayisiKonumu == "3" ? {
                                        alignment: "left",
                                        text: [
                                            { text: page.toString(), italics: true },
                                        ]
                                    } : "",
                                    sayfaSayisiKonumu == "2" ? {
                                        alignment: "center",
                                        text: [
                                            { text: page.toString(), italics: true },
                                        ]
                                    } : "",
                                    sayfaSayisiKonumu == "1" ? {
                                        alignment: "right",
                                        text: [
                                            { text: page.toString(), italics: true },
                                        ]
                                    } : ""
                                ],
                                margin: [10, 10],
                                fontSize:16
                            }
                        });
                    }
                    //doc.defaultStyle.fontSize = 16;
                }
                var cihazlarTablosu = $("#" + tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari('[0, "desc"]', 'true', '
                "buttons": [{
                    extend: "csv",
                    title: baslik(),
                    pageSize: "LEGAL",
                    title: baslik()
                }, {
                    extend: "excel",
                    title: baslik(),
                    pageSize: "LEGAL",
                    messageBottom: function () {
                        return "Cihaz Sayısı: " + cihazSayisi() + (ucretGoster ?  ", KDV\'siz Tutar: " + tutarHesapla() + " TL, KDV: " + kdvHesapla() + " TL, Genel Toplam: " + genelToplamHesapla() + " TL" : "");
                    }
                }, {
                    extend: "pdfHtml5",
                    orientation: "landscape",
                    pageSize: "LEGAL",
                    title: baslik(),
                    customize: customize,
                    messageBottom: function () {
                        return "Cihaz Sayısı: " + cihazSayisi() + (ucretGoster ?  ", KDV\'siz Tutar: " + tutarHesapla() + " TL, KDV: " + kdvHesapla() + " TL, Genel Toplam: " + genelToplamHesapla() + " TL" : "");
                    }
                }],
                drawCallback: function(){
                    tutarHtml();
                    kdvHtml();
                    genelToplamHtml();
                    cihazSayisiHtml();
                },', '
                setTimeout(function(){cihazlarTablosu.buttons().container().appendTo("#" + tabloDiv + "_wrapper .col-md-6:eq(0)");}, 10);
                tutarHtml();
                kdvHtml();
                genelToplamHtml();
                cihazSayisiHtml();') . ');
                filtreStartsWith(yilInput, 0)
                filtreText(musteriInput,1);
                filtreText(cihazMarkaInput,2);
                filtreText(cihazModelInput,3);
                girisTarBas = new DateTime($(girisTarihiInput1), {
                    format: "YYYY-MM-DD",
                    locale: "tr"
                });
                girisTarBit = new DateTime($(girisTarihiInput2), {
                    format: "YYYY-MM-DD",
                    locale: "tr"
                });
                filtreTarih(girisTarihiInput1, girisTarihiInput2, 5);
                filtreBirebir(cihazTuruInput, 4);
                filtreBirebir(personelInput, 10);
                filtreBirebir(cihazDurumuInput, 11);
                $(musteriInput + ", " + cihazMarkaInput + ", " + cihazModelInput + ", " + girisTarihiInput1 + ", " + girisTarihiInput2 + ", " + yilInput + ", " + cihazTuruInput).on("keyup change", function(){
                    cihazlarTablosu.draw();
                });
                $(personelInput).change(function() {
                    if($(this).val().length > 0){
                        seciliPersonel = $(this).val();
                    }else{
                        seciliPersonel = "Tümü";
                    }
                    cihazlarTablosu.draw();
                });
                $(cihazDurumuInput).change(function() {
                    if($(this).val().length > 0){
                        seciliCihazDurumu = $(this).val();
                    }else{
                        seciliCihazDurumu = "Hepsi";
                    }
                    cihazlarTablosu.draw();
                });
                $(sayfaSayisiInput).change(function() {
                    sayfaSayisiGoster = this.checked;
                });
                $(sayfaSayisiSelect).change(function() {
                    sayfaSayisiKonumu = $(this).val();
                });
                $(ucretInput).change(function() {
                    ucretGoster = this.checked;
                });
                $("#csvDonustur").on("click", function(){
                    cihazlarTablosu.button(0).trigger();
                });
                $("#excDonustur").on("click", function(){
                    cihazlarTablosu.button(1).trigger();
                });
                $("#pdfDonustur").on("click", function(){
                    cihazlarTablosu.button(2).trigger();
                });
            });
            </script>
                <table class="table table-borderless mb-3">
                    <thead>
                        <tr>
                            <th style="width:calc(100% / 6)"></th>
                            <th style="width:calc(100% / 6)"></th>
                            <th style="width:calc(100% / 6)"></th>
                            <th style="width:calc(100% / 6)"></th>
                            <th style="width:calc(100% / 6)"></th>
                            <th style="width:calc(100% / 6)"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><th class="h5 font-weight-bold" colspan="6">Kısıtlar</th></tr>    
                        <tr>
                            <td class="p-1 m-0" colspan="6">
                                <div class="form-group p-0 m-0">
                                    <label for="musteri_ara">Müşteri</label>
                                    <input id="musteri_ara" type="text" class="form-control" placeholder="Müşteri Adı">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-1 m-0" colspan="3">
                                <div class="form-group p-0 m-0">
                                    <label for="cihaz_marka_ara">Cihaz Markası</label>
                                    <input id="cihaz_marka_ara" type="text" class="form-control" placeholder="Cihaz Markası">
                                </div>
                            </td>
                            <td class="p-1 m-0" colspan="3">
                                <div class="form-group p-0 m-0">
                                    <label for="cihaz_model_ara">Modeli</label>
                                    <input id="cihaz_model_ara" type="text" class="form-control" placeholder="Cihaz Modeli">
                                </div>
                            </td>
                        </tr>';
$cihazTurleri = $this->Cihazlar_Model->cihazTurleri();
echo '<tr>
                                                <td class="p-1 m-0" colspan="6">
                                                    <div class="form-group p-0 m-0">
                                                        <label for="cihaz_turu">Cihaz Türü</label>
                                                        <select id="cihaz_turu" class="form-control" aria-label="Cihaz Türü">
                                                        <option value="">Cihaz Türü Seçin</option>';
foreach ($cihazTurleri as $cihazTuru) {
    echo '<option value="' . $cihazTuru->isim . '">' . $cihazTuru->isim . '</option>';
}
echo '</select>
                                                    </div>
                                                </td>
                                                </tr>';
echo '<tr>
        <td class="p-1 m-0" colspan="6">
            <div class="form-group p-0 m-0">
                <label for="cihaz_durumu">Cihaz Durumu</label>
                <select id="cihaz_durumu" class="form-control" aria-label="Cihaz Durumu">
                <option value="">Hepsi</option>';
$cihazDurumlari = $this->Cihazlar_Model->cihazDurumlari();
foreach ($cihazDurumlari as $cihazDurumu) {
    echo '<option value="' . $cihazDurumu->durum . '">' . $cihazDurumu->durum. '</option>';
}
echo '<option value="Belirtilmemiş">Belirtilmemiş</option>';
echo '</select>
                                                                            </div>
                                                                        </td>
                                                                        </tr>';
$personeller = $this->Kullanicilar_Model->kullanicilar(array());
echo '<tr>
        <td class="p-1 m-0" colspan="6">
            <div class="form-group p-0 m-0">
                <label for="personel">Personel</label>
                <select id="personel" class="form-control" aria-label="Personel">
                <option value="">Tümü</option>';
foreach ($personeller as $personel) {
    echo '<option value="' . $personel->ad_soyad . '">' . $personel->ad_soyad . '</option>';
}
echo '</select>
                                                                            </div>
                                                                        </td>
                                                                        </tr>';
echo '<tr>
                            <td class="p-1 m-0" colspan="6">
                                <div class="form-group p-0 m-0">
                                    <label for="yil">Yıl</label>
                                    <input id="yil" type="number" min="1900" max="2099" step="1" class="form-control" placeholder="' . date("Y") . '">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-1 m-0" colspan="3">
                                <div class="form-group p-0 m-0">
                                    <label for="giris_tarihi_baslangic_ara">Giriş Tarihi Başlangıç</label>
                                    <input id="giris_tarihi_baslangic_ara" type="text" class="form-control" placeholder="Giriş Tarihi Başlangıç">
                                </div>
                            </td>
                            <td class="p-1 m-0" colspan="3">
                                <div class="form-group p-0 m-0">
                                    <label for="giris_tarihi_bitis_ara">Bitiş</label>
                                    <input id="giris_tarihi_bitis_ara" type="text" class="form-control" placeholder="Giriş Tarihi Bitiş">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
            <table class="table table-borderless mb-3">
            <thead>
                <tr>
                    <th style="width:calc(100% / 6)"></th>
                    <th style="width:calc(100% / 6)"></th>
                    <th style="width:calc(100% / 6)"></th>
                    <th style="width:calc(100% / 6)"></th>
                    <th style="width:calc(100% / 6)"></th>
                    <th style="width:calc(100% / 6)"></th>
                </tr>
            </thead>
            <tbody>
                <tr><th class="h5 font-weight-bold" colspan="6">Sayfa Özellikleri</th></tr>
                <tr>
                    <td class="p-1 m-0" colspan="6"> 
                        <div class="form-group form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="sayfa_sayisi_goster">
                            <label class="form-check-label" for="sayfa_sayisi_goster">Sayfa Sayısını Göster</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="p-1 m-0" colspan="6">
                        <div class="form-group">
                            <label for="sayfaSayisiKonumu">Sayfa Sayısı Konumu</label>
                            <select class="form-control" id="sayfaSayisiKonumu">
                                <option value="1">Sağ</option>
                                <option value="2">Orta</option>
                                <option value="3">Sol</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="p-1 m-0" colspan="6">
                        <div class="form-group form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="ucret_goster" checked>
                            <label class="form-check-label" for="ucret_goster">Ücretleri Göster</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
            <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">
                        <button id="csvDonustur" type="button" class="btn btn-primary mr-2 mb-2">
                            CSV
                        </button>
                        <button id="excDonustur" type="button" class="btn btn-primary mr-2 mb-2">
                            Excel
                        </button>
                        <button id="pdfDonustur" type="button" class="btn btn-primary mb-2">
                            PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div id="container w-100 m-0 p-0">
                    <div class="row m-0 p-0 d-flex justify-content-end">
                        <h6>Cihaz Sayısı: <span id="cihazSayisi"></span></h6>
                        <h6>,&nbsp;</h6>
                        <h6>KDV\'siz Tutar: <span id="tutarToplam"></span> TL</h6>
                        <h6>,&nbsp;</h6>
                        <h6>KDV: <span id="kdvToplam"></span> TL</h6>
                        <h6>,&nbsp;</h6>
                        <h6>Genel Toplam: <span id="genelToplam"></span> TL</h6>
                    </div>
                </div>
            <table id="rapor_tablosu" class="table">
            <thead>
                <tr>
                    <th style="width:10% !important;">No</th>
                    <th style="width:10% !important;">Müşteri</th>
                    <th style="width:10% !important;">Marka</th>
                    <th style="width:10% !important;">Model</th>
                    <th style="width:10% !important;">Tür</th>
                    <th style="width:10% !important;">Giriş</th>
                    <th style="width:10% !important;">Çıkış</th>
                    <th style="width:10% !important;">Tutar (TL)</th>
                    <th style="width:10% !important;">KDV</th>
                    <th style="width:10% !important;">Genel Toplam (TL)</th>
                    <th style="width:10% !important;">Sorumlu</th>
                    <th style="width:10% !important;">Durum</th>
                </tr>
            </thead>
            <tbody>
                ';
$cihazlar = $this->Cihazlar_Model->cihazlar();
foreach ($cihazlar as $cihaz) {
    echo '<tr>';
    echo '<td>' . $cihaz->servis_no . '</td>';
    echo '<td>' . $cihaz->musteri_adi . '</td>';
    echo '<td>' . $cihaz->cihaz . '</td>';
    echo '<td>' . $cihaz->cihaz_modeli . '</td>';
    echo '<td>' . $cihaz->cihaz_turu . '</td>';
    echo '<td>' . $this->Islemler_Model->tarihDonusturSiralama($cihaz->tarih) . '</td>';
    echo '<td>' . $this->Islemler_Model->tarihDonusturSiralama($cihaz->cikis_tarihi) . '</td>';
    $toplam = 0;
    $kdv = 0;
    $genel_toplam = 0;
    if (count($cihaz->islemler) > 0) {
        foreach($cihaz->islemler as $islem){
            $toplam_islem_fiyati_suan =  $islem->miktar * $islem->birim_fiyat;
            $kdv_suan = $this->Islemler_Model->tutarGetir(($toplam_islem_fiyati_suan / 100) * $islem->kdv);
            $toplam = $toplam + $toplam_islem_fiyati_suan;
            $kdv = $kdv + $kdv_suan;
        }
    }
    echo '<td>' . $toplam . '</td>';
    echo '<td>' . $kdv . '</td>';
    echo '<td>' . ($toplam + $kdv) . '</td>';
    echo '<td>' . $cihaz->sorumlu . '</td>';
    $cDurum = $this->Cihazlar_Model->cihazDurumuBul($cihaz->guncel_durum);
    echo '<td>';
    if($cDurum->num_rows() > 0){
        echo $cDurum->result()[0]->durum;
    }else{
        echo "Belirtilmemiş";
    }
    echo '</td>';
    echo '</tr>';
}

echo '                  </tbody>
        </table>
            </div>
        </div>
    </section>
</div>';
