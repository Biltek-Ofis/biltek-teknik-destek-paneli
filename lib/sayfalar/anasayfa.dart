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

  Widget bilgiler({
    required String baslik,
    required String aciklama,
  }) {
    return Container(
      decoration: const BoxDecoration(
        border: Border(
          bottom: BorderSide(width: 1.5, color: Colors.grey),
        ),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            baslik,
            style: const TextStyle(
              fontWeight: FontWeight.bold,
            ),
          ),
          Text(aciklama),
        ],
      ),
    );
  }

  Widget gridView({
    required BuildContext context,
    required List<CihazModel> cihazListe,
    required int yatayOgeSayisi,
    int ekCount = 0,
  }) {
    double ogeGenisligi = MediaQuery.of(context).size.width / yatayOgeSayisi;
    double ogeYuksekligi = 140;
    return GridView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: yatayOgeSayisi,
        childAspectRatio: (ogeGenisligi / ogeYuksekligi),
      ),
      itemCount: cihazListe.length + ekCount,
      itemBuilder: (context, index) {
        if (index < cihazListe.length) {
          return Card(
            elevation: 8,
            child: ListTile(
              tileColor: cihazDurumuColorGetir(
                cihazListe[index].guncelDurum,
              ),
              title: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  bilgiler(
                    baslik: "Servis No: ",
                    aciklama: cihazListe[index].servisNo,
                  ),
                  bilgiler(
                    baslik: "Müşteri Adı: ",
                    aciklama: cihazListe[index].musteriAdi,
                  ),
                  bilgiler(
                    baslik: "Cihaz: ",
                    aciklama:
                        "${cihazListe[index].cihaz} ${cihazListe[index].cihazModeli}",
                  ),
                  bilgiler(
                    baslik: "Giriş Tarihi: ",
                    aciklama: cihazListe[index].tarih,
                  ),
                  bilgiler(
                    baslik: "Güncel Durum: ",
                    aciklama: cihazDurumuGetir(cihazListe[index].guncelDurum),
                  ),
                ],
              ),
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
    );
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
            return Stack(
              children: [
                ListView(
                  controller: scrollController,
                  scrollDirection: Axis.vertical,
                  children: [
                    for (int i = 0; i < cihazDurumuSiralama.length; i++)
                      Column(
                        children: [
                          Text(
                            cihazDurumuGetir(cihazDurumuSiralama[i]),
                            style: const TextStyle(
                              fontWeight: FontWeight.bold,
                              fontSize: 20,
                            ),
                          ),
                          gridView(
                            context: context,
                            cihazListe: cihazlar.where((element) {
                              return element.guncelDurum ==
                                  cihazDurumuSiralama[i];
                            }).toList(),
                            yatayOgeSayisi: yatayOgeSayisi,
                            ekCount: (hepsiYuklendi ? 1 : 0),
                          ),
                        ],
                      ),
                  ],
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
