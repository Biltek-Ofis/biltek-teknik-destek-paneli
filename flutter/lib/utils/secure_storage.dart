import 'dart:convert';

import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SecureStorage {
  static FlutterSecureStorage? secureStorage;
  static SharedPreferences? sharedPreferences;

  static const darkThemeString = "darkTheme";
  static const kullaniciString = "kullanici";
  static const beniHatirlaString = "beniHatirla";
  static const authString = "auth";
  static const fcmTokenString = "fcmToken";
  static const barkodIP = "barkodIP";
  static const barkodPort = "barkodPort";

  static Future<void> init() async {
    SecureStorage.secureStorage = FlutterSecureStorage(
      aOptions: AndroidOptions(),
    );
    SecureStorage.sharedPreferences = await SharedPreferences.getInstance();
  }

  static Future<void> checkInit() async {
    if (SecureStorage.secureStorage == null ||
        SecureStorage.sharedPreferences == null) {
      await init();
    }
  }

  static Future<String?> getStringNullable(
    String key, {
    String? defaultValue,
  }) async {
    await SecureStorage.checkInit();
    String? valueSp = SecureStorage.sharedPreferences!.getString(key);
    if (valueSp != null) {
      SecureStorage.sharedPreferences!.remove(key);
      SecureStorage.setString(key, valueSp);
      return valueSp;
    }
    return await SecureStorage.secureStorage!.read(key: key) ?? defaultValue;
  }

  static Future<String> getString(
    String key, {
    String defaultValue = "",
  }) async {
    return await SecureStorage.getStringNullable(
          key,
          defaultValue: defaultValue,
        ) ??
        defaultValue;
  }

  static Future<void> setString(String key, String value) async {
    await SecureStorage.checkInit();
    await SecureStorage.secureStorage!.write(key: key, value: value);
  }

  static Future<List<String>?> getStringListNullable(
    String key, {
    List<String>? defaultValue,
  }) async {
    await SecureStorage.checkInit();

    List<String>? valueSp = SecureStorage.sharedPreferences!.getStringList(key);
    if (valueSp != null) {
      SecureStorage.sharedPreferences!.remove(key);
      await SecureStorage.setStringList(key, valueSp);
      return valueSp;
    }

    // Secure storage'dan oku
    String? value = await SecureStorage.secureStorage!.read(key: key);
    if (value == null) return defaultValue;

    try {
      final decoded = jsonDecode(value);
      if (decoded is List) {
        return decoded.cast<String>();
      }
    } catch (_) {
      return defaultValue;
    }

    return defaultValue;
  }

  static Future<List<String>> getStringList(
    String key, {
    List<String> defaultValue = const [],
  }) async {
    return await SecureStorage.getStringListNullable(
          key,
          defaultValue: defaultValue,
        ) ??
        defaultValue;
  }

  static Future<void> setStringList(String key, List<String> value) async {
    await SecureStorage.checkInit();
    await SecureStorage.secureStorage!.write(
      key: key,
      value: jsonEncode(value),
    );
  }

  static Future<int?> getIntNullable(
    String key, {
    int? defaultValue = 0,
  }) async {
    await SecureStorage.checkInit();
    int? valueSp = SecureStorage.sharedPreferences!.getInt(key);
    if (valueSp != null) {
      SecureStorage.sharedPreferences!.remove(key);
      SecureStorage.setInt(key, valueSp);
      return valueSp;
    }
    String? value = await SecureStorage.secureStorage!.read(key: key);
    return value != null ? int.parse(value) : defaultValue;
  }

  static Future<int> getInt(String key, {int defaultValue = 0}) async {
    return await SecureStorage.getIntNullable(
          key,
          defaultValue: defaultValue,
        ) ??
        defaultValue;
  }

  static Future<void> setInt(String key, int value) async {
    await SecureStorage.checkInit();
    await SecureStorage.secureStorage!.write(key: key, value: value.toString());
  }

  static Future<bool?> getBoolNullable(String key, {bool? defaultValue}) async {
    await SecureStorage.checkInit();
    bool? valueSp = SecureStorage.sharedPreferences!.getBool(key);
    if (valueSp != null) {
      SecureStorage.sharedPreferences!.remove(key);
      SecureStorage.setBool(key, valueSp);
      return valueSp;
    }
    String? value = await SecureStorage.secureStorage!.read(key: key);
    return value != null ? bool.parse(value) : defaultValue;
  }

  static Future<bool> getBool(String key, {bool defaultValue = false}) async {
    return await SecureStorage.getBoolNullable(
          key,
          defaultValue: defaultValue,
        ) ??
        defaultValue;
  }

  static Future<void> setBool(String key, bool value) async {
    await SecureStorage.checkInit();
    await SecureStorage.secureStorage!.write(key: key, value: value.toString());
  }

  static Future<void> delete(String key) async {
    await SecureStorage.checkInit();
    await SecureStorage.sharedPreferences!.remove(key);
    await SecureStorage.secureStorage!.delete(key: key);
  }
}
