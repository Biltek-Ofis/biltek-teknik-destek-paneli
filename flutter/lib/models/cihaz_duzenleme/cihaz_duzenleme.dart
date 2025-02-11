import 'package:biltekteknikservis/models/kullanici.dart';

import 'cihaz_turleri.dart';
import 'guncel_durumlar.dart';
import 'tahsilat_sekli.dart';

class CihazDuzenlemeModel {
  final List<CihazTurleriModel> cihazTurleri;
  final List<KullaniciModel> sorumlular;
  final List<GuncelDurumModel> cihazDurumlari;
  final List<TahsilatSekli> tahsilatSekilleri;

  const CihazDuzenlemeModel({
    required this.cihazTurleri,
    required this.sorumlular,
    required this.cihazDurumlari,
    required this.tahsilatSekilleri,
  });

  factory CihazDuzenlemeModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'cihazTurleri': List<dynamic> cihazTurleri,
        'sorumlular': List<dynamic> sorumlular,
        'cihazDurumlari': List<dynamic> cihazDurumlari,
        'tahsilatSekilleri': List<dynamic> tahsilatSekilleri,
      } =>
        CihazDuzenlemeModel(
          cihazTurleri:
              cihazTurleri.map((e) => CihazTurleriModel.fromJson(e)).toList(),
          sorumlular:
              sorumlular.map((e) => KullaniciModel.fromJson(e)).toList(),
          cihazDurumlari:
              cihazDurumlari.map((e) => GuncelDurumModel.fromJson(e)).toList(),
          tahsilatSekilleri:
              tahsilatSekilleri.map((e) => TahsilatSekli.fromJson(e)).toList(),
        ),
      _ => throw const FormatException(
          "Cihaz Duzenleme getirilirken bir hata oluştu"),
    };
  }
  factory CihazDuzenlemeModel.bos() {
    return CihazDuzenlemeModel(
      cihazTurleri: [],
      sorumlular: [],
      cihazDurumlari: [],
      tahsilatSekilleri: [],
    );
  }
}
