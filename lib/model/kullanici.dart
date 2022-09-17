import '../ozellikler/degiskenler.dart';

class KullaniciModel {
  KullaniciModel({
    required this.id,
    required this.kullaniciAdi,
    required this.adSoyad,
    required this.yonetici,
  });
  final int id;
  final String kullaniciAdi;
  final String adSoyad;
  final bool yonetici;
  factory KullaniciModel.fromJson(Map<String, dynamic> jsonData) {
    return KullaniciModel(
      id: Degiskenler.parseInt(sayi: jsonData['id']),
      kullaniciAdi: Degiskenler.parseString(yazi: jsonData["kullanici_adi"]),
      adSoyad: Degiskenler.parseString(yazi: jsonData["ad_soyad"]),
      yonetici:
          Degiskenler.parseInt(sayi: jsonData["yonetici"]) == 1 ? true : false,
    );
  }
  factory KullaniciModel.bos() {
    return KullaniciModel(
      id: 0,
      kullaniciAdi: "",
      adSoyad: "",
      yonetici: false,
    );
  }
}
