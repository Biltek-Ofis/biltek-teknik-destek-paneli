import 'dart:convert';

import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:universal_io/io.dart';

import 'shared_preferences.dart';

class BarkodOkuyucu {
  final String ip;
  final int port;

  static const int varsayilanPort = 9200;

  BarkodOkuyucu._(
    this.ip, {
    this.port = varsayilanPort,
  });

  static Future<BarkodOkuyucu?> getir() async {
    String? ip = await SharedPreference.getString(SharedPreference.barkodIP);
    int? port = await SharedPreference.getInt(SharedPreference.barkodPort);
    if (ip != null && ip.isNotEmpty) {
      if (port != null && port > 0) {
        return BarkodOkuyucu._(ip, port: port);
      } else {
        return BarkodOkuyucu._(ip);
      }
    } else {
      return null;
    }
  }

  Future<void> eslestir() async {
    await _mesajGonder("eslesti");
  }

  Future<void> pcKapa() async {
    await _mesajGonder("cmd:shutdown -s -t 10");
  }

  Future<void> komut(String komut) async {
    await _mesajGonder("cmd:$komut");
  }

  Future<void> servisNo(int servisNo) async {
    await _mesajGonder("servisNo:$servisNo");
  }

  Future<void> _mesajGonder(String mesaj) async {
    Socket? socket;
    try {
      String? ip = await SharedPreference.getString(SharedPreference.barkodIP);
      int? port = await SharedPreference.getInt(SharedPreference.barkodPort);
      if (ip != null && port != null) {
        socket = await Socket.connect(ip, port);
        debugPrint('connected');

        socket.listen((List<int> event) {
          debugPrint(utf8.decode(event));
        });

        socket.write(mesaj);

        await Future.delayed(Duration(seconds: 5));

        socket.close();
      }
    } on Exception catch (e) {
      debugPrint(e.toString());
      socket?.close();
    }
  }
}
