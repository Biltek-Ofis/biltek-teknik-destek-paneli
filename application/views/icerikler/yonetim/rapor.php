<?php
$this->load->view("inc/datatables_scripts");
$this->load->view("inc/style_tablo");
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
            var yilInput = "#yil";
            var girisTarihiInput1 = "#giris_tarihi_baslangic_ara";
            var girisTarihiInput2 = "#giris_tarihi_bitis_ara";
            var girisTarBas, girisTarBit;
            var sayfaSayisiUstInput = "#sayfa_sayisi_ust";
            var sayfaSayisiUstGoster = false;
            var sayfaSayisiAltInput = "#sayfa_sayisi_alt";
            var sayfaSayisiAltGoster = false;
            var sayfaSayisiSelect = "#sayfaSayisiKonumu";
            var sayfaSayisiKonumu = "1";
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
            function baslik(){
                var bugun = new Date();
                bugun.setDate(bugun.getDate() + 20);
                return "' . SITE_BASLIGI . ' Teknik Servis Raporu - " + bugun.getFullYear() + "/"
                + ("0" + bugun.getMonth()).slice(-2) + "/"
                + ("0" + bugun.getDate()).slice(-2) + " " + ("0" + (bugun.getHours())).slice(-2) + ":" + ("0" + (bugun.getMinutes())).slice(-2);
            }
            $(document).ready(function() {
                var customize = function ( doc ) {
                    if(sayfaSayisiUstGoster){
                        doc["header"] = (function(page, pages) {
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
                    
                    if(sayfaSayisiAltGoster){
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
                var cihazlarTablosu = $("#" + tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari([0, "desc"], 'true', '
                "buttons": [{
                    extend: "copyHtml5",
                    title: baslik(),
                    pageSize: "LEGAL",
                    title: baslik(),
                    customize: customize,
                }, {
                    extend: "csv",
                    title: baslik(),
                    pageSize: "LEGAL",
                    title: baslik(),
                    customize: customize,
                }, {
                    extend: "excel",
                    title: baslik(),
                    pageSize: "LEGAL",
                    title: baslik(),
                    customize: customize,
                }, {
                    extend: "pdfHtml5",
                    orientation: "landscape",
                    pageSize: "LEGAL",
                    title: baslik(),
                    customize: customize,
                }, {
                    extend: "print",
                    pageSize: "LEGAL",
                    title: baslik(),
                    customize: customize,
                }],', 'setTimeout(function(){cihazlarTablosu.buttons().container().appendTo("#" + tabloDiv + "_wrapper .col-md-6:eq(0)");}, 10);') . ');
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
                $(musteriInput + ", " + cihazMarkaInput + ", " + cihazModelInput + ", " + girisTarihiInput1 + ", " + girisTarihiInput2 + ", " + yilInput + ", " + cihazTuruInput).on("keyup change", function(){
                    cihazlarTablosu.draw();
                });
                $(sayfaSayisiUstInput).change(function() {
                    if(this.checked) {
                        sayfaSayisiUstGoster = true;
                    }else{
                        sayfaSayisiUstGoster = false;
                    } 
                });
                $(sayfaSayisiAltInput).change(function() {
                    if(this.checked) {
                        sayfaSayisiAltGoster = true;
                    }else{
                        sayfaSayisiAltGoster = false;
                    } 
                });
                $(sayfaSayisiSelect).change(function() {
                    sayfaSayisiKonumu = $(this).val();
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
                    <td class="p-1 m-0" colspan="2">
                        <div class="form-group form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="sayfa_sayisi_ust">
                            <label class="form-check-label" for="sayfa_sayisi_ust">Üstte Sayfa Sayısını Göster</label>
                        </div>
                    </td>
                    <td class="p-1 m-0" colspan="2"> 
                        <div class="form-group form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="sayfa_sayisi_alt">
                            <label class="form-check-label" for="sayfa_sayisi_alt">Altta Sayfa Sayısını Altta Göster</label>
                        </div>
                    </td>
                    <td class="p-1 m-0" colspan="2">
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
            </tbody>
        </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
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
    echo '<td>' . $cihaz->sorumlu . '</td>';
    echo '<td>' . $this->Islemler_Model->cihazDurumu($cihaz->guncel_durum) . '</td>';
    echo '</tr>';
}

echo '                  </tbody>
        </table>
            </div>
        </div>
    </section>
</div>';
