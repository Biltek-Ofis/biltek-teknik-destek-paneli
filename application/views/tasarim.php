<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view("inc/meta");?>
  
  <title><?=$baslik;?></title>

  <?php $this->load->view("inc/styles");?>
  <?php $this->load->view("inc/scripts");?>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php $this->load->view("inc/navbar");?>
  
  <?php 
  $this->load->view("inc/aside", array("aktifSayfa"=>$icerik,"baslik"=>$baslik, "cihazTurleri"=> $this->Cihazlar_Model->cihazTurleri()));
  ?>

  <?php $this->load->view("icerikler/".$icerik, $icerik_array);?>

  <?php //$this->load->view("inc/footer");?>
</div>

</body>
</html>
