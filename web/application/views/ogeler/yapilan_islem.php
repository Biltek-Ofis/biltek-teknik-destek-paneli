<?php
echo '<tr id="yapilamIslemRow'.$index.'">
    <td>' . $index . '</td>
    <!--<td id="stokKodText' . $index . '">' . (isset($yapilanIslemArr["stok_kod"]) ? $yapilanIslemArr["stok_kod"] : "Yok") . '</td>-->
    <td>
        <input id="yapilanIslemStokKod' . $index . '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="stok_kod' . $index . '" type="hidden" value="' . (isset($yapilanIslemArr["stok_kod"]) ? $yapilanIslemArr["stok_kod"] : "") . '">
        <div class="p-0 m-0 col">
            <input id="yapilanIslem' . $index . '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="islem' . $index . '" class="form-control" type="text" placeholder="İşlem" value="' . (isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["islem"] : "") . '">

            <ul id="stok_liste_' . $index . '" class="typeahead dropdown-menu col" style="max-height: 300px; overflow-y: auto;display:none;" role="listbox">

            </ul>
        </div>
    </td>
    <td>
        <div class="p-0 m-0 col">
            <input id="yapilanIslemMiktar' . $index . '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="miktar' . $index . '" class="form-control" type="number" placeholder="Miktar" value="' . (isset($yapilanIslemArr["miktar"]) && isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["miktar"] : "") . '"' . (isset($yapilanIslemArr["islem"]) ? " required" : "") . '>
        </div>
    </td>
    <td>
        <div class="p-0 m-0 col">
            <input id="yapilanIslemFiyat' . $index . '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="birim_fiyati' . $index . '" class="form-control" type="number" placeholder="Birim Fiyatı" value="' . (isset($yapilanIslemArr["birim_fiyati"])  && isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["birim_fiyati"] : "") . '" step="0.01"' . (isset($yapilanIslemArr["islem"]) ? " required" : "") . '>
        </div>
    </td>
    <td>
        <div class="p-0 m-0 col">
            <input id="yapilanIslemKdv' . $index . '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="kdv_' . $index . '" class="form-control" type="number" placeholder="KDV Oranı" value="' . (isset($yapilanIslemArr["kdv"]) && isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["kdv"] : 0) . '" step=".01" required>
        </div>
    </td>';
    if(isset($yapilanIslemArr["miktar"]) && isset($yapilanIslemArr["birim_fiyati"]) && isset($yapilanIslemArr["kdv"])){
        $yapilanIslemKDV = $this->Islemler_Model->tutarGetir((($yapilanIslemArr["miktar"] * $yapilanIslemArr["birim_fiyati"]) / 100) * $yapilanIslemArr["kdv"]);
    }else{
        $yapilanIslemKDV = NULL;
    }
    if (isset($yapilanIslemArr["miktar"]) && isset($yapilanIslemArr["birim_fiyati"])){
        $yapilanIslemTutar = ($yapilanIslemArr["miktar"] * $yapilanIslemArr["birim_fiyati"]);
    }else{
        $yapilanIslemTutar = NULL;
    }
echo '   
    <td id="yapilanIslemTopKdv' . $index . '">
        ' . (($yapilanIslemKDV != NULL) ? $yapilanIslemKDV . " TL (" . $yapilanIslemArr["kdv"] . "%)" : "") . '
    </td>
    <td id="yapilanIslemTutar' . $index . '">
        ' . (($yapilanIslemTutar != NULL) ? $yapilanIslemTutar . " TL" : "") . '
    </td>
    <td id="yapilanIslemToplam' . $index . '">
        ' . (($yapilanIslemTutar != NULL && $yapilanIslemKDV != NULL) ? $yapilanIslemTutar + $yapilanIslemKDV . " TL" : "") . '
    </td>
</tr>';
