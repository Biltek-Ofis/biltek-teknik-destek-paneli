<?php
if (!isset($not_label)) {
    $not_label = FALSE;
}
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">';
if ($not_label) {
    echo '<label class="form-label" for="not">Not (*):</label>';
}
echo '
    <textarea id="not';
if (isset($id)) {
    echo $id;
}
echo '" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="aciklama" class="form-control" rows="3" placeholder="Not *" required'.(isset($not_readonly) ? ($not_readonly ? " readonly" : "") : "").'>';
if (isset($not_value)) {
    echo $not_value;
}
echo '</textarea>
</div>';
