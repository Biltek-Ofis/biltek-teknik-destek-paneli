# biltekteknikservis

Teknik servis uygulamasi

- .env dosyası oluştur ve şu değerleri tanımla

```
TOKEN=token_buraya
API_URL=http://localhost/
FIREBASE_PROJECT_ID=
FIREBASE_AUTH_DOMAIN=
FIREBASE_STORAGE_BUCKET=
FIREBASE_MESSAGING_SENDER_ID=
FIREBASE_ANDROID_API_KEY=
FIREBASE_ANDROID_APP_ID=
```

## Run

```
flutter run --dart-define-from-file=.env
```

## Build 

-Android

```
flutter build apk --dart-define-from-file=.env --release --obfuscate --split-debug-info="C:\Users\Ozay\Documents\biltekteknikservis"
```

- Windows

```
flutter build windows --dart-define-from-file=.env --release --obfuscate --split-debug-info="C:\Users\Ozay\Documents\biltekteknikservis"
```

- Google Play

```
java -jar pepk.jar --keystore=keystore.jks --alias=biltek --output=output.zip --include-cert --rsa-aes-encryption --encryption-key-path=encryption_public_key.pem 
```

```
flutter build appbundle --dart-define-from-file=.env --release --obfuscate --split-debug-info="C:\Users\Ozay\Documents\biltekteknikservis"
```