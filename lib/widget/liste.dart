import 'dart:async';

import 'package:biltekbilgisayar/widget/list_tile.dart';
import 'package:flutter/material.dart';

import '../model/cihaz.dart';
import '../ozellikler/cihaz_bilgileri.dart';
import '../ozellikler/yonlendirme.dart';
import '../sayfalar/detaylar.dart';
import '../sayfalar/statefulwidget.dart';
import '../veritabani/cihazlar.dart';

typedef YukariGitButonDurumu = void Function(bool durum);

class CihazListesi extends VarsayilanStatefulWidget {
  const CihazListesi({
    super.key,
    required this.controller,
    this.yukariGitButonDurumu,
    this.kullaniciID = 0,
  });
  final ScrollController controller;
  final YukariGitButonDurumu? yukariGitButonDurumu;
  final int kullaniciID;

  @override
  State<CihazListesi> createState() => _CihazListesiState();
}

class _CihazListesiState extends VarsayilanStatefulWidgetState<CihazListesi> {
  List<CihazModel> cihazlarTumu = [];
  List<CihazModel> cihazlar = [];
  List<CihazModel> filtreliCihazlar = [];

  CihazSiralama cihazSiralama = CihazSiralama.varsayilan;
  bool asc = false;

  final TextEditingController textEditingController = TextEditingController();

  bool yukleniyor = false, hepsiYuklendi = false;
  int ilkOge = 0, yuklenecekOge = 50;
  Timer? zamanlayici;
  List<bool> menuAcikDurumu = [];
  List<bool> menuAcikDurumuFiltreli = [];

  bool getirildi = false;

