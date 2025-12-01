<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="tr" data-bs-theme="light">

<head>
  <?php
  $this->load->view("inc/meta");
  $ayarlar = $this->Ayarlar_Model->getir();
  ?>
  <title><?= $baslik . '' . (isset($ayarlar->site_basligi) ? " - " . $ayarlar->site_basligi : ""); ?></title>
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
  $this->load->view("inc/style_tablo");
  $this->load->view("inc/styles_important");
  ?>
  <?php
  if ($this->Kullanicilar_Model->firebaseAyarlandi() && ($this->Giris_Model->kullaniciGiris() || $this->Giris_Model->kullaniciGiris(TRUE))) {
    ?>
    <script type="module">
      // Import the functions you need from the SDKs you need
      import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
      import { initializeAppCheck, ReCaptchaV3Provider } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app-check.js";
      import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-messaging.js";

      // TODO: Add SDKs for Firebase products that you want to use
      // https://firebase.google.com/docs/web/setup#available-libraries

      // Your web app's Firebase configuration
      const firebaseConfig = {
        apiKey: "<?= FIREBASE_CONFIG["apiKey"]; ?>",
        authDomain: "<?= FIREBASE_CONFIG["authDomain"]; ?>",
        projectId: "<?= FIREBASE_CONFIG["projectId"]; ?>",
        storageBucket: "<?= FIREBASE_CONFIG["storageBucket"]; ?>",
        messagingSenderId: "<?= FIREBASE_CONFIG["messagingSenderId"]; ?>",
        appId: "<?= FIREBASE_CONFIG["appId"]; ?>"
      };

      // Initialize Firebase
      const app = initializeApp(firebaseConfig);
      const appCheck = initializeAppCheck(app, {
        provider: new ReCaptchaV3Provider('<?= FIREBASE_CONFIG["recaptchaV3SiteKey"]; ?>'),
        isTokenAutoRefreshEnabled: true
      });
      const messaging = getMessaging(app);

      function getFCMToken() {
        getToken(messaging, { vapidKey: "<?= FIREBASE_CONFIG["webPushCertificates"]; ?>" }).then((currentToken) => {
          if (currentToken) {
            $.post("<?= base_url("kullanici/fcmToken"); ?>", {
              token: currentToken,
            })
              .done(function (msg) {
                console.log("Kaydedildi.");
              })
              .fail(function (xhr, status, error) {
                console.log("FCM token kaydedilemedi", error);
              });
          } else {
            console.log('Kayıt tokeni bulunamadı.');
          }
        }).catch((err) => {
          console.log('Token alınırken bir hata oluştu ', err);
        });
      }
      function requestPermission() {
        if (window.Notification) {
          Notification.requestPermission().then(permission => {
            if (permission === "granted") {
              getFCMToken();
            }
          });
        }
      }
      $(document).ready(function () {
        if (navigator.serviceWorker) {
          navigator.serviceWorker.register('/firebase-messaging-sw.js').then(function (registration) {
          }).catch(console.log);
        }
        onMessage(messaging, (payload) => {
          if (navigator.serviceWorker) {
            navigator.serviceWorker.ready.then(registration => {
              registration.active?.postMessage({
                type: 'SHOW_NOTIFICATION',
                payload: payload
              });
            });
          }
        });
        requestPermission();
      });
    </script>
    <?php
  }
  ?>
  <style>
    #santa-container {
      <?= KIS_MODU ? "" : "display: none;"; ?>
      position: fixed;
      top: 0;
      left: 0;
      pointer-events: none;
      z-index: 500;
    }

    #santa {
      <?= KIS_MODU ? "" : "display: none;"; ?>
      width: 150px;
      height: 80;
      position: absolute;
      transform-origin: center;
    }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const santa = document.getElementById("santa");

      let posX = 0;
      let posY = 100;

      let direction = 1;       // 1 = sağa, -1 = sola
      let t = 0;

      const speed = 5;
      const swayAmount = 20;
      const swaySpeed = 0.05;

      const screenW = () => window.innerWidth;
      const screenH = () => window.innerHeight;

      function resetSanta() {

        // 👉 Artık rastgele değil, sırayla yön değiştiriyoruz
        direction = direction * -1;

        // Y konumu rastgele
        posY = Math.random() * (screenH() - 150);

        if (direction === 1) {
          // soldan → sağa gidiyor
          posX = -200;
          santa.style.transform = "scaleX(1)";
          santa.style.transformOrigin = "left center";
        } else {
          // sağdan → sola gidiyor
          posX = screenW() + 200;
          santa.style.transform = "scaleX(-1)";
          santa.style.transformOrigin = "right center";
        }
      }

      function animate() {
        t += swaySpeed;
        posX += direction * speed;

        const sway = Math.sin(t) * swayAmount;

        santa.style.left = posX + "px";
        santa.style.top = (posY + sway) + "px";

        if (posX < -300 || posX > screenW() + 300) {
          resetSanta();
        }

        requestAnimationFrame(animate);
      }

      resetSanta();
      animate();
    });
  </script>

</head>

<body class="layout-top-nav"> <!--sidebar-collapse-->

  <div class="wrapper">
    <?php
    $bilgiler = array("aktifSayfa" => $icerik, "baslik" => $baslik, "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri());
    $this->load->view("inc/navbar", $bilgiler);

    $this->load->view("icerikler/" . $icerik, $icerik_array);

    //$this->load->view("inc/footer");
    ?>
  </div>
  <div id="santa-container">
    <img id="santa" src="<?= base_url("dist/img/kis/santa.png") ?>" alt="Santa">
  </div>
</body>

</html>