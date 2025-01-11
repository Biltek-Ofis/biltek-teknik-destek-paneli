<?php
if ($this->agent->browser() != "Chrome"){
    echo '<div class="alert alert-danger text-center" role="alert">Desteklenen bir tarayıcı kullanmıyorsunuz. Lütfen en iyi deneyim için <span class="font-weight-bold">"Chrome"</span> veya <span class="font-weight-bold">"Microsoft Edge"</span> tarayıcılarını kullanın.</div>';
}
?>