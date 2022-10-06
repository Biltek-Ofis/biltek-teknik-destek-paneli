import 'package:flutter/foundation.dart';

import '../model/cihaz.dart';
import 'baglan.dart';
import 'konumlar.dart';

class Cihazlar {
  static Future<List<CihazModel>?> getir({required int id}) async {
    try {
      List cihazlar = await Baglan.list(
        url: Konumlar.cihazlar(id: id),
        postVerileri: {
          "sorumlu": id.toString(),
        },
      );
      return cihazlar.map((cihaz) => CihazModel.fromJson(cihaz)).toList();
    } catch (e) {
      if (kDebugMode) {
        print("Cihazlar Alınamadı. Hata: ${e.toString()}");
      }
      return null;
    }
  }
}
