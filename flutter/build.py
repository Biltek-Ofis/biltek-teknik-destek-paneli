#!/usr/bin/env python3

import os
import sys
import argparse
from dotenv import load_dotenv

load_dotenv()

def system2(cmd):
    exit_code = os.system(cmd)
    if exit_code != 0:
        sys.stderr.write(f"Error occurred when executing: `{cmd}`. Exiting.\n")
        sys.exit(-1)

def make_parser():
    parser = argparse.ArgumentParser(description='Build script.')
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
        '--run',
        type=str,
        default='',
        help='Belirtilen cihazda uygulamayı çalıştır. (Örneğin: --run windows, --run chrome)'
        '\nBoş değer verilirse varsayılan cihazda çalıştırır.')
    return parser
    

def main():
    parser = make_parser()
    args = parser.parse_args()
    if args.all:
        args.apk = True
        args.bundle = True
        args.web = True
    if args.apk:
        print("APK derleniyor...")
        system2("flutter build apk --dart-define-from-file=.env --release --obfuscate --split-debug-info ./split-debug-info")
    if args.bundle:
        print("Play Store için Bundle derleniyor...")
        system2("flutter build appbundle --dart-define-from-file=.env --release --obfuscate --split-debug-info ./split-debug-info")
    if args.web:
        print("Web versionu derleniyor...")
        system2(f"flutter build web --dart-define-from-file=.env --release --base-href \"{args.base_href}\"")

if __name__ == "__main__":
    main() 
