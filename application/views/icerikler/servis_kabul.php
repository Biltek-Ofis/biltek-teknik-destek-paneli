<?php
echo '<!DOCTYPE html>
<html lang="en">

<head>';
$this->load->view("inc/meta");

echo '<title>SERVİS KABUL FORMU ' . $cihaz->id . '</title>';

$this->load->view("inc/styles");
$this->load->view("inc/scripts");
$this->load->view("inc/style_yazdir");
$this->load->view("inc/style_yazdir_tablo");
echo '<style>';
echo 'body{
        font-size:13px !important;
    }';
echo '</style>';
echo '</head>';

echo '<body onafterprint="self.close()">
    <div class="dondur">
        <div class="row">
            ';
$this->load->view("icerikler/servis_kabul_tablo", array("cihaz" => $cihaz));
echo '<div class="col-2"></div>';
$this->load->view("icerikler/servis_kabul_tablo", array("cihaz" => $cihaz));
echo '</div>
    </div>
</body>

</html>';