  @override
  void initState() {
    super.initState();
    Cihazlar.getir(id: widget.kullaniciID).then((value) {
      if (value != null) {
        setState(() {
          cihazlarTumu = CihazModel.siralaVarsayilan(value);
        });
      }
      cihazlariGetir();
      zamanlayici = Timer.periodic(const Duration(seconds: 5), (Timer t) async {
        List<CihazModel> cihazlarTemp = await Cihazlar.getir(
              id: widget.kullaniciID,
            ) ??
            [];
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

            int menuCihazFarki = cihazlar.length - menuAcikDurumu.length;
            if (menuCihazFarki > 0) {
              setState(() {
                menuAcikDurumu
                    .addAll(List.generate(menuCihazFarki, (index) => false));
              });
            }
            setState(() {
              cihazlar.insert(0, cihazTemp);
              menuAcikDurumu.insert(0, false);
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

            int menuFiltreFarki =
                filtreliCihazlar.length - menuAcikDurumuFiltreli.length;
            if (menuFiltreFarki > 0) {
              setState(() {
                menuAcikDurumuFiltreli
                    .addAll(List.generate(menuFiltreFarki, (index) => false));
              });
            }
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
                menuAcikDurumuFiltreli.insert(0, false);
                filtreliCihazlar.insert(0, cihazTemp);
              });
            }
            cihazTemp.yeni = false;
          }
        }
      });
    });
    widget.controller.addListener(() {
      if (widget.controller.position.pixels >=
              widget.controller.position.maxScrollExtent &&
          !yukleniyor &&
          filtreliCihazlar.isEmpty) {
        cihazlariGetir();
      }
      widget.yukariGitButonDurumu?.call(widget.controller.offset > 0);
    });
    textEditingController.addListener(() {
      String text = textEditingController.text;
      if (text.isNotEmpty) {
        setState(() {
          filtreliCihazlar = cihazlarTumu.where((element) {
            return CihazModel.filtre(cihaz: element, text: text);
          }).toList();
        });
        setState(() {
          menuAcikDurumuFiltreli =
              List.generate(filtreliCihazlar.length, (index) => false);
        });
      } else {
        setState(() {
          filtreliCihazlar = [];
          menuAcikDurumuFiltreli = [];
        });
      }
    });
  }

  int ogeSayisi = 8;
  int yeniOgeSayisi = 8;
  double minOgeGenisligi = 150;
  double dahaFazlaButonBoyutu = 15;

  Widget dahaFazla({
    required String baslik,
    required String aciklama,
    required double width,
  }) {
    return SizedBox(
      width: width,
      child: Wrap(
        alignment: WrapAlignment.start,
        crossAxisAlignment: WrapCrossAlignment.start,
        children: [
          baslikText(text: baslik, fontSize: null),
          bilgilerText(text: aciklama),
        ],
      ),
    );
  }

  Widget dahaFazlaButon({required int index}) {
    return RawMaterialButton(
      onPressed: () {
        if (menuAcikDurumu.length > index) {
          setState(() {
            menuAcikDurumu[index] = !menuAcikDurumu[index];
          });
        }
      },
      elevation: 2.0,
      fillColor: Colors.blue,
      padding: const EdgeInsets.all(5.0),
      shape: const CircleBorder(),
      child: SizedBox(
        width: dahaFazlaButonBoyutu,
        height: dahaFazlaButonBoyutu,
        child: Center(
          child: Icon(
            (menuAcikDurumu.length > index)
                ? menuAcikDurumu[index]
                    ? Icons.remove
                    : Icons.add
                : Icons.add,
            size: 15.0,
            color: Colors.white,
          ),
        ),
      ),
    );
  }

  Widget baslik({
    required String baslik,
    required double width,
    CihazSiralama? sirala,
  }) {
    return Material(
      child: InkWell(
        onTap: () {
          if (sirala != null) {
            temizle();
            if (cihazSiralama == sirala) {
              setState(() {
                asc = !asc;
              });
            } else {
              setState(() {
                asc = false;
              });
            }
            setState(() {
              cihazSiralama = sirala;
            });
            setState(() {
              cihazlarTumu = CihazModel.sirala(
                cihazlar: cihazlarTumu,
                cihazSiralama: sirala,
                asc: asc,
              );
            });
            cihazlariGetir();
          }
        },
        child: Container(
          width: width,
          padding: const EdgeInsets.all(10),
          child: Wrap(
            alignment: WrapAlignment.spaceBetween,
            runAlignment: WrapAlignment.spaceBetween,
            crossAxisAlignment: WrapCrossAlignment.center,
            children: [
              baslikText(text: baslik),
              if (sirala != null)
                if (cihazSiralama == sirala)
                  asc
                      ? const Icon(
                          Icons.arrow_upward,
                          size: 20.0,
                        )
                      : const Icon(
                          Icons.arrow_downward,
                          size: 20.0,
                        ),
            ],
          ),
        ),
      ),
    );
  }

  @override
  void dispose() {
    super.dispose();
    zamanlayici?.cancel();
  }

  @override
  Widget build(BuildContext context) {
    yeniOgeSayisi = ogeSayisi;
    double cikarilacak = 17 + dahaFazlaButonBoyutu;
    bool ogeSayisiGetirildi = false;
    double tamBoyut = MediaQuery.of(context).size.width - cikarilacak;
    for (var index = ogeSayisi; index >= 1; index--) {
      if ((tamBoyut / index) >= minOgeGenisligi) {
        yeniOgeSayisi = index;
        ogeSayisiGetirildi = true;
        break;
      }
    }
    if (!ogeSayisiGetirildi) {
      yeniOgeSayisi = 1;
    }
    double ogeGenisligi = tamBoyut / yeniOgeSayisi;
    return LayoutBuilder(
      builder: (context, constraints) {
        if (getirildi) {
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
                child: Column(
                  children: [
                    Container(
                      color: Colors.white,
                      child: Row(
                        crossAxisAlignment: CrossAxisAlignment.center,
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          if (yeniOgeSayisi >= 2)
                            baslik(
                              baslik: "Servis No",
                              width: ogeGenisligi,
                              sirala: CihazSiralama.servisNo,
                            ),
                          baslik(
                            baslik: "Müşteri Adı",
                            width: ogeGenisligi,
                            sirala: CihazSiralama.musteriAdi,
                          ),
                          if (yeniOgeSayisi >= 3)
                            baslik(
                              baslik: "GSM",
                              width: ogeGenisligi,
                            ),
                          if (yeniOgeSayisi >= 4)
                            baslik(
                              baslik: "Tür",
                              width: ogeGenisligi,
                              sirala: CihazSiralama.tur,
                            ),
                          if (yeniOgeSayisi >= 5)
                            baslik(
                              baslik: "Cihaz",
                              width: ogeGenisligi,
                              sirala: CihazSiralama.cihazVeModel,
                            ),
                          if (yeniOgeSayisi >= 6)
                            baslik(
                              baslik: "Tarih",
                              width: ogeGenisligi,
                              sirala: CihazSiralama.tarih,
                            ),
                          if (yeniOgeSayisi >= 7)
                            baslik(
                              baslik: "Durum",
                              width: ogeGenisligi,
                              sirala: CihazSiralama.varsayilan,
                            ),
                          if (yeniOgeSayisi >= 8)
                            baslik(
                              baslik: "Sorumlu",
                              width: ogeGenisligi,
                              sirala: CihazSiralama.sorumlu,
                            ),
                        ],
                      ),
                    ),
                    (cihazlar.isNotEmpty || filtreliCihazlar.isNotEmpty)
                        ? Expanded(
                            child: ListView.separated(
                              controller: widget.controller,
                              scrollDirection: Axis.vertical,
                              itemBuilder: (context, index) {
                                if (index <
                                    (filtreliCihazlar.isEmpty
                                            ? cihazlar
                                            : filtreliCihazlar)
                                        .length) {
                                  Widget yeniWidgeti = Container(
                                    padding: const EdgeInsets.all(5),
                                    decoration: const BoxDecoration(
                                      shape: BoxShape.circle,
                                      color: Colors.red,
                                    ),
                                    height: 25,
                                    child: const Text(
                                      "Yeni",
                                      style: TextStyle(
                                        color: Colors.white,
                                        fontSize: 10,
                                      ),
                                      textAlign: TextAlign.center,
                                    ),
                                  );
                                  return CustomListTile(
                                    onTap: () {
                                      Yonlendirme.git(
                                        context,
                                        "${CihazDetaylari.yol}${CihazDetaylari.argumanlar(
                                          servisNo: (filtreliCihazlar.isEmpty
                                              ? cihazlar[index].servisNo
                                              : filtreliCihazlar[index]
                                                  .servisNo),
                                        )}",
                                      );
                                    },
                                    onHover: (hover) {
                                      if (hover) {
                                        if (filtreliCihazlar.isEmpty) {
                                          setState(() {
                                            cihazlar[index].yeni = false;
                                          });
                                        } else {
                                          setState(() {
                                            filtreliCihazlar[index].yeni =
                                                false;
                                          });
                                        }
                                      }
                                    },
                                    tileColor: cihazDurumuColorGetir(
                                      (filtreliCihazlar.isEmpty
                                              ? cihazlar
                                              : filtreliCihazlar)[index]
                                          .guncelDurum,
                                    ),
                                    title: Column(
                                      children: [
                                        Row(
                                          crossAxisAlignment:
                                              CrossAxisAlignment.center,
                                          mainAxisAlignment:
                                              MainAxisAlignment.center,
                                          children: [
                                            if (yeniOgeSayisi >= 2)
                                              bilgiler(
                                                aciklama: (filtreliCihazlar
                                                                .isEmpty
                                                            ? cihazlar
                                                            : filtreliCihazlar)[
                                                        index]
                                                    .servisNo,
                                                widget: ((filtreliCihazlar
                                                                    .isEmpty
                                                                ? cihazlar
                                                                : filtreliCihazlar)[
                                                            index]
                                                        .yeni)
                                                    ? yeniWidgeti
                                                    : null,
                                                width: ogeGenisligi,
                                                index: index,
                                              ),
                                            bilgiler(
                                              aciklama: (filtreliCihazlar
                                                          .isEmpty
                                                      ? cihazlar
                                                      : filtreliCihazlar)[index]
                                                  .musteriAdi,
                                              widget: (yeniOgeSayisi == 2 ||
                                                      yeniOgeSayisi == 1)
                                                  ? Row(
                                                      children: [
                                                        if (yeniOgeSayisi == 1)
                                                          yeniWidgeti,
                                                        dahaFazlaButon(
                                                            index: index),
                                                      ],
                                                    )
                                                  : null,
                                              width: ogeGenisligi,
                                              index: index,
                                            ),
                                            if (yeniOgeSayisi >= 3)
                                              bilgiler(
                                                aciklama: (filtreliCihazlar
                                                                .isEmpty
                                                            ? cihazlar
                                                            : filtreliCihazlar)[
                                                        index]
                                                    .telefonNumarasi,
                                                widget: (yeniOgeSayisi == 3)
                                                    ? dahaFazlaButon(
                                                        index: index)
                                                    : null,
                                                width: ogeGenisligi,
                                                index: index,
                                              ),
                                            if (yeniOgeSayisi >= 4)
                                              bilgiler(
                                                aciklama: (filtreliCihazlar
                                                                .isEmpty
                                                            ? cihazlar
                                                            : filtreliCihazlar)[
                                                        index]
                                                    .cihazTuru,
                                                widget: (yeniOgeSayisi == 4)
                                                    ? dahaFazlaButon(
                                                        index: index)
                                                    : null,
                                                width: ogeGenisligi,
                                                index: index,
                                              ),
                                            if (yeniOgeSayisi >= 5)
                                              bilgiler(
                                                aciklama:
                                                    "${(filtreliCihazlar.isEmpty ? cihazlar : filtreliCihazlar)[index].cihaz} ${(filtreliCihazlar.isEmpty ? cihazlar : filtreliCihazlar)[index].cihazModeli}",
                                                widget: (yeniOgeSayisi == 5)
                                                    ? dahaFazlaButon(
                                                        index: index)
                                                    : null,
                                                width: ogeGenisligi,
                                                index: index,
                                              ),
                                            if (yeniOgeSayisi >= 6)
                                              bilgiler(
                                                aciklama: (filtreliCihazlar
                                                                .isEmpty
                                                            ? cihazlar
                                                            : filtreliCihazlar)[
                                                        index]
                                                    .tarih,
                                                widget: (yeniOgeSayisi == 6)
                                                    ? dahaFazlaButon(
                                                        index: index)
                                                    : null,
                                                width: ogeGenisligi,
                                                index: index,
                                              ),
                                            if (yeniOgeSayisi >= 7)
                                              bilgiler(
                                                aciklama: cihazDurumuGetir(
                                                  (filtreliCihazlar.isEmpty
                                                              ? cihazlar
                                                              : filtreliCihazlar)[
                                                          index]
                                                      .guncelDurum,
                                                ),
                                                widget: (yeniOgeSayisi == 7)
                                                    ? dahaFazlaButon(
                                                        index: index)
                                                    : null,
                                                width: ogeGenisligi,
                                                index: index,
                                              ),
                                            if (yeniOgeSayisi >= 8)
                                              bilgiler(
                                                aciklama: (filtreliCihazlar
                                                                .isEmpty
                                                            ? cihazlar
                                                            : filtreliCihazlar)[
                                                        index]
                                                    .sorumlu,
                                                width: ogeGenisligi,
                                                index: index,
                                              ),
                                          ],
                                        ),
                                        if (menuAcikDurumu.length > index)
                                          if (menuAcikDurumu[index])
                                            Column(
                                              crossAxisAlignment:
                                                  CrossAxisAlignment.start,
                                              mainAxisAlignment:
                                                  MainAxisAlignment.start,
                                              children: [
                                                if (yeniOgeSayisi < 2)
                                                  dahaFazla(
                                                    baslik: "Servis No: ",
                                                    aciklama: (filtreliCihazlar
                                                                    .isEmpty
                                                                ? cihazlar
                                                                : filtreliCihazlar)[
                                                            index]
                                                        .servisNo,
                                                    width: tamBoyut,
                                                  ),
                                                if (yeniOgeSayisi < 3)
                                                  dahaFazla(
                                                    baslik: "GSM: ",
                                                    aciklama: (filtreliCihazlar
                                                                    .isEmpty
                                                                ? cihazlar
                                                                : filtreliCihazlar)[
                                                            index]
                                                        .telefonNumarasi,
                                                    width: tamBoyut,
                                                  ),
                                                if (yeniOgeSayisi < 4)
                                                  dahaFazla(
                                                    baslik: "Tür: ",
                                                    aciklama: (filtreliCihazlar
                                                                    .isEmpty
                                                                ? cihazlar
                                                                : filtreliCihazlar)[
                                                            index]
                                                        .cihazTuru,
                                                    width: tamBoyut,
                                                  ),
                                                if (yeniOgeSayisi < 5)
                                                  dahaFazla(
                                                    baslik: "Cihaz: ",
                                                    aciklama:
                                                        "${(filtreliCihazlar.isEmpty ? cihazlar : filtreliCihazlar)[index].cihaz} ${(filtreliCihazlar.isEmpty ? cihazlar : filtreliCihazlar)[index].cihazModeli}",
                                                    width: tamBoyut,
                                                  ),
                                                if (yeniOgeSayisi < 6)
                                                  dahaFazla(
                                                    baslik: "Tarih: ",
                                                    aciklama: (filtreliCihazlar
                                                                    .isEmpty
                                                                ? cihazlar
                                                                : filtreliCihazlar)[
                                                            index]
                                                        .tarih,
                                                    width: tamBoyut,
                                                  ),
                                                if (yeniOgeSayisi < 7)
                                                  dahaFazla(
                                                    baslik: "Güncel Durum: ",
                                                    aciklama: cihazDurumuGetir(
                                                        (filtreliCihazlar
                                                                        .isEmpty
                                                                    ? cihazlar
                                                                    : filtreliCihazlar)[
                                                                index]
                                                            .guncelDurum),
                                                    width: tamBoyut,
                                                  ),
                                                if (yeniOgeSayisi < 8)
                                                  dahaFazla(
                                                    baslik: "Sorumlu: ",
                                                    aciklama: (filtreliCihazlar
                                                                    .isEmpty
                                                                ? cihazlar
                                                                : filtreliCihazlar)[
                                                            index]
                                                        .sorumlu,
                                                    width: tamBoyut,
                                                  ),
                                              ],
                                            ),
                                      ],
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
                              separatorBuilder: (context, index) =>
                                  const Divider(
                                height: 1.0,
                                color: Colors.black87,
                              ),
                              itemCount: (filtreliCihazlar.isEmpty
                                      ? cihazlar.length
                                      : filtreliCihazlar.length) +
                                  (hepsiYuklendi ? 1 : 0),
                            ),
                          )
                        : Container(
                            alignment: Alignment.topCenter,
                            child: const Text(
                              "Henüz bir cihaz eklenmedi.",
                              style: TextStyle(
                                fontSize: 18,
                              ),
                            ),
                          ),
                  ],
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
    );
  }

  Widget baslikText({
    required String text,
    double? fontSize = 15,
  }) {
    return Text(
      text,
      style: TextStyle(
        fontWeight: FontWeight.bold,
        fontSize: fontSize,
      ),
    );
  }

  Widget bilgiler({
    required String aciklama,
    required double width,
    required int index,
    Widget? widget,
  }) {
    return Container(
      width: width,
      padding: const EdgeInsets.all(5),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Expanded(
            child: Wrap(
              alignment: WrapAlignment.start,
              runAlignment: WrapAlignment.start,
              crossAxisAlignment: WrapCrossAlignment.start,
              children: [
                bilgilerText(text: aciklama),
              ],
            ),
          ),
          if (widget != null) widget,
        ],
      ),
    );
  }

  Widget bilgilerText({
    required String text,
  }) {
    return Text(text);
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
    if (temp.isNotEmpty) {
      setState(() {
        cihazlar.addAll(temp);
        menuAcikDurumu.addAll(List.generate(temp.length, (index) => false));
        ilkOge += yuklenecekOge;
      });
    }
    setState(() {
      yukleniyor = false;
      getirildi = true;
      hepsiYuklendi = temp.isEmpty;
    });
  }
}
