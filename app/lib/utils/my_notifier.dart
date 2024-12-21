import 'package:flutter/material.dart';

import 'shared_preferences.dart';

class MyNotifier extends ChangeNotifier {
  late bool? _isDark;
  bool? get isDark => _isDark;

  MyNotifier() {
    _isDark = false;
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

  getPreferences() async {
    _isDark = await SharedPreference.getBool(SharedPreference.darkThemeString);
    notifyListeners();
  }
}
