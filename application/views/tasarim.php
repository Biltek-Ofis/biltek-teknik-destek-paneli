<?php
echo '<!DOCTYPE html>
<html lang="en">

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
echo '</head>

<body class="sidebar-mini layout-fixed sidebar-collapse"> <!--sidebar-collapse-->
  <div class="wrapper">';
$this->load->view("inc/navbar");


$this->load->view("inc/aside", array("aktifSayfa" => $icerik, "baslik" => $baslik, "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri()));


$this->load->view("icerikler/" . $icerik, $icerik_array);

//$this->load->view("inc/footer");
echo '</div>

</body>

</html>';
