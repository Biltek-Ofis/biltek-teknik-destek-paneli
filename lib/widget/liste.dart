import 'package:flutter/material.dart';

import '../model/cihaz.dart';
import '../ozellikler/cihaz_bilgileri.dart';

class CihazListesi extends StatefulWidget {
  const CihazListesi({
    super.key,
    required this.cihazlar,
    this.sirala,
    this.ekCount = 0,
    this.controller,
    this.cihazSiralama = CihazSiralama.varsayilan,
    this.cihazTiklandi,
    this.asc = false,
  });
  final List<CihazModel> cihazlar;
  final int ekCount;
  final ScrollController? controller;
  final Sirala? sirala;
  final CihazSiralama cihazSiralama;
  final bool asc;
  final CihazTiklandi? cihazTiklandi;

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
    return SizedBox(
      width: width,
      child: InkWell(
        onTap: () {
          if (sirala != null) {
            widget.sirala?.call(sirala, widget.asc);
          }
        },
        child: Wrap(
          alignment: WrapAlignment.spaceBetween,
          runAlignment: WrapAlignment.spaceBetween,
          crossAxisAlignment: WrapCrossAlignment.start,
          children: [
            baslikText(text: baslik),
            if (sirala != null)
              if (widget.cihazSiralama == sirala)
                widget.asc
                    ? const Icon(Icons.arrow_upward)
                    : const Icon(Icons.arrow_downward),
          ],
        ),
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
    Widget? widget,
  }) {
    return SizedBox(
      width: width,
      child: Wrap(
        alignment: WrapAlignment.start,
        runAlignment: WrapAlignment.start,
        crossAxisAlignment: WrapCrossAlignment.start,
        children: [
          bilgilerText(text: aciklama),
          if (widget != null) widget,
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
    double cikarilacak = 113 + dahaFazlaButonBoyutu;
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
                sirala: CihazSiralama.servisNo,
              ),
              if (yeniOgeSayisi >= 2)
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
                  title: GestureDetector(
                    onTap: () {
                      widget.cihazTiklandi?.call(index);
                    },
                    child: Column(
                      children: [
                        Row(
                          crossAxisAlignment: CrossAxisAlignment.center,
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            bilgiler(
                              aciklama: widget.cihazlar[index].servisNo,
                              widget: widget.cihazlar[index].yeni
                                  ? Container(
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
                                    )
                                  : null,
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
                                    widget.cihazlar[index].telefonNumarasi,
                                width: ogeGenisligi,
                                index: index,
                              ),
                            if (yeniOgeSayisi >= 4)
                              bilgiler(
                                aciklama: widget.cihazlar[index].cihazTuru,
                                width: ogeGenisligi,
                                index: index,
                              ),
                            if (yeniOgeSayisi >= 5)
                              bilgiler(
                                aciklama:
                                    "${widget.cihazlar[index].cihaz} ${widget.cihazlar[index].cihazModeli}",
                                width: ogeGenisligi,
                                index: index,
                              ),
                            if (yeniOgeSayisi >= 6)
                              bilgiler(
                                aciklama: widget.cihazlar[index].tarih,
                                width: ogeGenisligi,
                                index: index,
                              ),
                            if (yeniOgeSayisi >= 7)
                              bilgiler(
                                aciklama: cihazDurumuGetir(
                                    widget.cihazlar[index].guncelDurum),
                                width: ogeGenisligi,
                                index: index,
                              ),
                            if (yeniOgeSayisi >= 8)
                              bilgiler(
                                aciklama: widget.cihazlar[index].sorumlu,
                                width: ogeGenisligi,
                                index: index,
                              ),
                            if (yeniOgeSayisi < ogeSayisi)
                              dahaFazlaButon(index: index),
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
                                    baslik: "Müşteri Adı: ",
                                    aciklama: widget.cihazlar[index].musteriAdi,
                                    width: tamBoyut,
                                  ),
                                if (yeniOgeSayisi < 3)
                                  dahaFazla(
                                    baslik: "GSM: ",
                                    aciklama:
                                        widget.cihazlar[index].telefonNumarasi,
                                    width: tamBoyut,
                                  ),
                                if (yeniOgeSayisi < 4)
                                  dahaFazla(
                                    baslik: "Tür: ",
                                    aciklama: widget.cihazlar[index].cihazTuru,
                                    width: tamBoyut,
                                  ),
                                if (yeniOgeSayisi < 5)
                                  dahaFazla(
                                    baslik: "Cihaz: ",
                                    aciklama:
                                        "${widget.cihazlar[index].cihaz} ${widget.cihazlar[index].cihazModeli}",
                                    width: tamBoyut,
                                  ),
                                if (yeniOgeSayisi < 6)
                                  dahaFazla(
                                    baslik: "Tarih: ",
                                    aciklama: widget.cihazlar[index].tarih,
                                    width: tamBoyut,
                                  ),
                                if (yeniOgeSayisi < 7)
                                  dahaFazla(
                                    baslik: "Güncel Durum: ",
                                    aciklama: cihazDurumuGetir(
                                        widget.cihazlar[index].guncelDurum),
                                    width: tamBoyut,
                                  ),
                                if (yeniOgeSayisi < 8)
                                  dahaFazla(
                                    baslik: "Sorumlu: ",
                                    aciklama: widget.cihazlar[index].sorumlu,
                                    width: tamBoyut,
                                  ),
                              ],
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
