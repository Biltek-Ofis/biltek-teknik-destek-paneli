import 'dart:convert';

import 'package:flutter/material.dart';

import 'shared_preferences.dart';

class MyNotifier extends ChangeNotifier {
  late bool? _isDark;
  bool? get isDark => _isDark;

  late SPKullanici? _kullanici;
  SPKullanici? get kullanici => _kullanici;

  MyNotifier() {
    _isDark = false;
    _kullanici = null;
    getPreferences();
  }

  //Switching the themes
  set isDark(bool? value) {
    _isDark = value;
    if (value != null) {
      SharedPreference.setBool(SharedPreference.darkThemeString, value);
    } else {
      SharedPreference.remove(SharedPreference.darkThemeString);
    }
    notifyListeners();
  }

  set kullanici(SPKullanici? value) {
    _kullanici = value;
    if (value != null) {
      SharedPreference.setString(
        SharedPreference.kullaniciString,
        value.toString(),
      );
    } else {
      SharedPreference.remove(SharedPreference.kullaniciString);
    }
    notifyListeners();
  }

  void getPreferences() async {
    _isDark = await SharedPreference.getBool(SharedPreference.darkThemeString);
    String? kullaniciString = await SharedPreference.getString(
      SharedPreference.kullaniciString,
    );
    if (kullaniciString != null) {
      _kullanici = SPKullanici.fromJson(
        jsonDecode(kullaniciString) as Map<String, dynamic>,
      );
    }
    notifyListeners();
  }
}
