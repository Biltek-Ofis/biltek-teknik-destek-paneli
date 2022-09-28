import 'package:flutter/material.dart';

import 'env.dart';
import 'ozellikler/sp.dart';
import 'sayfalar/anasayfa.dart';
import 'sayfalar/giris.dart';
import 'sayfalar/statefulwidget.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: SharedPref.girisDurumu(),
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting ||
            !snapshot.hasData) {
          return materialAppDef(const SplashScreen());
        } else {
          if (snapshot.data == true) {
            return materialAppDef(const Anasayfa());
          } else {
            return materialAppDef(const GirisYap());
          }
        }
      },
    );
  }
}

Widget materialAppDef(Widget widget) {
  return MaterialApp(
    title: Env.uygulamaAdi,
    debugShowCheckedModeBanner: false,
    theme: ThemeData(
      primarySwatch: const MaterialColor(0xFF343A40, {
        50: Color.fromRGBO(52, 58, 64, .1),
        100: Color.fromRGBO(52, 58, 64, .2),
        200: Color.fromRGBO(52, 58, 64, .3),
        300: Color.fromRGBO(52, 58, 64, .4),
        400: Color.fromRGBO(52, 58, 64, .5),
        500: Color.fromRGBO(52, 58, 64, .6),
        600: Color.fromRGBO(52, 58, 64, .7),
        700: Color.fromRGBO(52, 58, 64, .8),
        800: Color.fromRGBO(52, 58, 64, .9),
        900: Color.fromRGBO(52, 58, 64, 1),
      }),
      scaffoldBackgroundColor: Colors.white,
    ),
    home: widget,
  );
}

class SplashScreen extends VarsayilanStatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends VarsayilanStatefulWidgetState<SplashScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(),
    );
  }
}
