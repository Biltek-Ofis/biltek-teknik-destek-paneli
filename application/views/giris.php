<?php
defined('BASEPATH') or exit('No direct script access allowed');

echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Giriş</title>';
$this->load->view("inc/meta");
$this->load->view("inc/styles");
echo '<link rel="stylesheet" href="' . base_url("plugins/icheck-bootstrap/icheck-bootstrap.min.css") . '">';
$this->load->view("inc/scripts");
echo '</head>
<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="' . base_url() . '" class="h1 w-100 text-center"><img height="100" src="' . base_url("dist/img/logo.png") . '"/></a>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" style="';
if (strlen($girisHatasi) == 0) {
    echo "display:none;";
}
echo '" role="alert">';
$girisHatasi;
echo '</div>';
$this->load->view("inc/tarayici_uyari");
if(!isset($ekServisNo)){
    $ekServisNo = "";
}
echo '
                <form action="' . base_url("giris/".$ekServisNo) . '" method="post">
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <input type="text" name="kullanici_adi" class="form-control" placeholder="Kullanıcı Adı">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <input type="password" name="sifre" class="form-control" placeholder="Şifre">
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Beni hatırla
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
                        </div>
                        
                        <div class="col-12 mt-2">
                            <a href="'.base_url("cihazdurumu").'" class="btn btn-info btn-block">Cihazımın Durumunu Görüntüle</a>
                        </div>
                    </div>
                </form>
                ';
                $detect = new Mobile_Detect();
if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
  echo '<div class="w-100 mt-2 text-center">
    <a href="'.base_url("app/android").'" target="_blank" style="color: blue !important;"><img style="width:calc(100% / 2)" src="'.base_url("dist/img/app/google-play.png").'"/></a>
  </div>';
}
                //<p class="mb-1">
                //    <a href="forgot-password.html">Şifremi Unuttum</a>
                //</p>
                
            echo '</div>
        </div>
    </div>
</body>
</html>';
