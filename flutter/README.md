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

**Web'te flutter 3.50.0 ve üzeri kullanıyorsanız bazı dosya isimleri şifrelenecektir.**
**Bu şifrelenecek dosyalar için hosting sağlayıcı ayarları alttadır.**

| Hosting | Kullanılacak dosya |
|------|-----|
| Firebase | build/cache-config/firebase-hosting-headers.generated.json |
| Vercel | build/cache-config/vercel-headers.generated.json |
| Netlify | build/web/_headers |
| Nginx | build/cache-config/nginx-cache.generated.conf |
| Apache / cPanel | build/web/.htaccess |
	
	
	
 	
	