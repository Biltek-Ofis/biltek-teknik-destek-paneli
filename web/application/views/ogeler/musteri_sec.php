<?php
if ($this->Giris_Model->kullaniciGiris()) {
    ?>
    <div class="col<?php
if (isset($sifirla)) {
    echo " p-0 m-0";
}
?>">
        <select id="musteri" class="form-select" name="musteri" aria-label="Müşteri" required>
            <option value="">Müşteri Seçin *</option>
            <?php
            foreach ($this->Kullanicilar_Model->kullanicilar(array("musteri" => 1)) as $kullanici) {

                ?>
                <option value="<?= $kullanici->id; ?>"><?= $kullanici->ad_soyad; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <?php
}
?>