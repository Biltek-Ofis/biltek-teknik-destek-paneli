<style>
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }


    @-webkit-keyframes rotate {
        from {
            -webkit-transform: rotate(0deg);
        }

        to {
            -webkit-transform: rotate(360deg);
        }
    }

    .yukleniyorDaire {
        width: 100px;
        height: 100px;
        /* margin: 110px auto 0;*/
        margin: auto;
        border: solid 10px gray;
        border-radius: 50%;
        border-right-color: transparent;
        border-bottom-color: transparent;
        -webkit-transition: all 0.5s ease-in;
        -webkit-animation-name: rotate;
        -webkit-animation-duration: 1.0s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: linear;

        transition: all 0.5s ease-in;
        animation-name: rotate;
        animation-duration: 1.0s;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }
    .yukleniyorMesaj{
        width:100%;
        text-align: center;
        margin: auto;
        margin-top: 50px;
    }
</style>
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