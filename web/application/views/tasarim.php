<?php
echo '<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>';
$this->load->view("inc/meta");
$ayarlar = $this->Ayarlar_Model->getir();
echo '<title>' . $baslik . '' . (isset($ayarlar->site_basligi) ? " - " . $ayarlar->site_basligi : "") . '</title>';

if ($ek_css != "") {
  $this->load->view($ek_css);
}
$this->load->view("inc/styles");
echo '<script>
  var base_url = "' . base_url() . '";
</script>';
$this->load->view("inc/scripts");
$this->load->view("inc/style_tablo");
$this->load->view("inc/styles_important");
echo '</head>

<body class="layout-top-nav"> <!--sidebar-collapse-->
  <div class="wrapper">';
$bilgiler =  array("aktifSayfa" => $icerik, "baslik" => $baslik, "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri());
$this->load->view("inc/navbar", $bilgiler);

$this->load->view("icerikler/" . $icerik, $icerik_array);

//$this->load->view("inc/footer");
echo '</div>

</body>

</html>';
