<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Gerekli alanlar 
// $info["id"];
// $info["name"];
// 
//
// İsteğe Bağlı Alanlar
// $info["sifirla"];
// $info["label"];
// $info["placeholder"];
// $info["required"];
// $info["disabled"];
// $info["options"]; (Array)
//      Gerekli
//          $info["options"][$i]["value"];
//          $info["options"][$i]["text"];
//      İsteğe Bağlı
//          $info["options"][$i]["selected"];

$info = isset($info) ? $info : array();
$required = isset($info["required"]) ? $info["required"] : FALSE;
$disabled = isset($info["disabled"]) ? $info["disabled"] : FALSE;
?>
<div class="form-group<?= isset($info["sifirla"]) ? " p-0 m-0" : ""; ?> col">
    <?php
    if (isset($info["label"])) {
        ?>
        <label for="<?= $info["id"]; ?>">
            <?= $info["label"]; ?>
        </label>
        <?php
    }
    ?>
    <select id="<?= $info["id"]; ?>" class="form-control" name="<?= $info["name"]; ?>" <?= isset($info["placeholder"]) ? ' aria-label="' . $info["placeholder"] . '"' : ""; ?> <?= $required ? " required" : ""; ?> <?= $disabled ? " disabled" : ""; ?>>
        <?php
        if (isset($info["options"])) {
            for ($i = 0; $i < count($info["options"]); $i++) {
                $option = $info["options"][$i];
                ?>
                <option value="<?= $option["value"]; ?>" <?= isset($option["selected"]) ? ($option["selected"] ? " selected" : "") : ""; ?>><?= $option["text"]; ?></option>
                <?php
            }
        }
        ?>
    </select>
</div>