import 'package:flutter/material.dart';

class AnaMenuModel {
  AnaMenuModel({
    required this.baslik,
    required this.onPressed,
    this.icon,
  });
  IconData? icon;
  String baslik;
  VoidCallback onPressed;
}
