import 'package:biltekbilgisayar/widget/liste.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

import '../model/cihaz.dart';
import '../ozellikler/veriler.dart';
import '../veritabani/cihazlar.dart';
import '../veritabani/kullanici.dart';
import '../widget/menuler.dart';
import 'sayfa.dart';

class Anasayfa extends StatefulWidget {
  const Anasayfa({super.key});

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends State<Anasayfa> {
  List<CihazModel> cihazlarTumu = [];
  List<CihazModel> cihazlar = [];

  final ScrollController scrollController = ScrollController();

  bool yukleniyor = false, hepsiYuklendi = false;
  int ilkOge = 0, yuklenecekOge = 50;

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

    Cihazlar.getir().then((value) {
      if (value != null) {
        setState(() {
          cihazlarTumu = CihazModel.siralaVarsayilanDesc(value);
        });
      }
      cihazlariGetir();
    });
    scrollController.addListener(() {
      if (scrollController.position.pixels >=
              scrollController.position.maxScrollExtent &&
          !yukleniyor) {
        cihazlariGetir();
      }
    });
  }

  cihazlariGetir() async {
    if (hepsiYuklendi) {
      return;
    }
    setState(() {
      yukleniyor = true;
    });
    await Future.delayed(const Duration(milliseconds: 500));
    int yuklenecekOgeIndex =
        cihazlar.length + yuklenecekOge < cihazlarTumu.length
            ? cihazlar.length + yuklenecekOge
            : cihazlarTumu.length;
    List<CihazModel> temp = cihazlar.length == cihazlarTumu.length
        ? []
        : cihazlarTumu.getRange(ilkOge, yuklenecekOgeIndex).toList();
    if (kDebugMode) {
      print("$ilkOge/$yuklenecekOgeIndex arasındaki cihazlar getirildi.");
    }
    if (temp.isNotEmpty) {
      setState(() {
        cihazlar.addAll(temp);
        ilkOge += yuklenecekOge;
      });
    }
    setState(() {
      yukleniyor = false;
      hepsiYuklendi = temp.isEmpty;
    });
  }

  @override
  void dispose() {
    super.dispose();
    scrollController.dispose();
  }

  @override
  Widget build(BuildContext context) {
    int yatayOgeSayisi = 2;
    if (MediaQuery.of(context).size.width > 1000) {
      yatayOgeSayisi = 2;
    } else {
      yatayOgeSayisi = 1;
    }
    return Sayfa(
      menu: const AnaMenu(
        seciliSayfa: "Anasayfa",
      ),
      baslik: "Anasayfa",
      icerik: LayoutBuilder(
        builder: (context, constraints) {
          if (cihazlar.isNotEmpty) {
            return Column(
              children: [
                Expanded(
                  child: CihazListesi(
                    controller: scrollController,
                    cihazlar: cihazlar,
                    yatayOgeSayisi: yatayOgeSayisi,
                    ekCount: (hepsiYuklendi ? 1 : 0),
                  ),
                ),
                if (yukleniyor)
                  SizedBox(
                    width: constraints.maxWidth,
                    height: 80,
                    child: const Center(
                      child: CircularProgressIndicator(),
                    ),
                  ),
              ],
            );
          } else {
            return SizedBox(
              width: MediaQuery.of(context).size.width,
              height: MediaQuery.of(context).size.height,
              child: const Center(
                child: CircularProgressIndicator(),
              ),
            );
          }
        },
      ),
    );
  }
}
