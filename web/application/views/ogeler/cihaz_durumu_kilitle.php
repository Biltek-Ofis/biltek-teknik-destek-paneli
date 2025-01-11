<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo ' col">
    <label for="kilitle';
if (isset($id)) {
    echo $id;
}
echo '">Cihaz bu durumdayken düzenleme kilitlensin mi?</label>
    <select id="kilitle';
if (isset($id)) {
    echo $id;
}
echo '" class="form-control" name="kilitle" aria-label="Cihaz bu durumdayken düzenleme kilitlensin mi?" required>
        <option value="1"';
if (isset($cihaz_durumu_kilitle_value) && $cihaz_durumu_kilitle_value == 1) {
    echo " selected";
}
echo '>Evet</option>
        <option value="0"';
if (isset($cihaz_durumu_kilitle_value) && $cihaz_durumu_kilitle_value == 0) {
    echo " selected";
}else if(!isset($cihaz_durumu_kilitle_value)) {
    echo " selected";
}
echo '>Hayır</option>
    </select>
</div>';
