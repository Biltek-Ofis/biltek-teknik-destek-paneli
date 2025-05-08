<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Gerekli alanlar 
// $info["id"];
// $info["name"];
// 
//
// İsteğe Bağlı Alanlar
// $info["label"];
// $info["type"];
// $info["sifirla"];
// $info["placeholder"]
// $info["minlength"];
// $info["maxlength"];
// $info["value"];
// $info["required"]
// $info["ek"]
// $info["class"]
// $info["ekDiv"]

$info = isset($info) ? $info : array();

$type = "text";
if (isset($info["type"])) {
    $type = $info["type"];
}
$required = isset($info["required"]) ? $info["required"] : FALSE;
$ek = isset($info["ek"]) ? $info["ek"] : "";
$class = isset($info["class"]) ? " ".$info["class"] : "";
$ekDiv = isset($info["ekDiv"]) ? " ".$info["ekDiv"] : "";
?>
<div class="form-group<?= isset($info["sifirla"]) ? " p-0 m-0" : ""; ?> col">
    <?php
    if (isset($info["labe"])) {
        ?>
        <label for="<?= $info["id"]; ?>">
            <?= $info["label"]; ?>
        </label>
        <?php
    }
    ?>
    <input id="<?= $info["id"]; ?>" <?=$ek;?> autocomplete="<?= $this->Islemler_Model->rastgele_yazi(); ?>" class="form-control<?=$class;?>"
        type="<?= $type; ?>" <?= isset($info["placeholder"]) ? ' placeholder="' . $info["placeholder"] . '"' : ""; ?>
        name="<?= $info["name"]; ?>" <?= isset($info["minlength"]) ? ' minlength="' . $info["minlength"] . '"' : ""; ?>
        <?= isset($info["maxlength"]) ? ' maxlength="' . $info["maxlength"] . '"' : ""; ?>
        value="<?= isset($info["value"]) ? $info["value"] : ""; ?>" <?= $required ? " required" : ""; ?>>
        <?=$ekDiv;?>
</div>