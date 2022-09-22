import 'package:flutter/material.dart';
import 'package:simple_grouped_listview/simple_grouped_listview.dart';

import '../model/cihaz.dart';
import '../ozellikler/cihaz_bilgileri.dart';

class CihazListesi extends StatelessWidget {
  const CihazListesi({
    super.key,
    required this.yatayOgeSayisi,
    required this.cihazlar,
    this.ekCount = 0,
    this.controller,
  });

  final int yatayOgeSayisi;
  final List<CihazModel> cihazlar;
  final int ekCount;
  final ScrollController? controller;
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
      child: Column(
        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          Text(
            baslik,
            style: const TextStyle(
              fontWeight: FontWeight.bold,
            ),
          ),
          Wrap(
            children: [
              SelectableText(aciklama),
            ],
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    double ogeGenisligi = MediaQuery.of(context).size.width / yatayOgeSayisi;
    double ogeYuksekligi = 250;
    return GroupedListView.grid(
      scrollDirection: Axis.vertical,
      controller: controller,
      itemsAspectRatio: (ogeGenisligi / ogeYuksekligi),
      items: cihazlar,
      itemGrouper: (CihazModel cihazModel) =>
          cihazDurumuGetir(cihazModel.guncelDurum),
      headerBuilder: (context, String guncelDurum) => Text(
        guncelDurum,
        style: const TextStyle(
          fontWeight: FontWeight.bold,
          fontSize: 20,
        ),
      ),
      gridItemBuilder: (
        context,
        int countInGroup,
        int itemIndexInGroup,
        CihazModel cihazModel,
      ) {
        return Card(
          elevation: 8,
          child: ListTile(
            tileColor: cihazDurumuColorGetir(
              cihazModel.guncelDurum,
            ),
            title: Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                bilgiler(
                  baslik: "Servis No: ",
                  aciklama: cihazModel.servisNo,
                ),
                bilgiler(
                  baslik: "Müşteri Adı: ",
                  aciklama: cihazModel.musteriAdi,
                ),
                bilgiler(
                  baslik: "Cihaz: ",
                  aciklama: "${cihazModel.cihaz} ${cihazModel.cihazModeli}",
                ),
                bilgiler(
                  baslik: "Giriş Tarihi: ",
                  aciklama: cihazModel.tarih,
                ),
                bilgiler(
                  baslik: "Güncel Durum: ",
                  aciklama: cihazDurumuGetir(cihazModel.guncelDurum),
                ),
              ],
            ),
          ),
        );
      },
      crossAxisCount: yatayOgeSayisi,
    );
  }
}
