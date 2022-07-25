<div class="row">
    <h9 class="col"><?= $isim; ?></h9>
    <div class="form-check form-check-inline col-2">
        <input class="form-check-input" type="radio" name="<?= $id; ?>" id="<?= $id; ?>1" value="Yok" checked>
        <label class="form-check-label col-12" for="<?= $id; ?>1">Yok</label>
    </div>
    <div class="form-check form-check-inline col-2">
        <input class="form-check-input" type="radio" name="<?= $id; ?>" id="<?= $id; ?>2" value="Hasarlı">
        <label class="form-check-label col-12" for="<?= $id; ?>2">Hasarlı</label>
    </div>
    <div class="form-check form-check-inline col-2">
        <input class="form-check-input" type="radio" name="<?= $id; ?>" id="<?= $id; ?>3" value="Hasarsız">
        <label class="form-check-label col-12" for="<?= $id; ?>3">Hasarsız</label>
    </div>
</div>