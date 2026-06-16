import 'dart:convert';

import 'package:flutter/services.dart';

class YaziciModel {
  static const _channel = MethodChannel("biltekteknikservis/printer");

  static int defaultPort = 9100;

  final String id;
  final String ip;
  final int port;
  final String isim;

  const YaziciModel({required this.ip, required this.port, required this.isim})
    : id = '$ip:$port';

  factory YaziciModel.fromJson(Map<String, dynamic> json) {
    return YaziciModel(
      ip: json["ip"] ?? "",
      port: int.tryParse(json["port"]) ?? defaultPort,
      isim: json["isim"] ?? "",
    );
  }

  bool get portIsDefault => port == defaultPort;

  Map<String, dynamic> toMap() {
    return {"ip": ip, "port": port, "isim": isim};
  }

  @override
  String toString() {
    return jsonEncode(toMap());
  }

  Future<void> yaziciyiKaydet() async {
    await _channel.invokeMethod('registerPrinter', {
      'ip': ip,
      'port': port,
      'isim': isim,
    });
  }

  static Future<void> loadSavedPrinters() async {
    final printers = await getAndroidPrinters();
    if (printers.isEmpty) return;

    final jsonStr = jsonEncode(printers.map((e) => e.toMap()).toList());
    await _channel.invokeMethod('registerAllPrinters', {'printers': jsonStr});
  }

  static Future<List<YaziciModel>> getAndroidPrinters() async {
    try {
      final String? jsonStr = await _channel.invokeMethod<String>(
        'getPrinters',
      );
      if (jsonStr == null || jsonStr == '[]') return [];
      final list = jsonDecode(jsonStr) as List;
      return list
          .map((e) => YaziciModel.fromJson(e as Map<String, dynamic>))
          .toList();
    } catch (_) {
      return [];
    }
  }

  Future<bool> registerPrinter() async {
    try {
      await _channel.invokeMethod('registerPrinter', {
        'ip': ip,
        'port': port,
        'name': isim,
      });

      return true;
    } catch (_) {
      return false;
    }
  }

  static Future<void> registerAllPrinters(List<YaziciModel> yazicilar) async {
    if (yazicilar.isEmpty) return;
    final jsonStr = jsonEncode(yazicilar.map((e) => e.toMap()).toList());
    await _channel.invokeMethod('registerAllPrinters', {'printers': jsonStr});
  }

  Future<void> removePrinter() async {
    await _channel.invokeMethod('removePrinter', {'id': id});
  }

  static Future<void> openPrintSettings() async {
    await _channel.invokeMethod('openPrintSettings');
  }

  static Future<void> clearPrinters() async {
    await _channel.invokeMethod('clearPrinters');
  }
}
