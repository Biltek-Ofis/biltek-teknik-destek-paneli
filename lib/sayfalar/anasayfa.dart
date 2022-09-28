import 'dart:async';

import 'package:biltekbilgisayar/widget/liste.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

import '../model/cihaz.dart';
import '../ozellikler/veriler.dart';
import '../veritabani/cihazlar.dart';
import '../veritabani/kullanici.dart';
import '../widget/menuler.dart';
import 'sayfa.dart';
import 'statefulwidget.dart';

class Anasayfa extends VarsayilanStatefulWidget {
  const Anasayfa({super.key});

  @override
  State<Anasayfa> createState() => _AnasayfaState();
}

class _AnasayfaState extends VarsayilanStatefulWidgetState<Anasayfa> {
  List<CihazModel> cihazlarTumu = [];
  List<CihazModel> cihazlar = [];
  List<CihazModel> filtreliCihazlar = [];

  CihazSiralama cihazSiralama = CihazSiralama.varsayilan;
  bool asc = false;

  final ScrollController scrollController = ScrollController();
  final TextEditingController textEditingController = TextEditingController();

  bool yukariGit = false;

  bool yukleniyor = false, hepsiYuklendi = false;
  int ilkOge = 0, yuklenecekOge = 50;
  Timer? zamanlayici;

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
          cihazlarTumu = CihazModel.siralaVarsayilan(value);
        });
      }
      cihazlariGetir();
      zamanlayici = Timer.periodic(const Duration(seconds: 5), (Timer t) async {
        List<CihazModel> cihazlarTemp = await Cihazlar.getir() ?? [];
        for (var cihazTemp in cihazlarTemp) {
          int index =
              cihazlarTumu.indexWhere((element) => element.id == cihazTemp.id);
          if (index > -1) {
            if (cihazlarTumu[index] != cihazTemp) {
              setState(() {
                cihazlarTumu[index] = cihazTemp;
              });
            }
          } else {
            setState(() {
              cihazlarTumu.insert(0, cihazTemp);
            });
            cihazTemp.yeni = true;
            setState(() {
              cihazlar.insert(0, cihazTemp);
              cihazlar.removeAt(cihazlar.length - 1);
            });
            cihazTemp.yeni = false;
          }
          String text = textEditingController.text;
          bool filtreli = false;
          if (text.isNotEmpty) {
            filtreli = CihazModel.filtre(cihaz: cihazTemp, text: text);
          }
          if (filtreli) {
            cihazTemp.yeni = true;
            int filtreIndex = filtreliCihazlar
                .indexWhere((element) => element.id == cihazTemp.id);
            if (filtreIndex > -1) {
              if (filtreliCihazlar[filtreIndex] != cihazTemp) {
                setState(() {
                  filtreliCihazlar[filtreIndex] = cihazTemp;
                });
              }
            } else {
              setState(() {
                filtreliCihazlar.insert(0, cihazTemp);
              });
            }
            cihazTemp.yeni = false;
          }
        }
      });
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
            return CihazModel.filtre(cihaz: element, text: text);
          }).toList();
        });
      } else {
        setState(() {
          filtreliCihazlar = [];
        });
      }
    });
  }

  temizle() {
    setState(() {
      hepsiYuklendi = false;
      cihazlar.clear();
      ilkOge = 0;
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
    zamanlayici?.cancel();
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
      icerik: LayoutBuilder(
        builder: (context, constraints) {
          if (cihazlar.isNotEmpty || filtreliCihazlar.isNotEmpty) {
            return Stack(
              children: [
                Positioned(
                  top: 0,
                  child: Container(
                    color: Colors.white,
                    width: MediaQuery.of(context).size.width,
                    height: 50,
                    alignment: Alignment.centerRight,
                    child: TextField(
                      controller: textEditingController,
                      decoration: const InputDecoration(hintText: "Ara"),
                    ),
                  ),
                ),
                Positioned(
                  top: 50,
                  bottom: yukleniyor ? 80 : 0,
                  left: 0,
                  right: 0,
                  child: CihazListesi(
                    controller: scrollController,
                    cihazlar:
                        filtreliCihazlar.isEmpty ? cihazlar : filtreliCihazlar,
                    ekCount: (hepsiYuklendi ? 1 : 0),
                    cihazSiralama: cihazSiralama,
                    asc: asc,
                    cihazTiklandi: (index) {
                      setState(() {
                        if (filtreliCihazlar.isEmpty) {
                          setState(() {
                            cihazlar[index].yeni = false;
                          });
                        } else {
                          filtreliCihazlar[index].yeni = false;
                        }
                      });
                    },
                    sirala: (konum, artan) {
                      temizle();
                      if (cihazSiralama == konum) {
                        setState(() {
                          asc = !artan;
                        });
                      } else {
                        setState(() {
                          asc = false;
                        });
                      }
                      setState(() {
                        cihazSiralama = konum;
                      });
                      if (kDebugMode) {
                        print("ASC: $asc");
                      }
                      setState(() {
                        cihazlarTumu = CihazModel.sirala(
                          cihazlar: cihazlarTumu,
                          cihazSiralama: konum,
                          asc: asc,
                        );
                      });
                      cihazlariGetir();
                    },
                  ),
                ),
                if (yukleniyor)
                  Positioned(
                    width: constraints.maxWidth,
                    bottom: 0,
                    child: Container(
                      color: Colors.white,
                      height: 80,
                      width: MediaQuery.of(context).size.width,
                      alignment: Alignment.center,
                      child: const CircularProgressIndicator(),
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
