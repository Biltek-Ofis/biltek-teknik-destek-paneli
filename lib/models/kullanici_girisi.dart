import 'package:biltekbilgisayar/utils/variables.dart';

class KullaniciGirisiModel {
  KullaniciGirisiModel({
    required this.id,
    required this.durum,
  });
  final int id;
  final bool durum;
  factory KullaniciGirisiModel.fromJson(Map<String, dynamic> jsonData) {
    return KullaniciGirisiModel(
      id: Variables.parseInt(sayi: jsonData['id']),
      durum: Variables.parseBool(durum: jsonData['durum']),
    );
  }
}
