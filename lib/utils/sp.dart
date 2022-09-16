import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SharedPref {
  static String girisDurumuStr = "girisDurumu";

  static Future<bool> girisDurumu() async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      bool gd = sharedPreferences.getBool(girisDurumuStr) ?? false;
      return gd;
    } catch (e) {
      if (kDebugMode) {
        print(e.toString());
      }
      return false;
    }
  }

  static void girisYap({
    required String kullaniciAdi,
    required String sifre,
  }) {}
}
