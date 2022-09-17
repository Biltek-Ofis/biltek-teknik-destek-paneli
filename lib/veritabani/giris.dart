import 'dart:async';

import 'package:flutter/foundation.dart';

import '../model/kullanici_girisi.dart';
import 'baglan.dart';
import 'konumlar.dart';

typedef OnLoginError = void Function(
  String mesaj,
  String printMsj,
);

typedef OnLoginSuccess = void Function(
  int kullaniciID,
);

class GirisSQL {
  static Future<void> girisYap({
    required String kullaniciAdi,
    required String sifre,
    VoidCallback? beforeLogin,
    OnLoginSuccess? onLoginSuccess,
    OnLoginError? onLoginError,
  }) async {
    beforeLogin?.call();
    if (kullaniciAdi.length >= 3) {
      if (sifre.length >= 6) {
        try {
          KullaniciGirisiModel kullaniciGirisiModel =
              KullaniciGirisiModel.fromJson(await Baglan.map(
                  url: Konumlar.girisYap(kullaniciAdi, sifre)));
          if (kDebugMode) {
            print(
                "Giriş Yap Sonuç: ${kullaniciGirisiModel.id}, ${kullaniciGirisiModel.durum}");
          }
          if (kullaniciGirisiModel.durum) {
            onLoginSuccess?.call(kullaniciGirisiModel.id);
          } else {
            onLoginError?.call(
              "Kullanıcı adı veya şifre yanlış! Lütfen tekrar deneyin!",
              "Giriş Durumu: ${kullaniciGirisiModel.durum}",
            );
          }
        } catch (e) {
          if (kDebugMode) {
            print("Giriş Yap Hata: ${e.toString()}");
          }
          onLoginError?.call(
            "Bir hata oluştu. Lütfen daha sonra tekrar deneyin!",
            e.toString(),
          );
        }
      } else {
        onLoginError?.call(
          "Şifre en az 6 karakter olmalı.",
          sifre.length.toString(),
        );
      }
    } else {
      onLoginError?.call(
        "Kullanıcı Adı en az 3 karakter olmalı.",
        kullaniciAdi.length.toString(),
      );
    }
  }
}
