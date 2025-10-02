<?php
echo '<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>';
$this->load->view("inc/meta");
$ayarlar = $this->Ayarlar_Model->getir();
echo '<title>' . $baslik . '' . (isset($ayarlar->site_basligi) ? " - " . $ayarlar->site_basligi : "") . '</title>';

if ($ek_css != "") {
  $this->load->view($ek_css);
}
$this->load->view("inc/styles");
echo '<script>
  var base_url = "' . base_url() . '";
</script>';
$this->load->view("inc/scripts");
$this->load->view("inc/style_tablo");
$this->load->view("inc/styles_important");
?>
<?php
if($this->Kullanicilar_Model->firebaseAyarlandi() && ($this->Giris_Model->kullaniciGiris() || $this->Giris_Model->kullaniciGiris(TRUE))){
?>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-app.js";
  import { initializeAppCheck, ReCaptchaV3Provider } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-app-check.js";
  import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-messaging.js";
  
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "<?=FIREBASE_CONFIG["apiKey"];?>",
    authDomain: "<?=FIREBASE_CONFIG["authDomain"];?>",
    projectId: "<?=FIREBASE_CONFIG["projectId"];?>",
    storageBucket: "<?=FIREBASE_CONFIG["storageBucket"];?>",
    messagingSenderId: "<?=FIREBASE_CONFIG["messagingSenderId"];?>",
    appId: "<?=FIREBASE_CONFIG["appId"];?>"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const appCheck = initializeAppCheck(app, {
    provider: new ReCaptchaV3Provider('<?=FIREBASE_CONFIG["recaptchaV3SiteKey"];?>'),
    isTokenAutoRefreshEnabled: true
  });
  const messaging = getMessaging(app);
  
  function getFCMToken(){
     getToken(messaging, { vapidKey: "<?=FIREBASE_CONFIG["webPushCertificates"];?>" }).then((currentToken) => {
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
    if(window.Notification) {
      Notification.requestPermission().then(permission => {
          if (permission === "granted") {
              getFCMToken();
          }
      });
    }
  }
  $(document).ready(function(){
    if (navigator.serviceWorker) {
      navigator.serviceWorker.register('/firebase-messaging-sw.js').then(function(registration){
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
echo '</head>

<body class="layout-top-nav"> <!--sidebar-collapse-->
  <div class="wrapper">';
$bilgiler =  array("aktifSayfa" => $icerik, "baslik" => $baslik, "cihazTurleri" => $this->Cihazlar_Model->cihazTurleri());
$this->load->view("inc/navbar", $bilgiler);

$this->load->view("icerikler/" . $icerik, $icerik_array);

//$this->load->view("inc/footer");
echo '</div>

</body>

</html>';
