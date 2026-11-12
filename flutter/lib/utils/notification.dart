import 'dart:async';

import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../models/kullanici.dart';
import 'common.dart';
import 'post.dart';

class NativeNotification {
  static const _channel = MethodChannel("biltekteknikservis/notifications");

  static void init(Function(String tip, String id) onClick) {
    _channel.setMethodCallHandler((call) async {
      if (call.method == "notificationClicked") {
        final tip = call.arguments["tip"] as String;
        final id = call.arguments["id"] as String;
        onClick(tip, id);
      }
    });
  }

  static Future<bool> _webBildirimIzniGerekli() async {
    if (!kIsWeb) return false;
    try {
      final s = await FirebaseMessaging.instance.getNotificationSettings();
      biltekPrint("Bildirim durumu: ${s.authorizationStatus}");
      return s.authorizationStatus == AuthorizationStatus.notDetermined;
    } catch (_) {
      return false;
    }
  }

  static bool _dialogGosterildi = false;
  static Future<void> webBildirimDialogGoster(
    BuildContext context, {
    required KullaniciAuthModel kullanici,
  }) async {
    if (!kIsWeb) return;
    if (_dialogGosterildi) return;
    _dialogGosterildi = true;
    if (!await _webBildirimIzniGerekli()) return;
    if (!context.mounted) return;

    await showDialog(
      context: context,
      barrierDismissible: false,
      builder: (ctx) => AlertDialog(
        title: const Text('Bildirimler'),
        content: const Text(
          'Bildirim almak için izin vermeniz gerekmektedir. İzin vermek ister misiniz?',
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(ctx).pop(),
            child: const Text('Şimdi değil'),
          ),
          ElevatedButton(
            onPressed: () {
              registerMessaging(kullanici: kullanici, izinIste: true);
              Navigator.of(ctx).pop();
            },
            child: const Text('Bildirimleri etkinleştir'),
          ),
        ],
      ),
    );
  }

  static StreamSubscription<String>? fcmStream;
  static Future<void> registerMessaging({
    required KullaniciAuthModel kullanici,
    bool izinIste = false,
  }) async {
    if (fcmStream != null) {
      biltekPrint("FirebaseMessaging zaten kaydedilmiş.");
      return;
    }
    NotificationSettings settings;
    try {
      if (izinIste || !kIsWeb) {
        settings = await FirebaseMessaging.instance.requestPermission(
          provisional: true,
        );
      } else {
        settings = await FirebaseMessaging.instance.getNotificationSettings();
      }
    } on FirebaseException catch (e) {
      biltekPrint("FCM izin hatası: ${e.code} - ${e.message}");
      return;
    } catch (e) {
      biltekPrint("FCM izin beklenmeyen hata: $e");
      return;
    }
    if (settings.authorizationStatus != AuthorizationStatus.authorized &&
        settings.authorizationStatus != AuthorizationStatus.provisional) {
      biltekPrint("Bildirim izni verilmedi: ${settings.authorizationStatus}");
      return;
    }
    fcmStream = FirebaseMessaging.instance.onRegistered.listen((
      fcmToken,
    ) async {
      try {
        await BiltekPost.of(kullanici.auth)
            .fcmTokenGuncelle(kullanici.auth, fcmToken);
      } catch (e) {
        biltekPrint("FCM token güncellenemedi: $e");
      }
    });
    fcmStream?.onError((err) {
      biltekPrint("Failed to get fcm token");
    });
    try {
      await FirebaseMessaging.instance.register();
    } catch (e) {
      biltekPrint("FCM register hatası: $e");
      unregisterMessaging();
    }
  }

  static void unregisterMessaging() {
    if (fcmStream != null) {
      fcmStream?.cancel();
      fcmStream = null;
    }
  }

  static Future<void> bildirimBaslat(
    BuildContext context, {
    required KullaniciAuthModel kullanici,
  }) async {
    if (!kIsWeb) {
      await registerMessaging(kullanici: kullanici);
      return;
    }
    if (await _webBildirimIzniGerekli()) {
      if (!context.mounted) return;
      await webBildirimDialogGoster(context, kullanici: kullanici);
    } else {
      await registerMessaging(kullanici: kullanici);
    }
  }
}
