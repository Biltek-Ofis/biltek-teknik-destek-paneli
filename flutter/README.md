# biltekteknikservis

Teknik servis uygulamasi

- .env.example dosyasını .env olarak yeniden adlandır ve içindeki tanımlamaları yap

## Run

```
flutter run --dart-define-from-file=.env
```

## Build 

-Android

```
flutter build apk --dart-define-from-file=.env --release --obfuscate --split-debug-info ./split-debug-info
```

- Web

- Eğer domainin altklasöründe yayınlayacaksanız sonda "/" yerine alt kasörün ismini girin
- Örnek: "/mobil/"

```
flutter build web --dart-define-from-file=.env --release --base-href "/"
```

- Windows

```
flutter build windows --dart-define-from-file=.env --release --obfuscate --split-debug-info ./split-debug-info
```

- Google Play

```
java -jar pepk.jar --keystore=keystore.jks --alias=biltek --output=output.zip --include-cert --rsa-aes-encryption --encryption-key-path=encryption_public_key.pem 
```

```
flutter build appbundle --dart-define-from-file=.env --release --obfuscate --split-debug-info ./split-debug-info
```