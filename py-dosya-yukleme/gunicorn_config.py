# gunicorn_config.py

import multiprocessing

bind = "0.0.0.0:5000"  # Flask uygulamanın çalışacağı IP ve port
workers = multiprocessing.cpu_count() * 2 + 1  # CPU sayısına göre worker belirleme
timeout = 120  # Timeout süresi (saniye)
keepalive = 5  # Keep-alive bağlantı süresi
errorlog = "/opt/biltek/logs/gunicorn_error.log"  # Hata logları için dosya
accesslog = "/opt/biltek/logs/gunicorn_access.log"  # Erişim logları için dosya
loglevel = "info"  # Log seviyesi (debug, info, warning, error, critical)

# Arka planda çalıştırma (daemon mode) - İstersen True yapabilirsin
daemon = False  

# İsteğe bağlı: Günlük dosyalarının dizinini oluştur
import os
log_dir = "/opt/biltek/logs"
if not os.path.exists(log_dir):
    os.makedirs(log_dir)

