import 'package:flutter/material.dart';

class Renkler {
  static Color? arka(String renkClass) {
    int alpha = (255 * 0.3).floor();
    switch (renkClass) {
      case "bg-white":
        return Colors.white;
      case "bg-dark":
        return Colors.black;
      case "bg-secondary":
        return Color.fromARGB(alpha, 108, 117, 125);
      case "bg-primary":
        return Color.fromARGB(alpha, 0, 123, 255);
      case "bg-success":
        return Color.fromARGB(alpha, 40, 167, 69);
      case "bg-danger":
        return Color.fromARGB(alpha, 220, 53, 69);
      case "bg-pink":
        return Color.fromARGB(alpha, 232, 62, 140);
      case "bg-warning":
        return Color.fromARGB(alpha, 255, 193, 7);

      default:
        return Colors.white;
    }
  }

  static Color? yazi(String renkClass) {
    switch (renkClass) {
      case "bg-dark":
        return Colors.white;
      /*case "bg-white":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-secondary":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-primary":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-success":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-danger":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-pink":
        Color.fromARGB(255, 31, 45, 61);
      case "bg-warning":
        Color.fromARGB(255, 31, 45, 61);*/

      default:
        return Color.fromARGB(255, 31, 45, 61);
    }
  }
}
