import 'package:flutter/services.dart';

class NativeNotification {
  static const _channel = MethodChannel("teknikservis/notifications");

  static void init(Function(String tip) onClick) {
    _channel.setMethodCallHandler((call) async {
      if (call.method == "notificationClicked") {
        final tip = call.arguments["tip"] as String;
        onClick(tip);
      }
    });
  }
}
