<?php
// Gerekli alanlar 
// $info["id"];
// $info["name"];
// $info["label"];
// 
// İsteğe Bağlı Alanlar
// $info["sifirla"];
// $info["checked"];
// $info["required"]
$checked = isset($info["checked"]) ? $info["checked"] : FALSE;
$required = isset($info["required"]) ? $info["required"] : FALSE;
?>
<div class="form-check<?= isset($info["sifirla"]) ? " p-0 ml-3" : " ml-2"; ?>">
    <input id="<?= $info["id"]; ?>" name="<?= $info["name"]; ?>[]" class="form-check-input" type="checkbox" <?= $checked ? " checked" : ""; ?> <?= $required ? " required" : ""; ?>>
    <label class="form-check-label" for="<?= $info["id"]; ?>">
        <?= $info["label"]; ?>
    </label>
</div>