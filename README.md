# BiltekTeknikDestekPaneli

- Kullanım için php.ini ayarları
```
extension=php_pdo_sqlsrv_74_ts.dll
extension=php_sqlsrv_74_ts.dll

```

- php/application/config/constants.php dosyasında en altta bulunan site ayarlarını kendinize göre değiştirebilirsiniz.

```
define("SITE_BASLIGI", "Biltek Bilgisayar"); // Sitenizin başlığı
define("TEKNIK_SERVIS_URL", "https://biltek.ozayakcan.com.tr/"); // Teknik servis sayfası
define("FIRMA_SITE_URL", "http://www.biltekbilgisayar.com.tr/"); // Firmanızın web sayfası
....
// Diğer ayarlar
....
```

lib klasöründe env.dart dosyası oluşturulacak ve içeriği şu şekilde olacak:

```
class Env{
  static String uygulamaAdi = "Biltek Bilgisayar";
  static String authToken = "yukarıdaki php/application/config/constants.php dosyasında belirlediğiniz kod";
}
```

- Önemli:

Uygulamanın web sürümünü test(debug) edebilmek için cmd içinde alttaki kodlar çalıştırılmalı.
```
dart pub global activate flutter_cors
fluttercors --disable
```

# Derlemeler

- Android
```
flutter build apk
```

- Windows
```
flutter build windows
```

- Web
```
flutter build web
```