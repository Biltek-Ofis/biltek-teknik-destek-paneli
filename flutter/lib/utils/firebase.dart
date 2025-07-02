import 'package:firebase_app_check/firebase_app_check.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/foundation.dart';

import '../firebase_ayarlari.dart';
import '../widgets/overlay_notification.dart';

class FirebaseApi {
  static FirebaseApp? instance;
  static FirebaseAppCheck get appCheck => FirebaseAppCheck.instance;

  static Future<void> initialize() async {
    instance ??= await Firebase.initializeApp(
      options: DefaultFirebaseOptions.currentPlatform,
    );

    await FirebaseAppCheck.instance.activate(
      androidProvider:
          kDebugMode ? AndroidProvider.debug : AndroidProvider.playIntegrity,
      appleProvider: kDebugMode ? AppleProvider.debug : AppleProvider.appAttest,
    );

    FirebaseMessaging.onMessage.listen((message) {
      showNotification(
        title: message.notification?.title,
        body: message.notification?.body,
      );
    });
  }
}
