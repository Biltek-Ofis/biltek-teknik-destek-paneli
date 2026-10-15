import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:signature/signature.dart';

class Cihaz {
  final int id;
  final int servisNo;
  final int takipNumarasi;
  final int cagriID;
  final int kullID;
  final int musterKod;
  final String musteriAdi;
  final String teslimEden;
  final String teslimAlan;
  final String adres;
  final String telefonNumarasi;
  final String cihazTuru;
  final String sorumlu;
  final String cihaz;
  final String cihazModeli;
  final String seriNo;
  final String cihazSifresi;
  final String cihazDeseni;
  final String cihazDeseniActives;
  final String cihazDeseniLines;
  final String hasarTespiti;
  final int cihazdakiHasar;
  final String arizaAciklamasi;
  final int servisTuru;
  final int yedekDurumu;
  final String teslimAlinanlar;
  final String yapilanIslemAciklamasi;
  final String notlar;
  final String teslimEdildi;
  final String tarih;
  final String bildirimTarihi;
  final String cikisTarihi;
  final int guncelDurum;
  final String guncelDurumText;
  final String guncelDurumRenk;
  final String tahsilatSekli;
  final int faturaDurumu;
  final String fisNo;
  final int cihazDurumuID;
  final int siralama;
  final int cihazTuruVal;
  final int tahsilatSekliVal;
  final int sorumluVal;
  final String imzaDosyasi;
  final String imzaPoints;
  final List<YapilanIslem> islemler;
  static Cihaz create({
    int id = 0,
    int servisNo = 0,

    int takipNumarasi = 0,

    int cagriID = 0,
    int kullID = 0,
    int musterKod = 0,
    String musteriAdi = "",
    String teslimEden = "",
    String teslimAlan = "",
    String adres = "",
    String telefonNumarasi = "",
    int cihazTuruVal = 0,
    String cihazTuru = "",
    String sorumlu = "",
    String cihaz = "",
    String cihazModeli = "",
    String seriNo = "",
    String cihazSifresi = "",
    String cihazDeseni = "",
    String cihazDeseniActives = "",
    String cihazDeseniLines = "",
    String hasarTespiti = "",
    int cihazdakiHasar = 0,
    String arizaAciklamasi = "",
    int servisTuru = 0,
    int yedekDurumu = 0,
    String teslimAlinanlar = "",
    String yapilanIslemAciklamasi = "",
    String notlar = "",
    String teslimEdildi = "",
    String tarih = "",
    String bildirimTarihi = "",
    String cikisTarihi = "",
    int guncelDurum = 0,
    String guncelDurumText = "",
    String guncelDurumRenk = "",
    String tahsilatSekli = "",
    int faturaDurumu = 0,
    String fisNo = "",
    int cihazDurumuID = 0,
    int siralama = 0,
    int tahsilatSekliVal = 0,
    int sorumluVal = 0,
    String imzaDosyasi = "",
    String imzaPoints = "",
    List<YapilanIslem> islemler = const [],
  }) {
    return Cihaz(
      id: id,
      servisNo: servisNo,
      takipNumarasi: takipNumarasi,
      cagriID: cagriID,
      kullID: kullID,
      musterKod: musterKod,
      musteriAdi: musteriAdi,
      teslimEden: teslimEden,
      teslimAlan: teslimAlan,
      adres: adres,
      telefonNumarasi: telefonNumarasi,
      cihazTuru: cihazTuru,
      sorumlu: sorumlu,
      cihaz: cihaz,
      cihazModeli: cihazModeli,
      seriNo: seriNo,
      cihazSifresi: cihazSifresi,
      cihazDeseni: cihazDeseni,
      cihazDeseniActives: cihazDeseniActives,
      cihazDeseniLines: cihazDeseniLines,
      hasarTespiti: hasarTespiti,
      cihazdakiHasar: cihazdakiHasar,
      arizaAciklamasi: arizaAciklamasi,
      servisTuru: servisTuru,
      yedekDurumu: yedekDurumu,
      teslimAlinanlar: teslimAlinanlar,
      yapilanIslemAciklamasi: yapilanIslemAciklamasi,
      notlar: notlar,
      teslimEdildi: teslimEdildi,
      tarih: tarih,
      bildirimTarihi: bildirimTarihi,
      cikisTarihi: cikisTarihi,
      guncelDurum: guncelDurum,
      guncelDurumText: guncelDurumText,
      guncelDurumRenk: guncelDurumRenk,
      tahsilatSekli: tahsilatSekli,
      faturaDurumu: faturaDurumu,
      fisNo: fisNo,
      cihazDurumuID: 0,
      siralama: 0,
      cihazTuruVal: cihazTuruVal,
      tahsilatSekliVal: 0,
      sorumluVal: 0,
      imzaDosyasi: imzaDosyasi,
      imzaPoints: imzaPoints,
      islemler: islemler,
    );
  }

