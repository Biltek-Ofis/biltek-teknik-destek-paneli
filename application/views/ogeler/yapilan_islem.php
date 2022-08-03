<tr>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslem<?= $index; ?>" autocomplete="off" name="islem<?= $index; ?>" class="form-control" type="text" placeholder="İşlem" value="<?= isset($yapilanIslemArr["islem"]) ? $yapilanIslemArr["islem"] : ""; ?>">
        </div>
    </td>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslemMiktar<?= $index; ?>" autocomplete="off" name="miktar<?= $index; ?>" class="form-control" type="number" placeholder="Miktar" value="<?= isset($yapilanIslemArr["miktar"]) ? $yapilanIslemArr["miktar"] : ""; ?>" <?= isset($yapilanIslemArr["islem"]) ? " required" : ""; ?>>
        </div>
    </td>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslemFiyat<?= $index; ?>" autocomplete="off" name="birim_fiyati<?= $index; ?>" class="form-control" type="number" placeholder="Birim Fiyatı" value="<?= isset($yapilanIslemArr["birim_fiyati"]) ? $yapilanIslemArr["birim_fiyati"] : ""; ?>" <?= isset($yapilanIslemArr["islem"]) ? " required" : ""; ?>>
        </div>
    </td>
    <td id="yapilanIslemTutar<?= $index; ?>">
        <?= (isset($yapilanIslemArr["miktar"]) && isset($yapilanIslemArr["birim_fiyati"])) ? $yapilanIslemArr["miktar"] * $yapilanIslemArr["birim_fiyati"] . " TL" : ""; ?>
    </td>
</tr>