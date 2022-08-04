<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view("inc/meta"); ?>

  <title><?= $baslik; ?><?= SITE_BASLIGI != NULL ? " - " . SITE_BASLIGI : ""; ?></title>
  <?php
  if ($ek_css != "") {
    $this->load->view($ek_css);
  } ?>
  <?php $this->load->view("inc/styles"); ?>
  <?php $this->load->view("inc/scripts"); ?>

</head>

<body class="sidebar-mini layout-fixed">
  <script>
    $(document).ready(function() {
      setInterval(function() {
        window.location.reload();
      }, 30 * 60 * 1000);
    });
  </script>
  <div class="wrapper">
    <?php $this->load->view("inc/navbar"); ?>

    <?php
    $this->load->view("inc/aside", array("aktifSayfa" => $icerik, "baslik" => $baslik, "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri()));
    ?>

    <?php $this->load->view("icerikler/" . $icerik, $icerik_array); ?>

    <?php //$this->load->view("inc/footer");
    ?>
  </div>

</body>

</html>