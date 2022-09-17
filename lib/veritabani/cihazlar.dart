import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

import '../model/cihaz.dart';
import '../ozellikler/cihaz_bilgileri.dart';
import '../widget/buttonlar.dart';
import 'baglan.dart';
import 'konumlar.dart';

class Cihazlar {
  static Future<List<CihazModel>> getir() async {
    try {
      List cihazlar = await Baglan.list(url: Konumlar.cihazlar());
      return cihazlar.map((cihaz) => CihazModel.fromJson(cihaz)).toList();
    } catch (e) {
      if (kDebugMode) {
        print("Cihazlar Alınamadı. Hata: ${e.toString()}");
      }
      return [];
    }
  }
}

class CihazlarData extends DataTableSource {
  CihazlarData({required this.cihazlar});
  final List<CihazModel> cihazlar;

  @override
  bool get isRowCountApproximate => false;

  @override
  int get rowCount => cihazlar.length;

  @override
  int get selectedRowCount => 0;

  @override
  DataRow? getRow(int index) {
    return DataRow(
      cells: [
        DataCell(SelectableText(cihazlar[index].servisNo)),
        DataCell(
          SelectableText(
              "${cihazlar[index].cihaz} ${cihazlar[index].cihazModeli}"),
        ),
        DataCell(SelectableText(cihazlar[index].tarih)),
        DataCell(SelectableText(cihazDurumuGetir(cihazlar[index].guncelDurum))),
        DataCell(SelectableText(cihazlar[index].sorumlu.toString())),
        DataCell(buttonDef(text: "Detaylar", width: 100, height: 30)),
      ],
    );
  }

  void sort<T>(Comparable<T> Function(CihazModel d) getField, bool ascending) {
    cihazlar.sort((CihazModel a, CihazModel b) {
      if (!ascending) {
        final CihazModel c = a;
        a = b;
        b = c;
      }
      final Comparable<T> aValue = getField(a);
      final Comparable<T> bValue = getField(b);
      return Comparable.compare(aValue, bValue);
    });
    notifyListeners();
  }
}
