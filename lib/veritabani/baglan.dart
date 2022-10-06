import 'dart:convert';
import 'dart:io';

import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;

import '../env.dart';

class Baglan {
  static Future<String> response({
    required String url,
    Map<String, String>? postVerileri,
  }) async {
    Map<String, String> tokenMap = {
      "token": Env.authToken,
    };
    if (postVerileri == null) {
      postVerileri = tokenMap;
    } else {
      postVerileri.addAll(tokenMap);
    }
    final headers = {
      HttpHeaders.accessControlAllowOriginHeader: "*",
      HttpHeaders.accessControlAllowCredentialsHeader: "true",
      HttpHeaders.accessControlAllowMethodsHeader:
          "GET, POST, OPTIONS, DELETE, PUT",
      HttpHeaders.accessControlMaxAgeHeader: "86400",
    };
    var body = json.encode(postVerileri);
    if (kDebugMode) {
      print("Body: $body");
    }
    var response = await http.post(
      Uri.parse(url),
      headers: headers,
      body: postVerileri,
    );
    if (kDebugMode) {
      print(response.body);
    }
    if (response.statusCode == 200) {
      return response.body;
    } else {
      return "";
    }
  }

  static Future<Map<String, dynamic>> map({
    required String url,
    Map<String, String>? postVerileri,
  }) async {
    return json.decode(await response(
      url: url,
      postVerileri: postVerileri,
    ));
  }

  static Future<List> list({
    required String url,
    Map<String, String>? postVerileri,
  }) async {
    return json.decode(await response(
      url: url,
      postVerileri: postVerileri,
    ));
  }
}
