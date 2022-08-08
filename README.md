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
DB_DATABASE_TS=teknik_servis //script.sql dosyasının aktarıldığı vertabanı adı
DB_DATABASE_F=FIRMA2022 //Firmanın verilerinin bulunduğu veritabanı
DB_USERNAME=sa //SQL Kullanıcı adı
DB_PASSWORD=1234 //SQL Şifre
```