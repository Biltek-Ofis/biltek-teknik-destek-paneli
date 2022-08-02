<style>
    .resim<?=$id;?> img {
        display: inline-block;
        width: 220px;
        height: 220px;
        background-size: cover;
        background-position: 50% 50%;
        margin-left: 8px;
        margin-right: 8px;
        margin-bottom: 16px;
    }
</style>
<!--<script src="<?= base_url("dist/js/medya.js"); ?>"></script>-->
<div class="row text-center">
    <?php
    $medyalar = $this->Cihazlar_Model->medyalar($id);
    foreach ($medyalar as $medya) {
    ?>
        <div class="col-12">
            <?php
            if ($medya->tur == "video") {
            ?>
                <video width="320" height="240" controls>
                    <source src="<?= base_url($medya->konum); ?>" type="video/mp4">
                    Tarayıcınız video oynatmayı desteklemiyor.
                </video>
            <?php
            } else {
            ?>
                <div class="resim<?=$id;?>" data-image="<?= base_url($medya->konum); ?>">
                    <a href="<?= base_url($medya->konum); ?>" target="_blank"><img src="<?= base_url($medya->konum); ?>" /></a>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>
</div>
<script>
    //window.onload = function() {
    //    var elements = document.querySelectorAll('.resim<?=$id;?>');
    //    Intense(elements);
    //}
</script>