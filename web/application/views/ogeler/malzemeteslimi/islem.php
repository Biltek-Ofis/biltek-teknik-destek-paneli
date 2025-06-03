<script>
    $(document).ready(function () {
        $("#yapilanIslemAdet<?=$id."_".$index;?>, #yapilanIslemFiyat<?=$id."_".$index;?>, #yapilanIslemKdv<?=$id."_".$index;?>").on("input", function () {
            var tutar = tutarHesapla(
                $("#yapilanIslemAdet<?=$id."_".$index;?>").val(),
                $("#yapilanIslemFiyat<?=$id."_".$index;?>").val(),
                $("#yapilanIslemKdv<?=$id."_".$index;?>").val(),
            );
            $("#yapilanIslemTopKdv<?=$id."_".$index;?>").html(tutar.kdv);
            $("#yapilanIslemTutar<?=$id."_".$index;?>").html(tutar.tutar);
            $("#yapilanIslemToplam<?=$id."_".$index;?>").html(tutar.toplam);
        });
    });
</script>

<tr id="yapilamIslemRow<?=$id."_".$index;?>">
    <td><?=$index;?></td>
    <td>
        <div class="p-0 m-0 col">
            <input id="yapilanIslem<?=$id."_".$index;?>" autocomplete="wulxasfhvqpreefn" name="islem<?=$index;?>" class="form-control" type="text"
                placeholder="İşlem" value="">
        </div>
    </td>
    <td>
        <div class="p-0 m-0 col">
            <input id="yapilanIslemAdet<?=$id."_".$index;?>" autocomplete="nnhbusqedgxpwlqd" name="adet<?=$index;?>" class="form-control"
                type="number" placeholder="Adet" value="">
        </div>
    </td>
    <td>
        <div class="p-0 m-0 col">
            <input id="yapilanIslemFiyat<?=$id."_".$index;?>" autocomplete="ylzpnhgiamqsgskb" name="birim_fiyati<?=$index;?>" class="form-control"
                type="number" placeholder="Birim Fiyatı" value="" step="0.01">
        </div>
    </td>
    <td>
        <div class="p-0 m-0 col">
            <input id="yapilanIslemKdv<?=$id."_".$index;?>" autocomplete="bolaeidvaifvhtzj" name="kdv_<?=$index;?>" class="form-control" type="number"
                placeholder="KDV Oranı" step=".01">
        </div>
    </td>
    <td id="yapilanIslemTopKdv<?=$id."_".$index;?>"></td>
    <td id="yapilanIslemTutar<?=$id."_".$index;?>"></td>
    <td id="yapilanIslemToplam<?=$id."_".$index;?>"></td>
</tr>