  const Cihaz({
    required this.id,
    required this.servisNo,
    required this.takipNumarasi,
    required this.cagriID,
    required this.kullID,
    required this.musterKod,
    required this.musteriAdi,
    required this.teslimEden,
    required this.teslimAlan,
    required this.adres,
    required this.telefonNumarasi,
    required this.cihazTuru,
    required this.sorumlu,
    required this.cihaz,
    required this.cihazModeli,
    required this.seriNo,
    required this.cihazSifresi,
    required this.cihazDeseni,
    required this.cihazDeseniActives,
    required this.cihazDeseniLines,
    required this.hasarTespiti,
    required this.cihazdakiHasar,
    required this.arizaAciklamasi,
    required this.servisTuru,
    required this.yedekDurumu,
    required this.teslimAlinanlar,
    required this.yapilanIslemAciklamasi,
    required this.notlar,
    required this.teslimEdildi,
    required this.tarih,
    required this.bildirimTarihi,
    required this.cikisTarihi,
    required this.guncelDurum,
    required this.guncelDurumText,
    required this.guncelDurumRenk,
    required this.tahsilatSekli,
    required this.faturaDurumu,
    required this.fisNo,
    required this.cihazDurumuID,
    required this.siralama,
    required this.cihazTuruVal,
    required this.tahsilatSekliVal,
    required this.sorumluVal,
    required this.imzaDosyasi,
    required this.imzaPoints,
    required this.islemler,
  });
  factory Cihaz.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        "id": String id,
        "servis_no": String servisNo,
        "takip_numarasi": String takipNumarasi,
        "cagri_id": String cagriID,
        "kull_id": String kullID,
        "musteri_kod": String musterKod,
        "musteri_adi": String musteriAdi,
        "teslim_eden": String teslimEden,
        "teslim_alan": String teslimAlan,
        "adres": String adres,
        "telefon_numarasi": String telefonNumarasi,
        "cihaz_turu": String cihazTuru,
        "sorumlu": String sorumlu,
        "cihaz": String cihaz,
        "cihaz_modeli": String cihazModeli,
        "seri_no": String seriNo,
        "cihaz_sifresi": String cihazSifresi,
        "cihaz_deseni": String cihazDeseni,
        "cihaz_deseni_actives": String cihazDeseniActives,
        "cihaz_deseni_lines": String cihazDeseniLines,
        "hasar_tespiti": String hasarTespiti,
        "cihazdaki_hasar": String cihazdakiHasar,
        "ariza_aciklamasi": String arizaAciklamasi,
        "servis_turu": String servisTuru,
        "yedek_durumu": String yedekDurumu,
        "teslim_alinanlar": String teslimAlinanlar,
        "yapilan_islem_aciklamasi": String yapilanIslemAciklamasi,
        "notlar": String notlar,
        "teslim_edildi": String teslimEdildi,
        "tarih": String tarih,
        "bildirim_tarihi": String bildirimTarihi,
        "cikis_tarihi": String cikisTarihi,
        "guncel_durum": String guncelDurum,
        "guncel_durum_text": String guncelDurumText,
        "guncel_durum_renk": String guncelDurumRenk,
        "tahsilat_sekli": String tahsilatSekli,
        "fatura_durumu": String faturaDurumu,
        "fis_no": String fisNo,
        "cihazDurumuID": String cihazDurumuID,
        "siralama": String siralama,
        "cihaz_turu_val": String cihazTuruVal,
        "tahsilat_sekli_val": String tahsilatSekliVal,
        "sorumlu_val": String sorumluVal,
        "imza_dosyasi": String imzaDosyasi,
        "imza_points": String imzaPoints,
        "islemler": List<dynamic> islemler,
      } =>
        Cihaz(
          id: int.tryParse(id) ?? 0,
          servisNo: int.tryParse(servisNo) ?? 0,
          takipNumarasi: int.tryParse(takipNumarasi) ?? 0,
          cagriID: int.tryParse(cagriID) ?? 0,
          kullID: int.tryParse(kullID) ?? 0,
          musterKod: int.tryParse(musterKod) ?? 0,
          musteriAdi: musteriAdi,
          teslimEden: teslimEden,
          teslimAlan: teslimAlan,
          adres: adres,
          telefonNumarasi: telefonNumarasi,
          cihazTuru: cihazTuru,
          sorumlu: sorumlu,
          cihaz: cihaz,
          cihazModeli: cihazModeli,
          seriNo: seriNo,
          cihazSifresi: cihazSifresi,
          cihazDeseni: cihazDeseni,
          cihazDeseniActives: cihazDeseniActives,
          cihazDeseniLines: cihazDeseniLines,
          hasarTespiti: hasarTespiti,
          cihazdakiHasar: int.parse(cihazdakiHasar),
          arizaAciklamasi: arizaAciklamasi,
          servisTuru: int.tryParse(servisTuru) ?? 99,
          yedekDurumu: int.tryParse(yedekDurumu) ?? -1,
          teslimAlinanlar: teslimAlinanlar,
          yapilanIslemAciklamasi: yapilanIslemAciklamasi,
          notlar: notlar,
          teslimEdildi: teslimEdildi,
          tarih: tarih,
          bildirimTarihi: bildirimTarihi,
          cikisTarihi: cikisTarihi,
          guncelDurum: int.tryParse(guncelDurum) ?? -1,
          guncelDurumText: guncelDurumText,
          guncelDurumRenk: guncelDurumRenk,
          tahsilatSekli: tahsilatSekli,
          faturaDurumu: int.tryParse(faturaDurumu) ?? 0,
          fisNo: fisNo,
          cihazDurumuID: int.tryParse(cihazDurumuID) ?? -1,
          siralama: int.tryParse(siralama) ?? -1,
          cihazTuruVal: int.tryParse(cihazTuruVal) ?? -1,
          tahsilatSekliVal: int.tryParse(tahsilatSekliVal) ?? -1,
          sorumluVal: int.tryParse(sorumluVal) ?? -1,
          imzaDosyasi: imzaDosyasi,
          imzaPoints: imzaPoints,
          islemler:
              islemler
                  .map(
                    (islem) =>
                        YapilanIslem.fromJson(islem as Map<String, dynamic>),
                  )
                  .toList(),
        ),
      _ => throw FormatException("Cihaz yüklenirken hata oluştu."),
    };
  }

  static String imzaPointsToJson(List<Point> points) {
    List<Map<String, dynamic>> pointList = [];
    try {
      for (var i = 0; i < points.length; i++) {
        Point point = points[i];
        Map<String, dynamic> pointMap = {};
        pointMap.addAll({
          "pressure": point.pressure,
          "type": point.type.name,
          "offset": {"dx": point.offset.dx, "dy": point.offset.dy},
        });
        pointList.add(pointMap);
      }
    } on Exception catch (e) {
      debugPrint("Imza json'a dönüştürülemedi: $e");
    }
    return jsonEncode(pointList);
  }

  List<Point> imzaJsonToPoint() {
    if (imzaPoints.trim().isNotEmpty) {
      try {
        List<Point> points = [];
        debugPrint("İmza points: $imzaPoints");
        List<dynamic> pointList = jsonDecode(imzaPoints.trim());
        for (var i = 0; i < pointList.length; i++) {
          Map<String, dynamic> pointMap = pointList[i] as Map<String, dynamic>;
          String type = pointMap["type"] ?? "";
          PointType pointType;
          switch (type) {
            case "tap":
              pointType = PointType.tap;
              break;
            default:
              pointType = PointType.move;
              break;
          }
          Point point = Point(
            Offset(
              pointMap["offset"]["dx"] ?? 0,
              pointMap["offset"]["dy"] ?? 0,
            ),
            pointType,
            pointMap["pressure"] ?? 0,
          );
          points.add(point);
        }
        return points;
      } on Exception catch (e) {
        debugPrint("Imza points'e dönüştürülemedi: $e");
      }
    }
    return [];
  }
}

