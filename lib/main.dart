import 'package:flutter/material.dart';

import 'env.dart';
import 'home.dart';
import 'login.dart';
import 'utils/sp.dart';

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
      primarySwatch: Colors.blue,
      scaffoldBackgroundColor: Colors.white,
    ),
    home: widget,
  );
}

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(),
    );
  }
}
