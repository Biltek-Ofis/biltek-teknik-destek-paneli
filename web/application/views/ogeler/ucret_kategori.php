<?php
if ($this->Giris_Model->kullaniciGiris()) {
    ?>
    <div class="col<?php
if (isset($sifirla)) {
    echo " p-0 m-0";
}
?>">
        <select id="kategori<?= isset($id) ? $id: ""?>" class="form-select" name="cat_id" aria-label="Kategori" required>
            <option value="">Kategori Seçin *</option>
            <?php
            foreach ($this->Ucretler_Model->kategoriler() as $kategori) {

                ?>
                <option value="<?= $kategori->id; ?>"<?= (isset($kategori_value) && $kategori_value == $kategori->id ? " selected": "")?>><?= $kategori->isim; ?></option>
                <?php
            }
            ?>
            <option value="<?=DIGER_ID;?>"<?= (isset($kategori_value) && $kategori_value == DIGER_ID ? " selected": "")?>>DİĞER</option>
        </select>
    </div>
    <?php
}
?>