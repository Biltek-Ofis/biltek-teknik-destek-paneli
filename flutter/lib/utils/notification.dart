import 'package:flutter/services.dart';

class NativeNotification {
  static const _channel = MethodChannel("teknikservis/notifications");

  static void init(Function(String tip, String id) onClick) {
    _channel.setMethodCallHandler((call) async {
      if (call.method == "notificationClicked") {
        final tip = call.arguments["tip"] as String;
        final id = call.arguments["id"] as String;
        onClick(tip, id);
      }
    });
  }
}
