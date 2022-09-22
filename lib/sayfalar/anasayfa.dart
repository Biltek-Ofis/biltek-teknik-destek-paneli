import 'package:biltekbilgisayar/ozellikler/cihaz_bilgileri.dart';
import 'package:biltekbilgisayar/widget/liste.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:turkish/turkish.dart';

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
  List<CihazModel> filtreliCihazlar = [];

  final ScrollController scrollController = ScrollController();
  final TextEditingController textEditingController = TextEditingController();

  bool yukariGit = false;

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
          !yukleniyor &&
          filtreliCihazlar.isEmpty) {
        cihazlariGetir();
      }
      if (scrollController.offset > 0) {
        setState(() {
          yukariGit = true;
        });
      } else {
        setState(() {
          yukariGit = false;
        });
      }
    });
    textEditingController.addListener(() {
      String text = textEditingController.text;
      if (text.isNotEmpty) {
        setState(() {
          filtreliCihazlar = cihazlarTumu.where((element) {
            return element.servisNo
                    .toLowerCaseTr()
                    .contains(text.toLowerCaseTr()) ||
                element.musteriAdi
                    .toLowerCaseTr()
                    .contains(text.toLowerCaseTr()) ||
                element.adres.toLowerCaseTr().contains(text.toLowerCaseTr()) ||
                element.telefonNumarasi
                    .replaceAll("_", "")
                    .replaceAll("(", "")
                    .replaceAll(")", "")
                    .toLowerCaseTr()
                    .contains(text.toLowerCaseTr()) ||
                element.telefonNumarasi
                    .toLowerCaseTr()
                    .contains(text.toLowerCaseTr()) ||
                element.sorumlu
                    .toLowerCaseTr()
                    .contains(text.toLowerCaseTr()) ||
                element.cihaz.toLowerCaseTr().contains(text.toLowerCaseTr()) ||
                element.cihazModeli
                    .toLowerCaseTr()
                    .contains(text.toLowerCaseTr()) ||
                element.tarih.toLowerCaseTr().contains(text.toLowerCaseTr()) ||
                cihazDurumuGetir(element.guncelDurum)
                    .contains(text.toLowerCaseTr());
          }).toList();
        });
      } else {
        setState(() {
          filtreliCihazlar = [];
        });
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
      icerik: LayoutBuilder(
        builder: (context, constraints) {
          if (cihazlar.isNotEmpty || filtreliCihazlar.isNotEmpty) {
            return Column(
              children: [
                Container(
                  width: MediaQuery.of(context).size.width,
                  alignment: Alignment.centerRight,
                  child: TextField(
                    controller: textEditingController,
                    decoration: const InputDecoration(hintText: "Ara"),
                  ),
                ),
                Expanded(
                  child: CihazListesi(
                    controller: scrollController,
                    cihazlar:
                        filtreliCihazlar.isEmpty ? cihazlar : filtreliCihazlar,
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
