import 'dart:convert';
import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:package_info_plus/package_info_plus.dart';

import '../ayarlar.dart';
import '../models/cihaz.dart';
import '../models/cihaz_duzenleme/cihaz_duzenleme.dart';
import '../models/kullanici.dart';
import '../models/lisans/lisans.dart';
import '../models/lisans/versiyon.dart';
import '../models/medya.dart';
import '../models/musteri.dart';
import 'shared_preferences.dart';

class BiltekPost {
  static Future<http.StreamedResponse> postMultiPart(
    String url,
    List<http.MultipartFile> files,
    Map<String, String> data,
  ) async {
    data.addAll({"token": Ayarlar.token});

    /*var headers = <String, String>{
      'Content-Type': 'application/json; charset=UTF-8',
    };*/
    var request = http.MultipartRequest("POST", Uri.parse(url));
    for (var i = 0; i < data.keys.length; i++) {
      String key = data.keys.elementAt(i);
      request.fields[key] = data[key]!;
    }
    for (var i = 0; i < files.length; i++) {
      request.files.add(files[i]);
    }

    ///request.headers.addAll(headers);

    http.StreamedResponse response = await request.send();

    return response;
  }

  static Future<http.StreamedResponse> post(
    String url,
    Map<String, String> data,
  ) async {
    data.addAll({"token": Ayarlar.token});

    /*var headers = <String, String>{
      'Content-Type': 'application/json; charset=UTF-8',
    };*/
    var request = http.Request("POST", Uri.parse(url));
    request.bodyFields = data;

    ///request.headers.addAll(headers);

    http.StreamedResponse response = await request.send();

    return response;
  }

  static Future<bool> guncellemeGerekli() async {
    try {
      var response = await BiltekPost.post(Ayarlar.version, {});
      if (response.statusCode == 201) {
        var resp = await response.stream.bytesToString();
        PackageInfo packageInfo = await PackageInfo.fromPlatform();
        debugPrint("Current version: ${packageInfo.buildNumber}");
        int currentVersion = int.parse(packageInfo.buildNumber);
        int updatedVersion = int.parse(resp);
        return currentVersion < updatedVersion;
      } else {
        return false;
      }
    } on Exception {
      return false;
    }
  }

