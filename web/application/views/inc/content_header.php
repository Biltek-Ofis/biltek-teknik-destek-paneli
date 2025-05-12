<section class="content-header py-4">
    <div class="container-fluid">
        <div class="row mb-2 w-100">
            <div class="col-sm-6">
                <h2 class="text-secondary"><?= $contentHeader["baslik"]; ?></h2>
            </div>
            <div class="col-sm-6 text-end">
                <ol class="breadcrumb float-sm-end">
                    <?php
                    foreach ($contentHeader["items"] as $item) {
                        ?>
                        <li class="breadcrumb-item<?= (isset($item["active"]) && $item["active"]) ? " active" : ""; ?>">
                            <?php
                            if (isset($item["link"])) {
                                ?>
                                <a href="<?= $item["link"]; ?>"><?= $item["text"]; ?></a>
                                <?php
                            } else {
                                ?>
                                <?= $item["text"]; ?>
                                <?php
                            }
                            ?>
                        </li>
                        <?php
                    }
                    ?>
                </ol>
            </div>
        </div>
    </div>
</section>