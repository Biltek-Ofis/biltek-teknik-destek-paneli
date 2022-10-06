import 'package:flutter/foundation.dart';

import '../model/kullanici.dart';
import '../ozellikler/sp.dart';
import 'baglan.dart';
import 'konumlar.dart';

class KullaniciBilgileri {
  static Future<KullaniciModel?> getir() async {
    try {
      int id = await SharedPref.kullaniciID();
      KullaniciModel kullaniciModel = KullaniciModel.fromJson(await Baglan.map(
        url: Konumlar.kullaniciBilgileri(id),
        postVerileri: {
          "id": id.toString(),
        },
      ));
      return kullaniciModel;
    } catch (e) {
      if (kDebugMode) {
        print("Kullanıcı Bilgileri Alınamadı. Hata: ${e.toString()}");
      }
      return null;
    }
  }
}
