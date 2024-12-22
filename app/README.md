# biltekteknikservis

Teknik servis uygulamasi

- .env dosyası oluştur ve şu değerleri tanımla

```
TOKEN=token_buraya
API_URL=http://localhost/app/
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