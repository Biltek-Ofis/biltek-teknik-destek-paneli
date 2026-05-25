import 'dart:convert';

import '../utils/encryption.dart';

class SecureStorageKullanici {
  final String isim;
  final String kullaniciAdi;
  String sifre;
  bool _sifrelendi = false;

  SecureStorageKullanici._({
    required this.isim,
    required this.kullaniciAdi,
    required this.sifre,
  });

  factory SecureStorageKullanici.create({
    required String isim,
    required String kullaniciAdi,
    required String sifre,
    bool sifrele = true,
  }) {
    SecureStorageKullanici spKullanici = SecureStorageKullanici._(
      isim: isim,
      kullaniciAdi: kullaniciAdi,
      sifre: sifre,
    );
    if (sifrele) {
      spKullanici.sifrele();
    }
    return spKullanici;
  }

  String sifrele() {
    if (!_sifrelendi) {
      _sifrelendi = true;
      sifre = Encryption.encrypt(sifre);
    }
    return sifre;
  }

  String sifreyiCoz() {
    if (_sifrelendi) {
      _sifrelendi = false;
      sifre = Encryption.decrypt(sifre);
    }
    return sifre;
  }

  factory SecureStorageKullanici.fromJson(Map<String, dynamic> json) {
    SecureStorageKullanici spKullanici = SecureStorageKullanici._(
      isim: json["isim"],
      kullaniciAdi: json["kullaniciAdi"],
      sifre: json["sifre"],
    );
    spKullanici._sifrelendi = json["sifrelendi"];
    return spKullanici;
  }
  Map<String, dynamic> toJson() {
    return {
      "isim": isim,
      "kullaniciAdi": kullaniciAdi,
      "sifre": sifre,
      "sifrelendi": _sifrelendi,
    };
  }

  @override
  String toString() {
    return jsonEncode(toJson());
  }
}
