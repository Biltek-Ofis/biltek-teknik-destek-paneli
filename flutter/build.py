#!/usr/bin/env python3

import os
import sys
import argparse
import re
from dotenv import load_dotenv
from datetime import date
from pathlib import Path
import subprocess
import json

skip_android_dependency_validation = True

load_dotenv()

ENV_DOSYASI = ".env"

ANDROID_STORE_PASSWORD=os.getenv("ANDROID_STORE_PASSWORD")
ANDROID_KEY_PASSWORD=os.getenv("ANDROID_KEY_PASSWORD")
ANDROID_KEY_ALIAS=os.getenv("ANDROID_KEY_ALIAS")
ANDROID_STORE_FILE=os.getenv("ANDROID_STORE_FILE")
keyStoreOlusturuldu = False

def update_build_date(file_path: str = ENV_DOSYASI) -> None:
    path = Path(file_path)
 
    if not path.exists():
        raise FileNotFoundError(f"'{file_path}' bulunamadı.")
 
    today = date.today().strftime("%Y-%m-%d")
    content = path.read_text(encoding="utf-8")
 
    new_content, update_count = re.subn(
        r'^(SURUM_TARIHI=").*?(")',
        rf'\g<1>{today}\g<2>',
        content,
        flags=re.MULTILINE,
    )
 
    if update_count == 0:
        print("SURUM_TARIHI anahtarı .env dosyasında bulunamadı. Yenisi oluşturulacak.")
        path.write_text(f"{content}\nSURUM_TARIHI=\"{today}\"", encoding="utf-8")
    else:
        path.write_text(new_content, encoding="utf-8")
    print(f"SURUM_TARIHI '{today}' olarak güncellendi.")

def system2(cmd):
    exit_code = os.system(cmd)
    if exit_code != 0:
        sys.stderr.write(f"Error occurred when executing: `{cmd}`. Exiting.\n")
        sys.exit(-1)

def make_parser():
    parser = argparse.ArgumentParser(description='Build script.')
    parser.add_argument(
        '-v',
        '--verbose',
        action='store_true',
        help='Derleme loglarını detaylı gösterir'
    )
    parser.add_argument(
        '--apk',
        action='store_true',
        help='APK Derle'
    )
    parser.add_argument(
        '--bundle',
        action='store_true',
        help='Play Store için Bundle derleme'
    )
    parser.add_argument(
        '--web',
        action='store_true',
        help='Web versionu derleme'
    )
    parser.add_argument(
        '--base-href',
        type=str,
        default='/',
        help='Web build için ana dizini belirtin değeri. '
        '\nhttps://example.com/m/ şeklindeyse --base-href /m/ olarak verilmelidir.'
        '\nDeğer verilmezse varsayılan "/" olarak ayarlanır.'
    )
    parser.add_argument(
        '--all',
        action='store_true',
        help='Tüm desteklenen platformlar için derleme yapar.'
    )
    parser.add_argument(
        '--release',
        action='store_true',
        help='Tüm desteklenen platformlar için derleme yapar.'
    )
    parser.add_argument(
        '--run',
        type=str,
        nargs='?',
        const='default',
        default=None,
        help='Belirtilen cihazda uygulamayı çalıştır. (Örneğin: --run windows, --run chrome)'
            '\nBoş değer verilirse varsayılan cihazda çalıştırır.'
    )
    return parser
    

def main():
    global ANDROID_STORE_FILE, keyStoreOlusturuldu
    parser = make_parser()
    args = parser.parse_args()
    calisti = False
    if args.all:
        args.apk = True
        args.bundle = True
        args.web = True
    
    if args.release:
        args.apk = False
        args.bundle = True
        args.web = True

    if args.all and args.release:
        print("Not: --all ve --release seçenekleri birlikte kullanıldığında sadece Play Store için Bundle ve Web derlemesi yapılır. APK derlemesi yapılmaz.")
    ekArgs = ""
    if args.verbose:
        ekArgs += " -v"
    ekArgsAndroid = ekArgs
    if skip_android_dependency_validation:
        ekArgsAndroid += " --android-skip-build-dependency-validation"
    if args.apk or args.bundle or args.run:
        check_keystore = False
        if check_keystore and not all([
            ANDROID_STORE_PASSWORD,
            ANDROID_KEY_PASSWORD,
            ANDROID_KEY_ALIAS,
            ANDROID_STORE_FILE
        ]):
            print("Hata: Android imzalama bilgileri eksik!")
            return
        if ANDROID_STORE_FILE and not keyStoreOlusturuldu:
            ANDROID_STORE_FILE = ANDROID_STORE_FILE.replace("\\", "\\\\")
        keyStoreOlusturuldu = True
        keypropertieslocation = r"android/key.properties"
        with open(keypropertieslocation, "w", encoding="utf-8") as keyproperties:
            keyproperties.write("""storePassword={0}
keyPassword={1}
keyAlias={2}
storeFile={3}
""".format(
        ANDROID_STORE_PASSWORD if ANDROID_STORE_PASSWORD else "placeholder",
        ANDROID_KEY_PASSWORD if ANDROID_KEY_PASSWORD else "placeholder",
        ANDROID_KEY_ALIAS if ANDROID_KEY_ALIAS else "placeholder",
        ANDROID_STORE_FILE if ANDROID_STORE_FILE else "placeholder"
    ))

    if args.apk:
        if not calisti:
            update_build_date()
        calisti = True
        print("APK derleniyor...")
        system2(f"flutter build apk{ekArgsAndroid} --dart-define-from-file=.env --release --obfuscate --split-debug-info ./split-debug-info")
    if args.bundle:
        if not calisti:
            update_build_date()
        calisti = True
        print("Play Store için Bundle derleniyor...")
        system2(f"flutter build appbundle{ekArgsAndroid} --dart-define-from-file=.env --release --obfuscate --split-debug-info ./split-debug-info")
    if args.web:
        if not calisti:
            update_build_date()
        calisti = True
        print("Web versionu derleniyor...")
        system2(f"flutter build web{ekArgs} --dart-define-from-file=.env --release --base-href \"{args.base_href}\"")
    if args.run is not None:
        if not calisti:
            update_build_date()
        calisti = True
        run_cmd = f"flutter run"
        run_cmd += ekArgsAndroid
        if args.run == "default":
            print("Uygulama varsayılan cihazda çalıştırılıyor...")
        else:
            print(f"Uygulama '{args.run}' cihazında çalıştırılıyor...")
            run_cmd += f" -d \"{args.run}\""
        run_cmd += " --dart-define-from-file=.env"
        system2(run_cmd)
    if calisti:
        print("İşlem tamamlandı.")
    else:
        print("Hiçbir işlem seçilmedi. Lütfen en az bir seçenek belirtin. Yardım için --help kullanın.")
        system2("python build.py --help")
if __name__ == "__main__":
    main() 
