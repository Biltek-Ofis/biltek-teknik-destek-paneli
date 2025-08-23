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
    $konum = $medya->konum;
    if($medya->yerel == 1){
        $konum = base_url($medya->konum);
    }
    echo '<div id="medyaGoster'.$medya->id.'" class="col-12 medyaGoster">';
    if ($medya->tur == "video") {
        echo '<div class="medya col-12 mb-2" data-image="' . $konum . '">
                <video controls>
                    <source src="' . $konum . '" type="video/mp4">
                    Tarayıcınız video oynatmayı desteklemiyor.
                </video>
            </div>';
    } else {

        echo '<div class="medya col-12 mb-2" data-image="' . $konum . '">
                <a href="' . $konum . '" target="_blank"><img src="' . $konum . '" /></a>
            </div>';
    }
    if (isset($silButonu) && $silButonu) {
        echo '<div class="col-12 mb-2">
                <!--<a href="' . base_url("cihaz/medyaSil/" . $id . "/"  . $medya->id) . '" class="btn btn-danger">Sil</a>-->
                <button onclick="$(\'#medyaSilOnayBtn\').attr(\'onclick\',\'medyaSil('.$id.', '.$medya->id.', function(){loglariGetir(' . $medya->cihaz_id . ');});\');$(\'#medyaSilModal\').modal(\'show\');" class="btn btn-danger">Sil</button>
            </div>';
    }

    echo '</div>';
}
echo '<div id="medyaYok" class="col-12 text-center" style="'.((count($medyalar) > 0) ? "display:none;":"").'">Şuanda eklenmiş herhangi bir medya yok.</div>';

echo '</div>
<script>
    //window.onload = function() {
    //    var elements = document.querySelectorAll(\'.resim\');
    //    Intense(elements);
    //}
</script>';
