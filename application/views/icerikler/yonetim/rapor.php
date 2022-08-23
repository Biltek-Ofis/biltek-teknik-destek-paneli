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
            var girisTarihiInput1 = "#giris_tarihi_baslangic_ara";
            var girisTarihiInput2 = "#giris_tarihi_bitis_ara";
            var girisTarBas, girisTarBit;
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
            $(document).ready(function() {
                var cihazlarTablosu = $("#" + tabloDiv).DataTable(' . $this->Islemler_Model->datatablesAyarlari([0, "desc"]) . ');
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
                $(musteriInput + ", " + cihazMarkaInput + ", " + cihazModelInput + ", " + girisTarihiInput1 + ", " + girisTarihiInput2).on("keyup change", function(){
                    cihazlarTablosu.draw();
                });
            });
            </script>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <label for="db_anasayfa">Müşteri</label>
                                    <input id="musteri_ara" type="text" class="form-control" placeholder="Müşteri Adı">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="cihaz_marka_ara">Cihaz Markası</label>
                                    <input id="cihaz_marka_ara" type="text" class="form-control" placeholder="Cihaz Markası">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="cihaz_model_ara">Modeli</label>
                                    <input id="cihaz_model_ara" type="text" class="form-control" placeholder="Cihaz Modeli">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="giris_tarihi_baslangic_ara">Giriş Tarihi Başlangıç</label>
                                    <input id="giris_tarihi_baslangic_ara" type="text" class="form-control" placeholder="Giriş Tarihi Başlangıç">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="giris_tarihi_bitis_ara">Bitiş</label>
                                    <input id="giris_tarihi_bitis_ara" type="text" class="form-control" placeholder="Giriş Tarihi Bitiş">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table id="rapor_tablosu" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Müşteri</th>
                            <th>Marka</th>
                            <th>Model</th>
                            <th>Tür</th>
                            <th>Giriş</th>
                            <th>Çıkış</th>
                            <th>Sorumlu</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        ';
$cihazlar = $this->Cihazlar_Model->cihazlar();
foreach ($cihazlar as $cihaz) {
    echo '<tr class="' . $this->Islemler_Model->cihazDurumuClass($cihaz->guncel_durum) . '">';
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
