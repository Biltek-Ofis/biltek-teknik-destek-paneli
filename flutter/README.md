# biltekteknikservis

Teknik servis uygulamasi

- .env.example dosyasını .env olarak yeniden adlandır ve içindeki tanımlamaları yap

## Build 

- Python ile .venv kurulumu yapın

- Gereksinimleri kurun 

```
pip install -r requirements.txt
```

- Çalıştır (Varsayılan Cihaz)

```
python build.py --run
```

- Belirli cihazda çalıştırma
```
python build.py --run "CihazAdi"
```

- Android Apk Buildi

```
python build.py --apk
```

- Google Play Buildi

```
python build.py --bundle
```

- Web Buildi

- Eğer domainin altklasöründe yayınlayacaksanız sonda "/" yerine alt kasörün ismini girin
- Örnek: "/mobil/"

```
python build.py --web --base-href "/"
```

- Hepsini build etmek için

```
python build.py --all --base-href "/"
```

- Sadece release için (Google Play ve Web)

```
python build.py --release --base-href "/"
```