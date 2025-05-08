<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Gerekli alanlar 
// $info["id"];
// $info["name"];
// 
//
// İsteğe Bağlı Alanlar
// $info["label"];
// $info["sifirla"];
// $info["placeholder"]
// $info["value"];
// $info["required"]

$info = isset($info) ? $info : array();
$rows = isset($info["rows"]) ? $info["rows"] : "3";
$required = isset($info["required"]) ? $info["required"] : FALSE;
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
    <textarea id="<?= $info["id"]; ?>" autocomplete="<?= $this->Islemler_Model->rastgele_yazi(); ?>"
        name="<?= $info["name"]; ?>" class="form-control" rows="<?= $rows; ?>" <?= isset($info["placeholder"]) ? ' placeholder="' . $info["placeholder"] . '"' : ""; ?> <?= $required ? " required" : ""; ?>><?php
                                 if (isset($info["value"])) {
                                     echo $info["value"];
                                 }
                                 ?></textarea>
</div>