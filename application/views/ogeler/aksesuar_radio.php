<div class="row">
    <h9 class="col"><?= $isim; ?></h9>
    <div class="form-check form-check-inline col-2">
        <input class="form-check-input" type="radio" name="<?= $id; ?>" id="<?= $id; ?>1" value="1" checked>
        <label class="form-check-label col-12" for="<?= $id; ?>1"><?=$this->Islemler_Model->hasarDurumu(1);?></label>
    </div>
    <div class="form-check form-check-inline col-2">
        <input class="form-check-input" type="radio" name="<?= $id; ?>" id="<?= $id; ?>2" value="2">
        <label class="form-check-label col-12" for="<?= $id; ?>2"><?=$this->Islemler_Model->hasarDurumu(2);?></label>
    </div>
    <div class="form-check form-check-inline col-2">
        <input class="form-check-input" type="radio" name="<?= $id; ?>" id="<?= $id; ?>3" value="3">
        <label class="form-check-label col-12" for="<?= $id; ?>3"><?=$this->Islemler_Model->hasarDurumu(3);?></label>
    </div>
</div>