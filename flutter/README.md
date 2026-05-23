# biltekteknikservis

Teknik servis uygulamasi

- .env.example dosyasını .env olarak yeniden adlandır ve içindeki tanımlamaları yap

## Build 

- Python ile .venv kurulumu yapın

- Gereksinimleri kurun 

```
pip install -r requirements.txt
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