  static Future<KullaniciAuthModel?> kullaniciGetir(String auth) async {
    var response = await BiltekPost.post(Ayarlar.kullaniciGetir, {
      "auth": auth,
    });
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      KullaniciGetirModel kullaniciGetir = KullaniciGetirModel.fromJson(
        jsonDecode(resp) as Map<String, dynamic>,
      );
      if (kullaniciGetir.durum) {
        return kullaniciGetir.kullanici;
      } else {
        return null;
      }
    } else {
      return null;
    }
  }

  static Future<List<Cihaz>> cihazlariGetir({
    int? sorumlu,
    String? arama,
    List<dynamic> specific = const [],
    int offset = 0,
    int limit = 50,
  }) async {
    Map<String, String> postMap = {
      "sira": offset.toString(),
      "limit": limit.toString(),
    };
    if (sorumlu != null) {
      postMap.addAll({"sorumlu": sorumlu.toString()});
    }
    if (arama != null) {
      postMap.addAll({"arama": arama});
    }
    if (specific.isNotEmpty) {
      postMap.addAll({"specific": jsonEncode(specific)});
    }
    var response = await BiltekPost.post(Ayarlar.cihazlarTumu, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        List<dynamic> cihazlar = jsonDecode(resp) as List<dynamic>;
        return cihazlar
            .map((cihaz) => Cihaz.fromJson(cihaz as Map<String, dynamic>))
            .toList();
      } on Exception {
        throw Exception(
          "Cihazlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
        );
      }
    } else {
      throw Exception(
        "Cihazlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
    }
  }

  static Future<Cihaz?> cihazGetir({int? servisNo, int? takipNo}) async {
    if (servisNo == null && takipNo == null) {
      return null;
    }
    Map<String, String> postData = {};
    if (servisNo != null) {
      postData.addAll({"servis_no": servisNo.toString()});
    }
    if (takipNo != null) {
      postData.addAll({"takip_no": takipNo.toString()});
    }
    var response = await BiltekPost.post(Ayarlar.tekCihaz, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Cihaz cihaz = Cihaz.fromJson(jsonDecode(resp) as Map<String, dynamic>);
        return cihaz;
      } on Exception catch (e) {
        debugPrint(e.toString());
        return null;
      }
    } else {
      debugPrint(
        "Cihaz yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return null;
    }
  }

  static Future<void> fcmToken({
    required String auth,
    required String fcmToken,
  }) async {
    var response = await BiltekPost.post(Ayarlar.fcmToken, {
      "auth": auth,
      "fcmToken": fcmToken,
    });
    await response.stream.bytesToString();
  }

  static Future<void> fcmTokenSifirla({required String? fcmToken}) async {
    if (fcmToken != null) {
      var response = await BiltekPost.post(Ayarlar.fcmTokenSifirla, {
        "fcmToken": fcmToken,
      });
      await response.stream.bytesToString();
    }
  }

  static Future<void> fcmTokenGuncelle(String auth, String? fcmToken) async {
    if (fcmToken != null) {
      await SharedPreference.setString(
        SharedPreference.fcmTokenString,
        fcmToken,
      );
      await BiltekPost.fcmToken(auth: auth, fcmToken: fcmToken);
    }
  }

  static Future<void> bilgisayardaAc({
    required int kullaniciID,
    required int servisNo,
  }) async {
    try {
      var response = await BiltekPost.post(Ayarlar.bilgisayardaAc, {
        "kullanici_id": kullaniciID.toString(),
        "servis_no": servisNo.toString(),
      });
      await response.stream.bytesToString();
    } on Exception {
      debugPrint("Bilgisayarda ac çalışmadı");
    }
  }

  static Future<List<MedyaModel>> medyalariGetir({required int id}) async {
    Map<String, String> postData = {};
    postData.addAll({"id": id.toString()});
    var response = await BiltekPost.post(Ayarlar.medyalar, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        var map = jsonDecode(resp) as List<dynamic>;
        List<MedyaModel> medyaList =
            map
                .map((m) => MedyaModel.fromJson(m as Map<String, dynamic>))
                .toList();
        return medyaList;
      } on Exception catch (e) {
        debugPrint(e.toString());
        return [];
      }
    } else {
      debugPrint(
        "Medyalar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return [];
    }
  }

  static Future<bool> medyaYukle({
    required int id,
    required Uint8List medya,
  }) async {
    var response = await BiltekPost.postMultiPart(
      Ayarlar.medyaYukle,
      [
        http.MultipartFile.fromBytes(
          "yuklenecekDosya",
          medya,
          filename: "upload.png",
        ),
      ],
      {"id": id.toString()},
    );
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  static Future<bool> medyaSil({required int id}) async {
    var response = await BiltekPost.post(Ayarlar.medyaSil, {
      "id": id.toString(),
    });
    var resp = await response.stream.bytesToString();
    debugPrint(resp);
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  static Future<CihazDuzenlemeModel> cihazDuzenlemeGetir() async {
    var response = await BiltekPost.post(Ayarlar.cihazDuzenleme, {});
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        var map = jsonDecode(resp) as Map<String, dynamic>;

        return CihazDuzenlemeModel.fromJson(map);
      } on Exception catch (e) {
        debugPrint(e.toString());
        return CihazDuzenlemeModel.bos();
      }
    } else {
      debugPrint(
        "Cihaz Duzenleme yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
      return CihazDuzenlemeModel.bos();
    }
  }

  static Future<bool> cihazEkle({required Map<String, String> postData}) async {
    var response = await BiltekPost.post(Ayarlar.cihazEkle, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  static Future<bool> cihazDuzenle({
    required int id,
    required Map<String, String> postData,
  }) async {
    postData.addAll({"id": id.toString()});
    var response = await BiltekPost.post(Ayarlar.cihazDuzenle, postData);
    var resp = await response.stream.bytesToString();
    if (response.statusCode == 201) {
      try {
        Map<String, dynamic> map =
            jsonDecode("${resp.split("}")[0]}}") as Map<String, dynamic>;
        if (map.containsKey("sonuc") && map["sonuc"].toString() == "1") {
          return true;
        }
      } on Exception catch (e) {
        debugPrint(e.toString());
      }
    }
    return false;
  }

  static Future<List<MusteriModel>> musteriBilgileriGetir(
    String musteriAdi,
  ) async {
    Map<String, String> postMap = {};

    postMap.addAll({"ara": musteriAdi});

    var response = await BiltekPost.post(Ayarlar.musteriler, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        List<dynamic> musteriler = jsonDecode(resp) as List<dynamic>;
        return musteriler
            .map(
              (cihaz) => MusteriModel.fromJson(cihaz as Map<String, dynamic>),
            )
            .toList();
      } on Exception catch (e) {
        debugPrint("Musteri bilgileri yüklenirken bir hata oluştu. $e");
        return [];
      }
    } else {
      debugPrint("Musteri bilgileri yüklenirken bir hata oluştu.");
      return [];
    }
  }

  static Future<List<Lisans>> lisanslariGetir() async {
    Map<String, String> postMap = {};

    var response = await BiltekPost.post(Ayarlar.lisanslarTumu, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        List<dynamic> lisanslar = jsonDecode(resp) as List<dynamic>;
        return lisanslar
            .map((cihaz) => Lisans.fromJson(cihaz as Map<String, dynamic>))
            .toList();
      } on Exception {
        throw Exception(
          "Lisanslar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
        );
      }
    } else {
      throw Exception(
        "Lisanslar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
    }
  }

  static Future<bool> lisansEkle({
    required Map<String, String> postData,
  }) async {
    var response = await BiltekPost.post(Ayarlar.lisansEkle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception {
        return false;
      }
    } else {
      return false;
    }
  }

  static Future<bool> lisansDuzenle({
    required int id,
    required Map<String, String> postData,
  }) async {
    postData.addAll({"id": id.toString()});
    var response = await BiltekPost.post(Ayarlar.lisansDuzenle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception {
        return false;
      }
    } else {
      return false;
    }
  }

  static Future<bool> lisansSil(int id) async {
    Map<String, String> postMap = {"id": id.toString()};

    var response = await BiltekPost.post(Ayarlar.lisansSil, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception {
        return false;
      }
    } else {
      return false;
    }
  }

  static Future<List<Versiyon>> versiyonlariGetir() async {
    Map<String, String> postMap = {};

    var response = await BiltekPost.post(Ayarlar.versiyonlarTumu, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        List<dynamic> versiyonlar = jsonDecode(resp) as List<dynamic>;
        return versiyonlar
            .map((cihaz) => Versiyon.fromJson(cihaz as Map<String, dynamic>))
            .toList();
      } on Exception {
        throw Exception(
          "Versiyonlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
        );
      }
    } else {
      throw Exception(
        "Versiyonlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin",
      );
    }
  }

  static Future<bool> versiyonEkle({
    required Map<String, String> postData,
  }) async {
    var response = await BiltekPost.post(Ayarlar.versiyonEkle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception {
        return false;
      }
    } else {
      return false;
    }
  }

  static Future<bool> versiyonDuzenle({
    required int id,
    required Map<String, String> postData,
  }) async {
    postData.addAll({"id": id.toString()});
    var response = await BiltekPost.post(Ayarlar.versiyonDuzenle, postData);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception {
        return false;
      }
    } else {
      return false;
    }
  }

  static Future<bool> versiyonSil(int id) async {
    Map<String, String> postMap = {"id": id.toString()};

    var response = await BiltekPost.post(Ayarlar.versiyonSil, postMap);
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        debugPrint(resp);
        Map<String, dynamic> sonuc = jsonDecode(resp) as Map<String, dynamic>;
        if (sonuc.containsKey("durum")) {
          return sonuc["durum"] as bool;
        } else {
          return false;
        }
      } on Exception {
        return false;
      }
    } else {
      return false;
    }
  }
}
