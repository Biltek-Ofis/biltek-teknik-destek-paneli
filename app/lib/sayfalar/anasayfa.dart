import 'package:flutter/material.dart';
import 'package:teknikservis/sayfalar/cihazlar.dart';

import '../models/kullanici.dart';
import '../widgets/scaffold.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({super.key, required this.kullanici});

  final KullaniciModel kullanici;

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends State<Anasayfa> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: biltekDrawer(
        context,
        kullanici: widget.kullanici,
        seciliSayfa: "Anasayfa",
      ),
      appBar: biltekAppBar(
        context,
        title: widget.kullanici.adSoyad,
      ),
      body: CihazlarSayfasi(),
    );
  }
}
