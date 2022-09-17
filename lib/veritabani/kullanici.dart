import 'package:biltekbilgisayar/model/kullanici.dart';
import 'package:biltekbilgisayar/ozellikler/sp.dart';
import 'package:flutter/foundation.dart';

import 'baglan.dart';
import 'konumlar.dart';

class KullaniciBilgileri {
  static Future<KullaniciModel> getir() async {
    try {
      int id = await SharedPref.kullaniciID();
      KullaniciModel kullaniciModel = KullaniciModel.fromJson(
          await Baglan.map(url: Konumlar.kullaniciBilgileri(id)));
      return kullaniciModel;
    } catch (e) {
      if (kDebugMode) {
        print("Kullanıcı Bilgileri Alınamadı. Hata: ${e.toString()}");
      }
      return KullaniciModel.bos();
    }
  }
}
