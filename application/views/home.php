<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Anasayfa</title>
	<?php $this->load->view("inc/styles");?>
</head>
<body>

	
<?php $this->load->view("inc/navbar");?>
<div id="container">
<?php print_r(PDO::getAvailableDrivers());?>
</div>
<?php $this->load->view("inc/scripts");?>

</body>
</html>
