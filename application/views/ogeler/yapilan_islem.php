<tr>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslem<?=$index;?>" name="islem<?=$index;?>" class="form-control" type="text" placeholder="İşlem" value="<?= isset($yapilanIslemArr[$index]) ? $yapilanIslemArr[$index]->islem : ""; ?>">
        </div>
    </td>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslemMiktar<?=$index;?>" name="miktar<?=$index;?>" class="form-control" type="number" placeholder="Miktar" value="<?= isset($yapilanIslemArr[$index]) ? $yapilanIslemArr[$index]->miktar : ""; ?>"<?= isset($yapilanIslemArr[$index]) ? " required" : "";?>>
        </div>
    </td>
    <td>
        <div class="form-group p-0 m-0 col">
            <input id="yapilanIslemFiyat<?=$index;?>" name="birim_fiyati<?=$index;?>" class="form-control" type="number" placeholder="Birim Fiyatı" value="<?= isset($yapilanIslemArr[$index]) ? $yapilanIslemArr[$index]->birim_fiyati : ""; ?>"<?= isset($yapilanIslemArr[$index]) ? " required" : "";?>>
        </div>
    </td>
    <td id="yapilanIslemTutar<?=$index;?>">
        <?= isset($yapilanIslemArr[$index]) ? $yapilanIslemArr[$index]->miktar * $yapilanIslemArr[$index]->birim_fiyati . " TL" : ""; ?>
    </td>
</tr>