<?php
$kullaniciBilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();

?>
<input id="sorumlu" type="hidden" name="sorumlu" value="<?= isset($sorumlu_text_value) ? $sorumlu_text_value : ($kullaniciBilgileri["id"] != "" ? $kullaniciBilgileri["id"] : "0"); ?>">