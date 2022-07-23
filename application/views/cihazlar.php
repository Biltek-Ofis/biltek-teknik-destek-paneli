<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php
	$this->load->model("Anasayfa_Model");
	?>
	<title><?=$this->Anasayfa_Model->cogulEki($baslik);?></title>
	<?php $this->load->view("inc/styles");?>
	<?php $this->load->view("inc/scripts");?>
</head>
<body>
<?php $this->load->view("inc/navbar", array("aktifSayfa"=>"cihazlar","cihazTurleri"=> $cihazTurleri));?>
<div id="container w-100 m-0 p-0">
	<div class="row m-0 p-0">
		<div class="col-12">
			<h5 class="mx-2"><?php
            echo $this->Anasayfa_Model->cogulEki($baslik);
            ?></h5>
			<?php $this->load->view("cihaz_tablosu", array("tur"=> $suankiCihazTuru, "cihaz_turu_gizle"=>true));?>
		</div>
	</div>
</div>
</body>
</html>
