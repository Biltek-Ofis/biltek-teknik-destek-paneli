import 'package:biltekbilgisayar/ozellikler/cihaz_bilgileri.dart';
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
      setState(() {
        Veriler.kullaniciBilgileri = value;
      });
    });
    super.initState();

    Cihazlar.getir().then((value) {
      setState(() {
        cihazlarTumu = CihazModel.siralaVarsayilanDesc(value);
      });
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
    return Sayfa(
      menu: const AnaMenu(
        seciliSayfa: "Anasayfa",
      ),
      baslik: "Anasayfa",
      icerik: LayoutBuilder(
        builder: (context, constraints) {
          if (cihazlar.isNotEmpty) {
            return Stack(
              children: [
                ListView.separated(
                  controller: scrollController,
                  itemBuilder: (context, index) {
                    if (index < cihazlar.length) {
                      return ListTile(
                        tileColor:
                            cihazDurumuColorGetir(cihazlar[index].guncelDurum),
                        title: Text(
                          "${cihazlar[index].tarih} ${cihazDurumuGetir(cihazlar[index].guncelDurum)}",
                        ),
                      );
                    } else {
                      return Container(); /*SizedBox(
                        width: constraints.maxWidth,
                        height: 59,
                        child: const Center(
                          child: Text(
                            "Gösterilecek başka cihaz yok.",
                            style: TextStyle(
                              fontSize: 20,
                            ),
                          ),
                        ),
                      );*/
                    }
                  },
                  separatorBuilder: (context, index) {
                    return const Divider(
                      height: 1,
                    );
                  },
                  itemCount: cihazlar.length + (hepsiYuklendi ? 1 : 0),
                ),
                if (yukleniyor)
                  Positioned(
                    left: 0,
                    bottom: 0,
                    child: SizedBox(
                      width: constraints.maxWidth,
                      height: 80,
                      child: const Center(
                        child: CircularProgressIndicator(),
                      ),
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
