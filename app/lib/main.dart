import 'package:flutter/material.dart';

import 'models/kullanici.dart';
import 'sayfalar/anasayfa.dart';
import 'sayfalar/giris_sayfasi.dart';
import 'utils/post.dart';
import 'utils/shared_preferences.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Biltek Teknik Servis',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: const MainPage(),
    );
  }
}

class MainPage extends StatelessWidget {
  const MainPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: FutureBuilder<String?>(
        future: SharedPreference.getString(SharedPreference.authString),
        builder: (context, AsyncSnapshot<String?> snapshot) {
          debugPrint("1");
          if (snapshot.connectionState == ConnectionState.done) {
            debugPrint("2");
            if (snapshot.hasData && snapshot.data != null) {
              debugPrint("3");
              return FutureBuilder<KullaniciModel?>(
                future: BiltekPost.kullaniciGetir(snapshot.data!),
                builder: (context, AsyncSnapshot<KullaniciModel?> snapshot) {
                  debugPrint("4");
                  if (snapshot.connectionState == ConnectionState.done) {
                    debugPrint("5");
                    if (snapshot.hasData && snapshot.data != null) {
                      debugPrint("6");
                      return Anasayfa(kullanici: snapshot.data!);
                    }
                  }
                  return GirisSayfasi();
                },
              );
            } else {
              return GirisSayfasi();
            }
          } else {
            return Center(
              child: CircularProgressIndicator(),
            );
          }
        },
      ),
    );
  }
}
