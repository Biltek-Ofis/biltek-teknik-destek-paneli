# BiltekTeknikDestekPaneli

- Kullanım için php.ini ayarları
```
extension=php_pdo_sqlsrv_74_ts.dll
extension=php_sqlsrv_74_ts.dll

```

Site konumuna .env dosyası oluşturulacak. // işaretleri ve sonrasını silin ve satır sonunda boşluk bırakmayın.

```
DB_DRIVER=mysqli
DB_HOST="localhost"
TEKNIK_SERVIS_URL=https://teknikservis.biltekbilgisayar.com.tr/
SITE_BASLIGI="Biltek Bilgisayar"
FIRMA_SITE_URL=http://www.biltekbilgisayar.com.tr/
TABLO_OGE=50
DB_DATABASE_TS=TEKNIK_SERVIS_DB
DB_DATABASE_F=FIRMA_DB
DB_USERNAME=root
DB_PASSWORD=1212
BARKOD_EN="40mm"
BARKOD_BOY="20mm"
AUTH_TOKEN="rastgele belirlediğiniz bir kod"
```

lib klasöründe env.dart dosyası oluşturulacak ve içeriği şu şekilde olacak:

```
class Env{
  static String uygulamaAdi = "Biltek Bilgisayar";
  static String authToken = "yukarıdaki .env dosyasında belirlediğiniz kod";
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