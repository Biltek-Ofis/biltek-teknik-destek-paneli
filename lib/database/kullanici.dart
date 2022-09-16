import 'package:biltekbilgisayar/models/kullanici.dart';
import 'package:biltekbilgisayar/utils/sp.dart';
import 'package:flutter/foundation.dart';

import 'connect.dart';
import 'paths.dart';

class KullaniciBilgileri {
  static Future<KullaniciModel> getir() async {
    try {
      int id = await SharedPref.kullaniciID();
      KullaniciModel kullaniciModel = KullaniciModel.fromJson(
          await Connect.map(url: Paths.kullaniciBilgileri(id)));
      return kullaniciModel;
    } catch (e) {
      if (kDebugMode) {
        print("Kullanıcı Bilgileri Alınamadı. Hata: ${e.toString()}");
      }
      return KullaniciModel.bos();
    }
  }
}
