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
  CihazlarData cihazlar = CihazlarData(cihazlar: []);

  int sortColumnIndex = 0;
  bool sortAscending = true;

  @override
  void initState() {
    KullaniciBilgileri.getir().then((value) {
      setState(() {
        Veriler.kullaniciBilgileri = value;
      });
    });

    Cihazlar.getir().then((value) {
      setState(() {
        cihazlar = CihazlarData(cihazlar: value);
      });
    });
    super.initState();
  }

  void sort<T>(Comparable<T> Function(CihazModel cM) getField, int columnIndex,
      bool ascending) {
    cihazlar.sort<T>(getField, ascending);
    setState(() {
      sortColumnIndex = columnIndex;
      sortAscending = ascending;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Sayfa(
      menu: const AnaMenu(
        seciliSayfa: "Anasayfa",
      ),
      baslik: "Anasayfa",
      icerik: PaginatedDataTable(
        source: cihazlar,
        header: const Text("Cihazlar"),
        columns: [
          DataColumn(
            label: const Text("Servis No"),
            onSort: (columnIndex, ascending) => sort<String>(
              (cM) => cM.servisNo,
              columnIndex,
              ascending,
            ),
          ),
          DataColumn(
            label: const Text("Cihaz"),
            onSort: (columnIndex, ascending) => sort<String>(
              (cM) => "${cM.cihaz} ${cM.cihazModeli}",
              columnIndex,
              ascending,
            ),
          ),
          DataColumn(
            label: const Text("Giriş Tarihi"),
            onSort: (columnIndex, ascending) => sort<String>(
              (cM) => cM.tarih,
              columnIndex,
              ascending,
            ),
          ),
          DataColumn(
            label: const Text("Güncel Durum"),
            onSort: (columnIndex, ascending) => sort<String>(
              (cM) => cM.guncelDurum.toString(),
              columnIndex,
              ascending,
            ),
          ),
          DataColumn(
            label: const Text("Sorumlu Personel"),
            onSort: (columnIndex, ascending) => sort<String>(
              (cM) => cM.sorumlu.toString(),
              columnIndex,
              ascending,
            ),
          ),
          const DataColumn(
            label: Text("Detaylar"),
          ),
        ],
        columnSpacing: 0,
        horizontalMargin: 0,
        rowsPerPage: 50,
        showCheckboxColumn: false,
        sortColumnIndex: sortColumnIndex,
        sortAscending: sortAscending,
      ),
    );
  }
}
