import 'package:biltekbilgisayar/ozellikler/degiskenler.dart';

class KullaniciGirisiModel {
  KullaniciGirisiModel({
    required this.id,
    required this.durum,
  });
  final int id;
  final bool durum;
  factory KullaniciGirisiModel.fromJson(Map<String, dynamic> jsonData) {
    return KullaniciGirisiModel(
      id: Degiskenler.parseInt(sayi: jsonData['id']),
      durum: Degiskenler.parseBool(durum: jsonData['durum']),
    );
  }
}
