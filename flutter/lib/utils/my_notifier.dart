import 'dart:convert';

import 'package:flutter/foundation.dart';

import '../models/secure_storage_kullanici.dart';
import 'secure_storage.dart';

class MyNotifier extends ChangeNotifier {
  late bool? _isDark;
  bool? get isDark => _isDark;

  late SecureStorageKullanici? _kullanici;
  SecureStorageKullanici? get kullanici => _kullanici;

  MyNotifier() {
    _isDark = false;
    _kullanici = null;
    getPreferences();
  }

  //Switching the themes
  set isDark(bool? value) {
    _isDark = value;
    if (value != null) {
      SecureStorage.setBool(SecureStorage.darkThemeString, value);
    } else {
      SecureStorage.delete(SecureStorage.darkThemeString);
    }
    notifyListeners();
  }

  set kullanici(SecureStorageKullanici? value) {
    _kullanici = value;
    if (value != null) {
      if (kIsWeb) {
        value.sifreyiCoz();
        value.sifre = "";
      }
      SecureStorage.setString(SecureStorage.kullaniciString, value.toString());
    } else {
      SecureStorage.delete(SecureStorage.kullaniciString);
    }
    notifyListeners();
  }

  void getPreferences() async {
    _isDark = await SecureStorage.getBool(SecureStorage.darkThemeString);
    String? kullaniciString = await SecureStorage.getStringNullable(
      SecureStorage.kullaniciString,
    );
    if (kullaniciString != null) {
      _kullanici = SecureStorageKullanici.fromJson(
        jsonDecode(kullaniciString) as Map<String, dynamic>,
      );
    }
    notifyListeners();
  }
}
