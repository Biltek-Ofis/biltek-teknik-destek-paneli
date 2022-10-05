import 'package:biltekbilgisayar/sayfalar/statefulwidget.dart';
import 'package:flutter/material.dart';

import 'env.dart';
import 'ozellikler/sp.dart';
import 'sayfalar/anasayfa.dart';
import 'sayfalar/cihazlarim.dart';
import 'sayfalar/giris.dart';

void main() {
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

class SplashScreen extends VarsayilanStatefulWidget {
  const SplashScreen({super.key});

  static const String yol = "/splash";

  @override
  VarsayilanStatefulWidgetState<SplashScreen> createState() =>
      SplashScreenState();
}

class SplashScreenState extends VarsayilanStatefulWidgetState<SplashScreen> {
  String? initialRoute;

  @override
  void initState() {
    super.initState();
    SharedPref.girisDurumu().then((value) {
      setState(() {
        initialRoute = value ? Anasayfa.yol : GirisYap.yol;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return initialRoute == null
        ? Container()
        : MaterialApp(
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
            initialRoute: initialRoute,
            routes: {
              Anasayfa.yol: (context) => const Anasayfa(),
              SplashScreen.yol: (context) => const SplashScreen(),
              GirisYap.yol: (context) => const GirisYap(),
              Cihazlarim.yol: (context) => const Cihazlarim(),
            },
          );
  }
}
