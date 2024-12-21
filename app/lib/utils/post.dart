import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

import '../ayarlar.dart';
import '../models/kullanici.dart';

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

    debugPrint(url.toString());

    return response;
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
}
