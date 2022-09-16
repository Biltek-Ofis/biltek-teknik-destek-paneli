import 'package:flutter/material.dart';

import 'login.dart';
import 'utils/sp.dart';
import 'widgets/buttons.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({super.key});

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends State<Anasayfa> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        padding: EdgeInsets.zero,
        alignment: Alignment.center,
        width: MediaQuery.of(context).size.width,
        height: MediaQuery.of(context).size.height,
        child: buttonDef(
          width: 200,
          height: 50,
          text: "Çıkış Yap",
          onPressed: () {
            SharedPref.girisDurumuSil().then((value) {
              if (value) {
                Navigator.pushAndRemoveUntil(
                  context,
                  MaterialPageRoute(
                    builder: (context) => const GirisYap(),
                  ),
                  (route) => false,
                );
              }
            });
          },
        ),
      ),
    );
  }
}
