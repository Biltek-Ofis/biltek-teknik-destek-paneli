import 'package:flutter/material.dart';

import '../ozellikler/veriler.dart';
import '../veritabani/kullanici.dart';
import '../widget/liste.dart';
import '../widget/menuler.dart';
import 'sayfa.dart';
import 'statefulwidget.dart';

class Anasayfa extends VarsayilanStatefulWidget {
  const Anasayfa({super.key});

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends VarsayilanStatefulWidgetState<Anasayfa> {
  final ScrollController scrollController = ScrollController();

  bool yukariGit = false;
  @override
  void initState() {
    KullaniciBilgileri.getir().then((value) {
      if (value != null) {
        setState(() {
          Veriler.kullaniciBilgileri = value;
        });
      }
    });
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
    scrollController.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Sayfa(
      menu: const AnaMenu(
        seciliSayfa: "Anasayfa",
      ),
      floatingActionButton: yukariGit
          ? FloatingActionButton(
              child: const Icon(Icons.arrow_upward),
              onPressed: () {
                scrollController.animateTo(
                  0.0,
                  curve: Curves.easeOut,
                  duration: const Duration(milliseconds: 300),
                );
              })
          : null,
      baslik: "Anasayfa",
      icerik: CihazListesi(
        controller: scrollController,
        yukariGitButonDurumu: (durum) {
          setState(() {
            yukariGit = durum;
          });
        },
      ),
    );
  }
}
