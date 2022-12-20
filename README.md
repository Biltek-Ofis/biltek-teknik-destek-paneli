# BiltekTeknikDestekPaneli

- Kullanım için php.ini ayarları
```
extension=php_pdo_sqlsrv_74_ts.dll
extension=php_sqlsrv_74_ts.dll

```

Site konumuna .env dosyası oluşturulacak. // işaretleri ve sonrasını silin ve satır sonunda boşluk bırakmayın.

```
DB_DRIVER=sqlsrv //Değiştirilmeyecek
DB_HOST=192.168.1.10,1433 //Sunucu adresi ve port
TEKNIK_SERVIS_URL=http://localhost:8080/ //Teknik servisin bulunduğu url
SIRKET_TELEFONU="0 (555) 555 5555" // Şirket telefonu
SITE_BASLIGI="Biltek Bilgisayar" //Firma adı
FIRMA_SITE_URL=http://www.biltekbilgisayar.com.tr/ //Firmanın anasayfası
DB_DATABASE_TS=teknik_servis //script.sql dosyasının aktarıldığı vertabanı adı
DB_DATABASE_F=FIRMA2022 //Firmanın verilerinin bulunduğu veritabanı
DB_USERNAME=sa //SQL Kullanıcı adı
DB_PASSWORD=1234 //SQL Şifre
BARKOD_EN=40
BARKOD_BOY=20
BARKOD_BOYUTU=14
BARKOD_NUMARASI_BOYUTU=12
BARKOD_MUSTERI_ADI_BOYUTU=12
BARKOD_SIRKET_ADI_BOYUTU=10
```