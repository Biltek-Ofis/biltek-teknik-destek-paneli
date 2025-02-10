import 'package:biltekteknikservis/models/kullanici.dart';

import 'cihaz_turleri.dart';

class CihazDuzenlemeModel {
  final List<CihazTurleriModel> cihazTurleri;
  final List<KullaniciModel> sorumlular;

  const CihazDuzenlemeModel({
    required this.cihazTurleri,
    required this.sorumlular,
  });

  factory CihazDuzenlemeModel.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        'cihazTurleri': List<dynamic> cihazTurleri,
        'sorumlular': List<dynamic> sorumlular,
      } =>
        CihazDuzenlemeModel(
          cihazTurleri:
              cihazTurleri.map((e) => CihazTurleriModel.fromJson(e)).toList(),
          sorumlular:
              sorumlular.map((e) => KullaniciModel.fromJson(e)).toList(),
        ),
      _ => throw const FormatException(
          "Cihaz Duzenleme getirilirken bir hata oluştu"),
    };
  }
  factory CihazDuzenlemeModel.bos() {
    return CihazDuzenlemeModel(
      cihazTurleri: [],
      sorumlular: [],
    );
  }
}
