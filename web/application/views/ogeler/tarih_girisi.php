<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <label class="form-label" for="tarih_girisi">Giriş Tarihi:</label>
    <select id="tarih_girisi" class="form-select" name="tarih_girisi" aria-label="Tarih Girişi">
        <option value="oto" selected>Otomatik (Güncel Tarih)</option>
        <option value="el">El ile Giriş</option>
    </select>
</div>';