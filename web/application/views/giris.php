<?php
defined('BASEPATH') or exit('No direct script access allowed');
$ayarlar = $this->Ayarlar_Model->getir();
?>
<!DOCTYPE html>
<html lang="tr" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title><?= (isset($ayarlar->site_basligi) ? $ayarlar->site_basligi : ""); ?></title>
    <?php
    $this->load->view("inc/meta");
    $this->load->view("inc/styles");
    ?>
    <link rel="stylesheet" href="<?= base_url("plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
    <?php
    $this->load->view("inc/scripts");
    $this->load->view("inc/styles_important");
    ?>
    <style>
        html,
        body {
            height: 100%;
        }

        .form-signin,
        .form-signin img {
            max-width: 330px;
        }

        .form-signin {
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="username"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
    <script>
        $(document).ready(function () {
            ayrilma_durumu_tetikle = false;
            $("input").each(function () {
                $(this).on("change keyup", function () {
                    ayrilmaEngeliIptal();
                });
            });
        });
    </script>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z">
            </path>
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"></path>
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z">
            </path>
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z">
            </path>
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
            </path>
        </symbol>
    </svg>

    <main class="form-signin w-100 m-auto">
        <div class="alert alert-danger" style="<?= (strlen($girisHatasi) == 0 ? "display:none;" : ""); ?>" role="alert">
            <?= $girisHatasi; ?>
        </div>
        <?php
        $this->load->view("inc/tarayici_uyari");
        if (!isset($ekServisNo)) {
            $ekServisNo = "";
        }
        ?>
        <form action="<?= base_url("giris/" . $ekServisNo);?>" method="POST">
        <img class="mb-4" src="<?= base_url("dist/img/logo.png") ;?>" class="w-100">

        <div class="form-floating">
            <input id="kullanici_adi" name="kullanici_adi" type="username" class="form-control" placeholder="Kullanıcı Adı" required>
            <label for="kullanici_adi">Kullanıcı Adı:</label>
        </div>
        <div class="form-floating">
            <input id="sifre" name="sifre" type="password" class="form-control" placeholder="Şifre" required>
            <label for="sifre">Şifre</label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Giriş Yap</button>
    </form>
    <div class="col-12 mt-2">
        <a href="<?= base_url("cihazdurumu") ;?>" class="btn btn-info btn-block w-100 text-white">Cihazımın Durumunu Görüntüle</a>
    </div>
        <?php
        $detect = new Mobile_Detect();
        if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
            ?>
            <?php
            echo '<div class="w-100 mt-2 text-center">
    <a href="' . base_url("app/android") . '" target="_blank"><img style="width:calc(100% / 2)" src="' . base_url("dist/img/app/google-play.png") . '"/></a>
  </div>';
            if (strlen(MOBIL_SURUM_URL) > 0) {
                echo '
    <div class="w-100 text-center">
        veya
    </div>
    <div class="w-100 text-center">
        <a href="' . base_url("m") . '">Mobil Sürüme Geç</a>
    </div>';
            }
        }
        //<p class="mb-1">
//    <a href="forgot-password.html">Şifremi Unuttum</a>
//</p>
        
        echo '
</main>
</body>
</html>';
