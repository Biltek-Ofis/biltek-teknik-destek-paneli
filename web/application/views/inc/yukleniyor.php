
<script>
    /*$(document).ready(function () {
        var pr = 0;
        setInterval(function () {
            pr++;
            $("#percentagePath").attr("stroke-dasharray", pr + ", 100");
            $("#percentageText").html(pr + "%");
        }, 1000);
    });*/
</script>
<div id="yukleniyorDaire" class="flex-wrapper">
    <div class="yukleniyorDaire"></div>
    <?php
    if (isset($yukleniyor_mesaj)) {
        ?>
        <h3 class="yukleniyorMesaj"><?= $yukleniyor_mesaj; ?></h3>
        <?php
    }
    ?>
</div>