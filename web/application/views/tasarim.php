<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  $this->load->view("inc/meta");
  $ayarlar = $this->Ayarlar_Model->getir();
  ?>
  <title><?= $baslik; ?><?= isset($ayarlar->site_basligi) ? " - " . $ayarlar->site_basligi : ""; ?></title>
  <?php
  if ($ek_css != "") {
    $this->load->view($ek_css);
  }
  $this->load->view("inc/styles");
  ?>
  <script>
    var base_url = "<?= base_url(); ?>";
  </script>
  <?php
  $this->load->view("inc/scripts");
  ?>
</head>
<body class="layout-top-nav"> <!--sidebar-collapse-->
  <div class="wrapper">
    <?php
    $bilgiler = array("aktifSayfa" => $icerik, "baslik" => $baslik, "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri());
    $this->load->view("inc/navbar", $bilgiler);

    //$this->load->view("inc/aside", $bilgiler);
    
    $this->load->view("icerikler/" . $icerik, $icerik_array);

    //$this->load->view("inc/footer");
    ?>

  </div>

</body>

</html>