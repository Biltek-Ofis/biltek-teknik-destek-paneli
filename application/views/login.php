<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Giriş</title>
	<?php $this->load->view("inc/styles");?>
    
</head>
<body>

<div id="container">
	
<div class="wrapper">
        <!--<div class="logo">
            <img src="https://www.freepnglogos.com/uploads/twitter-logo-png/twitter-bird-symbols-png-logo-0.png" alt="">
        </div>-->
        <div class="text-center mt-4 name">
            Giriş Yap
        </div>
        <form class="p-3 mt-3" method="post" action="<?= base_url("login");?>">
            <div class="alert alert-danger" style="<?php if(strlen($loginError) == 0){ echo "display:none;";} ?>" role="alert">
            <?php echo $loginError;?>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Kullanıcı Adı">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="pwd" placeholder="Şifre">
            </div>
            <button class="btn mt-3">Giriş Yap</button>
        </form>
        <div class="text-center fs-6">
            <a href="#"Şifreni mi unuttun?</a>
        </div>
    </div>

</div>
<?php $this->load->view("inc/scripts");?>
</body>
</html>
