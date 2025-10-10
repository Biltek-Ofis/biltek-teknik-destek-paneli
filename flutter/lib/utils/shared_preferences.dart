import 'dart:convert';

import 'package:biltekteknikservis/utils/encryption.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SharedPreference {
  static const darkThemeString = "darkTheme";
  static const kullaniciString = "kullanici";
  static const beniHatirlaString = "beniHatirla";
  static const authString = "auth";
  static const fcmTokenString = "fcmToken";
  static const barkodIP = "barkodIP";
  static const barkodPort = "barkodPort";

  static Future<Set<String>> getKeys() async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return sharedPreferences.getKeys();
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<Object?> get(String key, {Object? defaultValue}) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return sharedPreferences.get(key) ?? defaultValue;
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<bool> setString(String key, String value) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return await sharedPreferences.setString(key, value);
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<String?> getString(String key, {String? defaultValue}) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return sharedPreferences.getString(key) ?? defaultValue;
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<bool> setBool(String key, bool value) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return await sharedPreferences.setBool(key, value);
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<bool?> getBool(String key, {bool? defaultValue}) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return sharedPreferences.getBool(key) ?? defaultValue;
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<bool> setDouble(String key, double value) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return await sharedPreferences.setDouble(key, value);
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<double?> getDouble(String key, {double? defaultValue}) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return sharedPreferences.getDouble(key) ?? defaultValue;
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<bool> setInt(String key, int value) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return await sharedPreferences.setInt(key, value);
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<int?> getInt(String key, {int? defaultValue}) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return sharedPreferences.getInt(key) ?? defaultValue;
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<bool> setStringList(String key, List<String> value) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return await sharedPreferences.setStringList(key, value);
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future<List<String>> getStringList(
    String key, {
    List<String> defaultValue = const [],
  }) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return sharedPreferences.getStringList(key) ?? defaultValue;
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future remove(String key) async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return await sharedPreferences.remove(key);
    } catch (e) {
      return Future.error(e);
    }
  }

  static Future clear() async {
    try {
      SharedPreferences sharedPreferences =
          await SharedPreferences.getInstance();
      return await sharedPreferences.clear();
    } catch (e) {
      return Future.error(e);
    }
  }
}

class SPKullanici {
  final String isim;
  final String kullaniciAdi;
  String sifre;
  bool _sifrelendi = false;

  SPKullanici._({
    required this.isim,
    required this.kullaniciAdi,
    required this.sifre,
  });

  factory SPKullanici.create({
    required String isim,
    required String kullaniciAdi,
    required String sifre,
    bool sifrele = true,
  }) {
    SPKullanici spKullanici = SPKullanici._(
      isim: isim,
      kullaniciAdi: kullaniciAdi,
      sifre: sifre,
    );
    if (sifrele) {
      spKullanici.sifrele();
    }
    return spKullanici;
  }

  String sifrele() {
    if (!_sifrelendi) {
      _sifrelendi = true;
      sifre = Encryption.encrypt(sifre);
    }
    return sifre;
  }

  String sifreyiCoz() {
    if (_sifrelendi) {
      _sifrelendi = false;
      sifre = Encryption.decrypt(sifre);
    }
    return sifre;
  }

  factory SPKullanici.fromJson(Map<String, dynamic> json) {
    SPKullanici spKullanici = SPKullanici._(
      isim: json["isim"],
      kullaniciAdi: json["kullaniciAdi"],
      sifre: json["sifre"],
    );
    spKullanici._sifrelendi = json["sifrelendi"];
    return spKullanici;
  }
  Map<String, dynamic> toJson() {
    return {
      "isim": isim,
      "kullaniciAdi": kullaniciAdi,
      "sifre": sifre,
      "sifrelendi": _sifrelendi,
    };
  }

  @override
  String toString() {
    return jsonEncode(toJson());
  }
}
