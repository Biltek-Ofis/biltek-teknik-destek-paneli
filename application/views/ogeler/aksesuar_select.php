<div class="row mt-2">
    <div class="form-group col">
        <select class="form-control" name="<?= $id; ?>" aria-label="<?= $isim; ?> Hasar Durumu">
            <option value="0" selected><?= $isim; ?> Hasar Durumu</option>
            <option value="1"><?= $this->Islemler_Model->hasarDurumu(1); ?></option>
            <option value="2"><?= $this->Islemler_Model->hasarDurumu(2); ?></option>
        </select>
    </div>
</div>