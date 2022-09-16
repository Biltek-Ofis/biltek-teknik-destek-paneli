import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SharedPref {
  static String girisDurumuStr = "girisDurumu";
  static String kullaniciAdiStr = "kullaniciAdi";

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

  static Future<bool> girisDurumuEkle(String kullaniciAdi) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      await sharedPreferences.setBool(girisDurumuStr, true);
      await sharedPreferences.setString(kullaniciAdiStr, kullaniciAdi);
      return true;
    } catch (e) {
      if (kDebugMode) {
        print("Kullanıcı girişi yapılamadı. Hata: ${e.toString()}");
      }
      return false;
    }
  }

  static Future<bool> girisDurumuSil() async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      await sharedPreferences.remove(girisDurumuStr);
      await sharedPreferences.remove(kullaniciAdiStr);
      return true;
    } catch (e) {
      if (kDebugMode) {
        print("Çıkış yapılamadı! Hata: ${e.toString()}");
      }
      return false;
    }
  }
}
