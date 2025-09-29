import 'package:flutter/material.dart';

import 'cihaz.dart';

class CagriKaydiModel {
  final String id;
  final String kullID;
  final String bolge;
  final String birim;
  final String telefonNumarasi;
  final String cihazTuru;
  final String cihazTuruVal;
  final String cihaz;
  final String cihazModeli;
  final String seriNo;
  final String arizaAciklamasi;
  final String tarih;
  final Cihaz? cihazBilgileri;

  const CagriKaydiModel({
    required this.id,
    required this.kullID,
    required this.bolge,
    required this.birim,
    required this.telefonNumarasi,
    required this.cihazTuru,
    required this.cihazTuruVal,
    required this.cihaz,
    required this.cihazModeli,
    required this.seriNo,
    required this.arizaAciklamasi,
    required this.tarih,
    this.cihazBilgileri,
  });
  factory CagriKaydiModel.create({
    required String id,
    required String kullID,
    required String bolge,
    required String birim,
    required String telefonNumarasi,
    required String cihazTuru,
    required String cihazTuruVal,
    required String cihaz,
    required String cihazModeli,
    required String seriNo,
    required String arizaAciklamasi,
    required String tarih,
    Cihaz? cihazBilgileri,
  }) {
    return CagriKaydiModel(
      id: id,
      kullID: kullID,
      bolge: bolge,
      birim: birim,
      telefonNumarasi: telefonNumarasi,
      cihazTuru: cihazTuru,
      cihazTuruVal: cihazTuruVal,
      cihaz: cihaz,
      cihazModeli: cihazModeli,
      seriNo: seriNo,
      arizaAciklamasi: arizaAciklamasi,
      tarih: tarih,
      cihazBilgileri: cihazBilgileri,
    );
  }
  factory CagriKaydiModel.fromJson(Map<String, dynamic> json) {
    debugPrint("CB Tipi${json["cihaz_bilgileri"].runtimeType.toString()}");
    Map<String, dynamic> cihazBilgileri =
        json.containsKey("cihaz_bilgileri")
            ? json["cihaz_bilgileri"] as Map<String, dynamic>
            : {};
    return CagriKaydiModel(
      id: json["id"] ?? "",
      kullID: json["kull_id"] ?? "",
      bolge: json["bolge"] ?? "",
      birim: json["birim"] ?? "",
      telefonNumarasi: json["telefon_numarasi"] ?? "",
      cihazTuruVal: json["cihaz_turu_val"] ?? "",
      cihazTuru: json["cihaz_turu"] ?? "",
      cihaz: json["cihaz"] ?? "",
      cihazModeli: json["cihaz_modeli"] ?? "",
      seriNo: json["seri_no"] ?? "",
      arizaAciklamasi: json["ariza_aciklamasi"] ?? "",
      tarih: json["tarih"] ?? "2025-01-01 0:00:00",
      cihazBilgileri:
          cihazBilgileri.isNotEmpty
              ? Cihaz.create(
                id: int.tryParse(cihazBilgileri["id"]) ?? 0,
                servisNo: int.tryParse(cihazBilgileri["servis_no"]) ?? 0,
                cihazTuru: cihazBilgileri["cihaz_turu"],
                cihazTuruVal:
                    int.tryParse(cihazBilgileri["cihaz_turu_val"]) ?? 0,
                cihaz: cihazBilgileri["cihaz"],
                cihazModeli: cihazBilgileri["cihaz_modeli"],
                guncelDurum: int.tryParse(cihazBilgileri["guncel_durum"]) ?? 0,
                guncelDurumRenk: cihazBilgileri["guncel_durum_renk"],
                guncelDurumText: cihazBilgileri["guncel_durum_text"],
              )
              : null,
    );
  }
}
