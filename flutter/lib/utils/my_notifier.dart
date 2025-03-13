import 'package:flutter/material.dart';

import 'shared_preferences.dart';

class MyNotifier extends ChangeNotifier {
  late bool? _isDark;
  bool? get isDark => _isDark;

  late String? _username;
  String? get username => _username;

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

  set username(String? value) {
    _username = value;
    if (value != null) {
      SharedPreference.setString(SharedPreference.usernameString, value);
    } else {
      SharedPreference.remove(SharedPreference.usernameString);
    }
    notifyListeners();
  }

  getPreferences() async {
    _isDark = await SharedPreference.getBool(SharedPreference.darkThemeString);
    _username =
        await SharedPreference.getString(SharedPreference.usernameString);
    notifyListeners();
  }
}
