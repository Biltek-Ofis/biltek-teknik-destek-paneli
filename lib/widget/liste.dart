import 'package:flutter/material.dart';

import '../model/cihaz.dart';
import '../ozellikler/cihaz_bilgileri.dart';

class CihazListesi extends StatefulWidget {
  const CihazListesi({
    super.key,
    required this.cihazlar,
    this.ekCount = 0,
    this.controller,
  });
  final List<CihazModel> cihazlar;
  final int ekCount;
  final ScrollController? controller;

  @override
  State<CihazListesi> createState() => _CihazListesiState();
}

class _CihazListesiState extends State<CihazListesi> {
  List<bool> menuAcikDurumu = [];
  @override
  void initState() {
    super.initState();
    Future.delayed(Duration.zero, () {
      setState(() {
        menuAcikDurumu =
            List.generate(widget.cihazlar.length, (index) => false);
      });
    });
  }

  int ogeSayisi = 5;
  int yeniOgeSayisi = 5;
  double minOgeGenisligi = 200;
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
      padding: const EdgeInsets.all(15.0),
      shape: const CircleBorder(),
      child: SizedBox(
        width: dahaFazlaButonBoyutu,
        height: dahaFazlaButonBoyutu,
        child: Icon(
          (menuAcikDurumu.length > index)
              ? menuAcikDurumu[index]
                  ? Icons.remove
                  : Icons.add
              : Icons.add,
          size: 13.0,
          color: Colors.white,
        ),
      ),
    );
  }

  Widget baslik({
    required String baslik,
    required double width,
  }) {
    return Container(
      width: width,
      padding: const EdgeInsets.all(5),
      child: Wrap(
        children: [
          baslikText(text: baslik),
        ],
      ),
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
  }) {
    return SizedBox(
      width: width,
      child: Wrap(
        children: [
          bilgilerText(text: aciklama),
        ],
      ),
    );
  }

  Widget bilgilerText({
    required String text,
  }) {
    return SelectableText(text);
  }

  @override
  Widget build(BuildContext context) {
    yeniOgeSayisi = ogeSayisi;
    double cikarilacak = 105 + dahaFazlaButonBoyutu;
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
    return Column(
      children: [
        Container(
          color: Colors.white,
          child: Row(
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              baslik(
                baslik: "Servis No",
                width: ogeGenisligi,
              ),
              if (yeniOgeSayisi >= 2)
                baslik(
                  baslik: "Müşteri Adı",
                  width: ogeGenisligi,
                ),
              if (yeniOgeSayisi >= 3)
                baslik(
                  baslik: "Cihaz",
                  width: ogeGenisligi,
                ),
              if (yeniOgeSayisi >= 4)
                baslik(
                  baslik: "Tarih",
                  width: ogeGenisligi,
                ),
              if (yeniOgeSayisi >= 5)
                baslik(
                  baslik: "Güncel Durum",
                  width: ogeGenisligi,
                ),
            ],
          ),
        ),
        Expanded(
          child: ListView.separated(
            controller: widget.controller,
            scrollDirection: Axis.vertical,
            itemBuilder: (context, index) {
              if (index < widget.cihazlar.length) {
                return ListTile(
                  tileColor: cihazDurumuColorGetir(
                    widget.cihazlar[index].guncelDurum,
                  ),
                  title: Column(
                    children: [
                      Row(
                        crossAxisAlignment: CrossAxisAlignment.center,
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          bilgiler(
                            aciklama: widget.cihazlar[index].servisNo,
                            width: ogeGenisligi,
                            index: index,
                          ),
                          if (yeniOgeSayisi >= 2)
                            bilgiler(
                              aciklama: widget.cihazlar[index].musteriAdi,
                              width: ogeGenisligi,
                              index: index,
                            ),
                          if (yeniOgeSayisi >= 3)
                            bilgiler(
                              aciklama:
                                  "${widget.cihazlar[index].cihaz} ${widget.cihazlar[index].cihazModeli}",
                              width: ogeGenisligi,
                              index: index,
                            ),
                          if (yeniOgeSayisi >= 4)
                            bilgiler(
                              aciklama: widget.cihazlar[index].tarih,
                              width: ogeGenisligi,
                              index: index,
                            ),
                          if (yeniOgeSayisi >= 5)
                            bilgiler(
                              aciklama: cihazDurumuGetir(
                                  widget.cihazlar[index].guncelDurum),
                              width: ogeGenisligi,
                              index: index,
                            ),
                          if (yeniOgeSayisi < 5) dahaFazlaButon(index: index),
                        ],
                      ),
                      if (menuAcikDurumu.length > index)
                        if (menuAcikDurumu[index])
                          Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            mainAxisAlignment: MainAxisAlignment.start,
                            children: [
                              if (yeniOgeSayisi < 2)
                                dahaFazla(
                                  baslik: "Müşteri Adı",
                                  aciklama: widget.cihazlar[index].musteriAdi,
                                  width: tamBoyut,
                                ),
                              if (yeniOgeSayisi < 3)
                                dahaFazla(
                                  baslik: "Cihaz: ",
                                  aciklama:
                                      "${widget.cihazlar[index].cihaz} ${widget.cihazlar[index].cihazModeli}",
                                  width: tamBoyut,
                                ),
                              if (yeniOgeSayisi < 4)
                                dahaFazla(
                                  baslik: "Tarih: ",
                                  aciklama: widget.cihazlar[index].tarih,
                                  width: tamBoyut,
                                ),
                              if (yeniOgeSayisi < 5)
                                dahaFazla(
                                  baslik: "Güncel Durum: ",
                                  aciklama: cihazDurumuGetir(
                                      widget.cihazlar[index].guncelDurum),
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
            separatorBuilder: (context, index) => const Divider(
              height: 1.0,
              color: Colors.black87,
            ),
            itemCount: widget.cihazlar.length + widget.ekCount,
          ),
        ),
      ],
    );
  }
}