class YapilanIslem {
  final int id;
  final int cihazID;
  final int islemSayisi;
  final String ad;
  final double maliyet;
  final double birimFiyati;
  final int miktar;
  final double kdv;

  const YapilanIslem({
    required this.id,
    required this.cihazID,
    required this.islemSayisi,
    required this.ad,
    required this.maliyet,
    required this.birimFiyati,
    required this.miktar,
    required this.kdv,
  });
  static YapilanIslem create({
    required String id,
    required String cihazID,
    required String islemSayisi,
    required String ad,
    required String maliyet,
    required String birimFiyati,
    required String miktar,
    required String kdv,
  }) {
    return YapilanIslem(
      id: int.tryParse(id) ?? 0,
      cihazID: int.tryParse(cihazID) ?? 0,
      islemSayisi: int.tryParse(islemSayisi) ?? 0,
      ad: ad,
      maliyet: double.tryParse(maliyet) ?? 0.00,
      birimFiyati: double.tryParse(birimFiyati) ?? 0.00,
      miktar: int.tryParse(miktar) ?? 0,
      kdv: double.tryParse(kdv) ?? 0.00,
    );
  }

  factory YapilanIslem.fromJson(Map<String, dynamic> json) {
    return switch (json) {
      {
        "id": String id,
        "cihaz_id": String cihazID,
        "islem_sayisi": String islemSayisi,
        "ad": String ad,
        "maliyet": String maliyet,
        "birim_fiyat": String birimFiyati,
        "miktar": String miktar,
        "kdv": String kdv,
      } =>
        YapilanIslem.create(
          id: id,
          cihazID: cihazID,
          islemSayisi: islemSayisi,
          ad: ad,
          maliyet: maliyet,
          birimFiyati: birimFiyati,
          miktar: miktar,
          kdv: kdv,
        ),
      _ => throw FormatException("Yapılan işlem yüklenirken hata oluştu."),
    };
  }
}
