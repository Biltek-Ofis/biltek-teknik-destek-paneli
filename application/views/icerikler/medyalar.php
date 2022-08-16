<?php
echo '<style>
    .medya img,
    .medya video {
        display: inline-block;
        position: relative;
        max-width: 400px;
        height: auto;
        padding: 0px;
        margin: 0px;
    }
</style>
<!--<script src="' . base_url("dist/js/medya.min.js") . '"></script>-->
<div class="row text-center">';

$medyalar = $this->Cihazlar_Model->medyalar($id);
foreach ($medyalar as $medya) {
    echo '<div class="col-12">';
    if ($medya->tur == "video") {
        echo '<div class="medya col-12 mb-2" data-image="' . base_url($medya->konum) . '">
                <video controls>
                    <source src="' . base_url($medya->konum) . '" type="video/mp4">
                    Tarayıcınız video oynatmayı desteklemiyor.
                </video>
            </div>';
    } else {

        echo '<div class="medya col-12 mb-2" data-image="' . base_url($medya->konum) . '">
                <a href="' . base_url($medya->konum) . '" target="_blank"><img src="' . base_url($medya->konum) . '" /></a>
            </div>';
    }
    if (isset($silButonu) && $silButonu) {
        echo '<div class="col-12 mb-2">
                <a href="' . base_url("cihaz/medyaSil/" . $id . "/"  . $medya->id) . '" class="btn btn-danger">Sil</a>
            </div>';
    }

    echo '</div>';
}

echo '</div>
<script>
    //window.onload = function() {
    //    var elements = document.querySelectorAll(\'.resim\');
    //    Intense(elements);
    //}
</script>';
