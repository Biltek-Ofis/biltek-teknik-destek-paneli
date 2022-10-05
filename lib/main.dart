import 'package:flutter/material.dart';

import 'ozellikler/yonlendirme.dart';
import 'sayfalar/splash.dart';

void main() {
  Yonlendirme.routerAyarla();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return const SplashScreen();
  }
}
