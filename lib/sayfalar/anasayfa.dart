import 'package:biltekbilgisayar/veritabani/kullanici.dart';
import 'package:biltekbilgisayar/ozellikler/veriler.dart';
import 'package:flutter/material.dart';

import '../env.dart';
import 'sayfa_gorunumu.dart';
import '../widget/menuler.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({super.key});

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends State<Anasayfa> {
  @override
  void initState() {
    KullaniciBilgileri.getir().then((value) {
      setState(() {
        Veriler.kullaniciBilgileri = value;
      });
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return SayfaGorunumu(
      menu: const AnaMenu(
        seciliSayfa: "Anasayfa",
      ),
      baslik: Env.uygulamaAdi,
      icerik: const Center(
        child: Text("Anasayfa"),
      ),
    );
  }
}
