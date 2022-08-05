<tr>
    <td id="stokKodText<?= $index; ?>"><?= isset($yapilanIslemArr["stok_kod"]) ? $yapilanIslemArr["stok_kod"] : "Yok"; ?></td>
    <td>
        <input id="yapilanIslemStokKod<?= $index; ?>" autocomplete="off" name="stok_kod<?= $index; ?>" type="hidden" value="<?= isset($yapilanIslemArr["stok_kod"]) ? $yapilanIslemArr["stok_kod"] : ""; ?>">
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslem<?= $index; ?>" autocomplete="off" name="islem<?= $index; ?>" class="form-control" type="text" placeholder="İşlem" value="<?= isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["islem"] : ""; ?>">

            <ul id="stok_liste_<?= $index; ?>" class="typeahead dropdown-menu col" style="max-height: 300px; overflow-y: auto;display:none;" role="listbox">

            </ul>
        </div>
    </td>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslemMiktar<?= $index; ?>" autocomplete="off" name="miktar<?= $index; ?>" class="form-control" type="number" placeholder="Miktar" value="<?= isset($yapilanIslemArr["miktar"]) && isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["miktar"] : ""; ?>" <?= isset($yapilanIslemArr["islem"]) ? " required" : ""; ?>>
        </div>
    </td>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslemFiyat<?= $index; ?>" autocomplete="off" name="birim_fiyati<?= $index; ?>" class="form-control" type="number" placeholder="Birim Fiyatı" value="<?= isset($yapilanIslemArr["birim_fiyati"])  && isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["birim_fiyati"] : ""; ?>" step="0.01" <?= isset($yapilanIslemArr["islem"]) ? " required" : ""; ?>>
        </div>
    </td>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslemKdv<?= $index; ?>" autocomplete="off" name="kdv_<?= $index; ?>" class="form-control" type="number" placeholder="KDV Oranı" value="<?= isset($yapilanIslemArr["kdv"]) && isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["kdv"] : 0; ?>" step=".01" required>
        </div>
    </td>
    <td id="yapilanIslemTutar<?= $index; ?>">
        <?= (isset($yapilanIslemArr["miktar"]) && isset($yapilanIslemArr["birim_fiyati"])) ? $yapilanIslemArr["miktar"] * $yapilanIslemArr["birim_fiyati"] . " TL" : ""; ?>
    </td>
    <td id="yapilanIslemTopKdv<?= $index; ?>">
        <?= (isset($yapilanIslemArr["miktar"]) && isset($yapilanIslemArr["birim_fiyati"]) && isset($yapilanIslemArr["kdv"])) ? ceil((($yapilanIslemArr["miktar"] * $yapilanIslemArr["birim_fiyati"]) / 100) * $yapilanIslemArr["kdv"]) . " TL (" . $yapilanIslemArr["kdv"] . "%)" : ""; ?>
    </td>
</tr>