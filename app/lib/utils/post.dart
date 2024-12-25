import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:biltekteknikservis/models/cihaz.dart';
import 'package:package_info_plus/package_info_plus.dart';

import '../ayarlar.dart';
import '../models/kullanici.dart';
import 'shared_preferences.dart';

class BiltekPost {
  static Future<http.StreamedResponse> post(
      String url, Map<String, String> data) async {
    data.addAll({
      "token": Ayarlar.token,
    });

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
        return packageInfo.version != resp;
      } else {
        return false;
      }
    } on Exception {
      return false;
    }
  }

  static Future<KullaniciModel?> kullaniciGetir(String auth) async {
    var response = await BiltekPost.post(
      Ayarlar.kullaniciGetir,
      {
        "auth": auth,
      },
    );
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      debugPrint(resp);
      KullaniciGetirModel kullaniciGetir = KullaniciGetirModel.fromJson(
          jsonDecode(resp) as Map<String, dynamic>);
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
      postMap.addAll({
        "sorumlu": sorumlu.toString(),
      });
    }
    if (arama != null) {
      postMap.addAll({
        "arama": arama,
      });
    }
    if (specific.isNotEmpty) {
      postMap.addAll({
        "specific": jsonEncode(specific),
      });
    }
    var response = await BiltekPost.post(
      Ayarlar.cihazlarTumu,
      postMap,
    );
    if (response.statusCode == 201) {
      var resp = await response.stream.bytesToString();
      try {
        List<dynamic> cihazlar = jsonDecode(resp) as List<dynamic>;
        return cihazlar
            .map((cihaz) => Cihaz.fromJson(cihaz as Map<String, dynamic>))
            .toList();
      } on Exception {
        throw Exception(
            "Cihazlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin");
      }
    } else {
      throw Exception(
          "Cihazlar yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin");
    }
  }

  static Future<Cihaz?> cihazGetir({
    required int servisNo,
  }) async {
    var response = await BiltekPost.post(
      Ayarlar.tekCihaz,
      {"servis_no": servisNo.toString()},
    );
    var resp = await response.stream.bytesToString();
    debugPrint(resp);
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
          "Cihaz yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin");
      return null;
    }
  }

  static Future<void> fcmToken({
    required String auth,
    required String fcmToken,
  }) async {
    var response = await BiltekPost.post(
      Ayarlar.fcmToken,
      {
        "auth": auth,
        "fcmToken": fcmToken,
      },
    );
    await response.stream.bytesToString();
  }

  static Future<void> fcmTokenSifirla({
    required String? fcmToken,
  }) async {
    if (fcmToken != null) {
      var response = await BiltekPost.post(
        Ayarlar.fcmTokenSifirla,
        {
          "fcmToken": fcmToken,
        },
      );
      await response.stream.bytesToString();
    }
  }

  static Future<void> fcmTokenGuncelle(String auth, String? fcmToken) async {
    if (fcmToken != null) {
      await SharedPreference.setString(
          SharedPreference.fcmTokenString, fcmToken);
      await BiltekPost.fcmToken(
        auth: auth,
        fcmToken: fcmToken,
      );
    }
  }

  static Future<void> bilgisayardaAc({
    required int kullaniciID,
    required int servisNo,
  }) async {
    try {
      var response = await BiltekPost.post(
        Ayarlar.bilgisayardaAc,
        {
          "kullanici_id": kullaniciID.toString(),
          "servis_no": servisNo.toString(),
        },
      );
      await response.stream.bytesToString();
    } on Exception {
      debugPrint("Bilgisayarda ac çalışmadı");
    }
  }
}
