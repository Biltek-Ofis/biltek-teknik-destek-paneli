import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SharedPref {
  static String girisDurumuStr = "girisDurumu";
  static String kullaniciIDStr = "kullaniciID";

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

  static Future<int> kullaniciID() async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      int id = sharedPreferences.getInt(kullaniciIDStr) ?? 0;
      return id;
    } catch (e) {
      if (kDebugMode) {
        print(e.toString());
      }
      return 0;
    }
  }

  static Future<bool> girisDurumuEkle(int kullaniciID) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      await sharedPreferences.setBool(girisDurumuStr, true);
      await sharedPreferences.setInt(kullaniciIDStr, kullaniciID);
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
      await sharedPreferences.remove(kullaniciIDStr);
      return true;
    } catch (e) {
      if (kDebugMode) {
        print("Çıkış yapılamadı! Hata: ${e.toString()}");
      }
      return false;
    }
  }
}
