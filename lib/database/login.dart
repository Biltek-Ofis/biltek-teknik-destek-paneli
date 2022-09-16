import 'dart:async';

import 'package:flutter/animation.dart';
import 'package:http/http.dart' show get;

import '../models/response.dart';
import 'paths.dart';

typedef OnLoginError = void Function(
  String mesaj,
  String printMsj,
);

typedef OnLoginSuccess = void Function(
  String kullaniciAdi,
);

class LoginSQL {
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
        final response =
            await get(Uri.parse(Paths.girisYap(kullaniciAdi, sifre)));
        if (response.statusCode == 200) {
          ResponseBool responseBool = ResponseBool.response(response.body);
          if (responseBool.response) {
            onLoginSuccess?.call(kullaniciAdi);
          } else {
            onLoginError?.call(
              "Kullanıcı adı veya şifre yanlış! Lütfen tekrar deneyin!",
              response.body,
            );
          }
        } else {
          onLoginError?.call(
            "Bir hata oluştu. Lütfen daha sonra tekrar deneyin!",
            response.statusCode.toString(),
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
