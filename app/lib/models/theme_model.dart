import 'package:flutter/material.dart';

class ThemeModel {
  static List<Color> chartColors = [
    Colors.purple,
    Colors.yellow,
  ];
  static ThemeData get dark {
    Color buttonColor = const Color.fromARGB(255, 54, 54, 54);
    Color buttonHoverColor = const Color.fromARGB(255, 43, 42, 42);
    return ThemeData.dark(useMaterial3: true).copyWith(
      buttonTheme: ButtonThemeData(
        buttonColor: buttonColor,
        splashColor: buttonHoverColor,
        hoverColor: buttonHoverColor,
        highlightColor: buttonHoverColor,
        colorScheme: ColorScheme.fromSeed(
          seedColor: buttonColor,
          surface: buttonColor,
        ),
      ),
      appBarTheme: AppBarTheme(
        color: buttonColor,
        iconTheme: const IconThemeData(
          color: Colors.white,
        ),
        titleTextStyle: const TextStyle(color: Colors.white, fontSize: 20),
      ),
      iconTheme: const IconThemeData(
        color: Colors.white,
      ),
      colorScheme: ColorScheme.dark(primary: Colors.blue),
    );
  }

  static ThemeData get light {
    return ThemeData.light(useMaterial3: true).copyWith(
      buttonTheme: ButtonThemeData(
        buttonColor: Colors.white,
        colorScheme: ColorScheme.fromSeed(
          seedColor: Colors.white,
          surface: Colors.white,
        ),
      ),
      appBarTheme: const AppBarTheme(
        color: Colors.blue,
        iconTheme: IconThemeData(
          color: Colors.white,
        ),
        titleTextStyle: TextStyle(color: Colors.white, fontSize: 20),
      ),
      iconTheme: const IconThemeData(
        color: Colors.black,
      ),
      colorScheme: ColorScheme.light(primary: Colors.blue),
    );
  }
}
