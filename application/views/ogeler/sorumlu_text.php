<?php
$kullaniciBilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
echo '<input id="sorumlu" type="hidden" name="sorumlu" value="' . (isset($sorumlu_text_value) ? $sorumlu_text_value : ($kullaniciBilgileri["id"] != "" ? $kullaniciBilgileri["id"] : "0")) . '">';
