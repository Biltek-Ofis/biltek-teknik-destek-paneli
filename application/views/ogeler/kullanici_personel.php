<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <label for="kullanici_yonetici<?php if (isset($id)) {
                                        echo $id;
                                    } ?>">Hesap Türü</label>
    <select id="kullanici_yonetici<?php if (isset($id)) {
                                        echo $id;
                                    } ?>" class="form-control" name="yonetici" aria-label="Yönetici">
        <option value="0" <?php if (isset($value) && $value == 0) {
                                echo " selected";
                            } ?>>Personel</option>
        <option value="1" <?php if (isset($value) && $value == 1) {
                                echo " selected";
                            } ?>>Kullanıcı</option>
    </select>
</div>