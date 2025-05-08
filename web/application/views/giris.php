<?php
defined('BASEPATH') or exit('No direct script access allowed');
$ayarlar = $this->Ayarlar_Model->getir();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= isset($ayarlar->site_basligi) ? $ayarlar->site_basligi : ""; ?></title>
    <?php
    $this->load->view("inc/meta");
    $this->load->view("inc/styles");
    ?>
    <link rel="stylesheet" href="<?= base_url("plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
    <?php
    $this->load->view("inc/scripts");
    ?>
</head>

<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url(); ?>" class="h1 w-100 text-center"><img height="100"
                        src="<?= base_url("dist/img/logo.png"); ?>" /></a>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" style="<?= strlen($girisHatasi) == 0 ? "display:none;" : ""; ?>"
                    role="alert">
                    <?= $girisHatasi; ?>
                </div>
                <?php
                $this->load->view("inc/tarayici_uyari");
                if (!isset($ekServisNo)) {
                    $ekServisNo = "";
                }
                ?>
                <form action="<?= base_url("giris/" . $ekServisNo); ?>" method="post">
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
                            <a href="<?= base_url("cihazdurumu"); ?>" class="btn btn-info btn-block">Cihazımın Durumunu
                                Görüntüle</a>
                        </div>
                    </div>
                </form>
                <?php
                $detect = new Mobile_Detect();
                if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
                    ?>
                    <div class="w-100 mt-2 text-center">
                        <a href="<?= base_url("app/android"); ?>" target="_blank" style="color: blue !important;">
                            <img style="width:calc(100% / 2)" src="<?= base_url("dist/img/app/google-play.png"); ?>" />
                        </a>
                    </div>
                    <?php
                }
                ?>
                <!--
                <p class="mb-1">
                    <a href="forgot-password.html">Şifremi Unuttum</a>
                </p>
                -->
            </div>
        </div>
    </div>
</body>

</html>